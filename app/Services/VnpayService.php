<?php

namespace App\Services;

use App\Models\Admins\Tour;
use App\Models\BookTour;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Đóng gói việc dựng URL thanh toán VNPay (ký HMAC-SHA512) và xử lý callback trả về,
 * tách khỏi Controller theo đúng nguyên tắc single responsibility.
 */
class VnpayService
{
    private string $vnpUrl;
    private string $tmnCode;
    private string $hashSecret;

    public function __construct()
    {
        $this->vnpUrl = config('services.vnpay.url', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
        $this->tmnCode = config('services.vnpay.tmn_code', 'GKKOYDOM');
        $this->hashSecret = (string) config('services.vnpay.hash_secret', '');
    }

    public function buildPaymentUrl(Payment $payment, Request $request, string $returnUrl, ?string $bankCode = null): string
    {
        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => $this->tmnCode,
            'vnp_Amount' => (int) round($payment->money * 100),
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => now()->format('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $request->ip(),
            'vnp_Locale' => 'vn',
            'vnp_OrderInfo' => 'Thanh toan don hang #' . $payment->id,
            'vnp_OrderType' => 'billpayment',
            'vnp_ReturnUrl' => $returnUrl,
            'vnp_TxnRef' => $payment->id,
        ];

        if ($bankCode) {
            $inputData['vnp_BankCode'] = $bankCode;
        }

        ksort($inputData);

        $hashData = '';
        $query = '';
        $first = true;

        foreach ($inputData as $key => $value) {
            $query .= ($first ? '' : '&') . urlencode($key) . '=' . urlencode((string) $value);
            $hashData .= ($first ? '' : '&') . urlencode($key) . '=' . urlencode((string) $value);
            $first = false;
        }

        $secureHash = hash_hmac('sha512', $hashData, $this->hashSecret);

        return $this->vnpUrl . '?' . $query . '&vnp_SecureHash=' . $secureHash;
    }

    /**
     * Xử lý dữ liệu VNPay gửi về sau khi thanh toán, cập nhật trạng thái payment tương ứng.
     *
     * @return array{success: bool, payment: ?Payment}
     */
    public function handleReturn(Request $request): array
    {
        $paymentId = $request->input('vnp_TxnRef');
        $responseCode = $request->input('vnp_ResponseCode');
        $transactionNo = $request->input('vnp_TransactionNo');

        if (!$this->isValidReturnSignature($request)) {
            return ['success' => false, 'payment' => null, 'message' => 'Chữ ký VNPay không hợp lệ.'];
        }

        $payment = Payment::find($paymentId);

        if (!$payment) {
            return ['success' => false, 'payment' => null, 'message' => 'Không tìm thấy giao dịch!'];
        }

        $payment->vnp_response_code = $responseCode;
        $payment->transaction = $paymentId;
        $payment->code_vnpay = $transactionNo;

        if ($responseCode === '00') {
            $payment->payment_status_id = DB::table('payment_statuses')->where('name', 'Đã thanh toán')->value('id');
            $payment->save();

            $booking = BookTour::find($payment->booking_id);
            $tour = $booking ? Tour::find($booking->tour_id) : null;
            if ($tour && $tour->number > 0) {
                $tour->decrement('number');
            }

            return ['success' => true, 'payment' => $payment, 'message' => 'Thanh toán thành công!'];
        }

        $payment->status_id = DB::table('statuses')->where('name', 'Đã huỷ')->value('id');
        $payment->save();

        return ['success' => false, 'payment' => $payment, 'message' => 'Thanh toán đã bị hủy hoặc thất bại!'];
    }
    private function isValidReturnSignature(Request $request): bool
    {
        $received = (string) $request->input('vnp_SecureHash', '');
        if ($received === '' || $this->hashSecret === '') {
            return false;
        }

        $data = $request->except(['vnp_SecureHash', 'vnp_SecureHashType']);
        ksort($data);

        $hashData = collect($data)
            ->filter(fn ($value) => $value !== null && $value !== '')
            ->map(fn ($value, $key) => urlencode($key) . '=' . urlencode((string) $value))
            ->implode('&');

        $calculated = hash_hmac('sha512', $hashData, $this->hashSecret);

        return hash_equals($calculated, $received);
    }

}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\Api\ApiException;
use App\Http\Requests\Api\Payment\StorePaymentRequest;
use App\Http\Requests\Api\Payment\UpdatePaymentRequest;
use App\Http\Requests\Api\Payment\VnpayCreateRequest;
use App\Http\Resources\Api\PaymentResource;
use App\Models\Payment;
use App\Services\PaymentService;
use App\Services\VnpayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentService $paymentService,
        private readonly VnpayService $vnpayService,
    ) {
    }

    public function index(Request $request)
    {
        $payments = Payment::with(['bookTour', 'paymentMethod', 'paymentStatus'])
            ->where('user_id', $request->user()->id)
            ->orderByDesc('id')
            ->paginate(min(max((int) $request->input('per_page', 10), 1), 50));

        return $this->success(PaymentResource::collection($payments), 'Danh sách thanh toán.');
    }

    public function store(StorePaymentRequest $request)
    {
        try {
            $payment = $this->paymentService->createDirectPayment($request->validated(), $request);
        } catch (ApiException $e) {
            return $this->error($e->getMessage(), $e->getStatusCode());
        }

        return $this->created(new PaymentResource($payment->load(['paymentMethod', 'paymentStatus'])), 'Tạo thanh toán thành công.');
    }

    public function show(string $id)
    {
        $payment = Payment::with(['bookTour', 'paymentMethod', 'paymentStatus'])->find($id);

        if (!$payment) {
            return $this->notFound('Không tìm thấy thông tin thanh toán.');
        }

        return $this->success(new PaymentResource($payment), 'Chi tiết thanh toán.');
    }

    public function update(UpdatePaymentRequest $request, string $id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return $this->notFound('Không tìm thấy thông tin thanh toán.');
        }

        if ((int) $payment->user_id !== (int) $request->user()->id) {
            return $this->forbidden('Bạn không có quyền sửa giao dịch này.');
        }

        $payment->update($request->validated());

        return $this->success(
            new PaymentResource($payment->fresh()->load(['paymentMethod', 'paymentStatus'])),
            'Cập nhật thanh toán thành công.'
        );
    }

    public function destroy(Request $request, string $id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return $this->notFound('Không tìm thấy thông tin thanh toán.');
        }

        if ((int) $payment->user_id !== (int) $request->user()->id) {
            return $this->forbidden('Bạn không có quyền xóa giao dịch này.');
        }

        $payment->delete();

        return $this->success(null, 'Xóa giao dịch thanh toán thành công.');
    }

    public function vnpayCreate(VnpayCreateRequest $request)
    {
        try {
            $payment = $this->paymentService->preparePendingPayment($request->validated(), $request);
        } catch (ApiException $e) {
            return $this->error($e->getMessage(), $e->getStatusCode());
        }

        $returnUrl = route('v1.payments.vnpay.return');
        $paymentUrl = $this->vnpayService->buildPaymentUrl($payment, $request, $returnUrl, $request->input('bank_code'));

        return $this->success([
            'payment_id' => $payment->id,
            'payment_url' => $paymentUrl,
        ], 'Tạo giao dịch VNPay thành công.');
    }

    public function vnpayReturn(Request $request)
    {
        $result = $this->vnpayService->handleReturn($request);

        if (!$result['payment']) {
            return $this->notFound($result['message']);
        }

        if (!$result['success']) {
            return $this->error($result['message'], 422, new PaymentResource($result['payment']));
        }

        return $this->success(new PaymentResource($result['payment']), $result['message']);
    }

    public function vnpayCancel(Request $request)
    {
        $payment = Payment::where('transaction', $request->input('vnp_TxnRef'))->first();

        if ($payment) {
            $cancelledStatusId = \Illuminate\Support\Facades\DB::table('statuses')->where('name', 'Đã hủy')->value('id');
            $payment->update(['status_id' => $cancelledStatusId]);
        }

        return $this->success(null, 'Thanh toán VNPay đã bị huỷ.');
    }
}

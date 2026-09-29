<?php

namespace App\Services;

use App\Exceptions\Api\ApiException;
use App\Models\Admins\Tour;
use App\Models\BookTour;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Đóng gói logic tạo bản ghi thanh toán (payments) cho một đơn đặt tour,
 * dùng chung cho cả thanh toán trực tiếp và bước khởi tạo thanh toán VNPay.
 */
class PaymentService
{
    public function __construct(private readonly CustomerResolver $customerResolver)
    {
    }

    /**
     * @throws ApiException
     */
    public function createDirectPayment(array $data, Request $request): Payment
    {
        $booking = BookTour::find($data['booking_id']);
        if (!$booking) {
            throw new ApiException('Không tìm thấy đơn đặt tour.', 404);
        }

        $tour = Tour::find($booking->tour_id);

        if (!$tour) {
            throw new ApiException('Không tìm thấy thông tin tour!', 404);
        }

        if ((int) $tour->status === 0) {
            throw new ApiException('Tour này đã bị ẩn và không thể thanh toán!', 422);
        }

        $paymentMethod = PaymentMethod::find($data['payment_method_id']);
        if (!$paymentMethod) {
            throw new ApiException('Phương thức thanh toán không hợp lệ!', 422);
        }

        $coupon = !empty($data['coupon_code']) ? Coupon::where('code', $data['coupon_code'])->first() : null;

        $resolved = $this->customerResolver->resolve($request, [
            'name' => $booking->name,
            'email' => $booking->email,
            'phone' => $booking->phone,
        ]);

        $payment = DB::transaction(function () use ($data, $booking, $paymentMethod, $coupon, $resolved) {
            $pendingStatusId = DB::table('payment_statuses')->where('name', 'Chưa thanh toán')->value('id');

            $payment = Payment::create([
                'booking_id' => $booking->id,
                'customer_id' => $resolved->customerId,
                'user_id' => $resolved->userId,
                'money' => $booking->total_money,
                'p_note' => $data['p_note'] ?? null,
                'payment_status_id' => $pendingStatusId,
                'payment_method_id' => $paymentMethod->id,
                'coupon_id' => $coupon->id ?? null,
                'status_id' => 1,
                'time' => now(),
            ]);

            $booking->update(['pay_id' => $payment->id]);

            if ($coupon && $coupon->number > 0) {
                $coupon->decrement('number', 1);
            }

            return $payment;
        });

        return $payment;
    }

    /**
     * Chuẩn bị bản ghi payment "chờ thanh toán" trước khi chuyển hướng sang VNPay.
     *
     * @throws ApiException
     */
    public function preparePendingPayment(array $data, Request $request): Payment
    {
        $booking = BookTour::find($data['booking_id']);

        if (!$booking) {
            throw new ApiException('Không tìm thấy đơn đặt tour.', 404);
        }

        $resolved = $this->customerResolver->resolve($request, [
            'name' => $booking->name,
            'email' => $booking->email,
            'phone' => $booking->phone,
        ]);

        $vnpayMethodId = PaymentMethod::whereRaw('LOWER(name) = ?', ['vnpay'])->value('id');
        if (!$vnpayMethodId) {
            throw new ApiException('Chưa cấu hình phương thức thanh toán VNPay.', 422);
        }
        $pendingStatusId = DB::table('payment_statuses')->where('name', 'Chưa thanh toán')->value('id');

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'user_id' => $resolved->userId,
            'customer_id' => $resolved->customerId,
            'money' => $booking->total_money,
            'p_note' => $data['p_note'] ?? '',
            'payment_method_id' => $vnpayMethodId,
            'payment_status_id' => $pendingStatusId,
            'time' => now(),
        ]);

        $booking->update(['pay_id' => $payment->id]);

        return $payment;
    }
}

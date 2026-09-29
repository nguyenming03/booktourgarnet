<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\Api\ApiException;
use App\Http\Requests\Api\Booking\CancelBookingRequest;
use App\Http\Requests\Api\Booking\StoreBookingRequest;
use App\Http\Requests\Api\Booking\UpdateBookingRequest;
use App\Http\Resources\Api\BookingResource;
use App\Http\Resources\Api\CouponResource;
use App\Models\BookTour;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(private readonly BookingService $bookingService)
    {
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $bookings = BookTour::with(['tour', 'pay'])
            ->where('user_id', $user->id)
            ->orderByDesc('id')
            ->paginate(min(max((int) $request->input('per_page', 10), 1), 50));

        return $this->success(BookingResource::collection($bookings), 'Danh sách đơn đặt tour.');
    }

    public function store(StoreBookingRequest $request)
    {
        try {
            $result = $this->bookingService->create($request->validated(), $request);
        } catch (ApiException $e) {
            return $this->error($e->getMessage(), $e->getStatusCode(), $e->getErrors());
        }

        return $this->created([
            'booking' => new BookingResource($result['booking']),
            'temporary_user_id' => $result['temporary_user_id'],
            'coupon' => $result['coupon'] ? new CouponResource($result['coupon']) : null,
        ], 'Đặt tour thành công! Vui lòng tiếp tục sang bước thanh toán.');
    }

    public function show(string $id)
    {
        $booking = BookTour::with(['tour.location', 'tour.category_tour', 'tour.images', 'pay'])->find($id);

        if (!$booking) {
            return $this->notFound('Không tìm thấy đơn đặt tour.');
        }

        return $this->success(new BookingResource($booking), 'Chi tiết đơn đặt tour.');
    }

    public function update(UpdateBookingRequest $request, string $id)
    {
        $booking = BookTour::find($id);

        if (!$booking) {
            return $this->notFound('Không tìm thấy đơn đặt tour.');
        }

        if ((int) $booking->user_id !== (int) $request->user()->id) {
            return $this->forbidden('Bạn không có quyền sửa đơn đặt tour này.');
        }

        if (in_array($booking->status, ['huy_tour', 'da_hoan_thanh'], true)) {
            return $this->error('Đơn đã hủy hoặc đã hoàn thành nên không thể sửa.', 409);
        }

        $booking->update($request->validated());

        return $this->success(
            new BookingResource($booking->fresh()->load(['tour', 'pay'])),
            'Cập nhật đơn đặt tour thành công.'
        );
    }

    public function destroy(Request $request, string $id)
    {
        $booking = BookTour::find($id);

        if (!$booking) {
            return $this->notFound('Không tìm thấy đơn đặt tour.');
        }

        if ((int) $booking->user_id !== (int) $request->user()->id) {
            return $this->forbidden('Bạn không có quyền xóa đơn đặt tour này.');
        }

        if (!in_array($booking->status, ['cho_xac_nhan', 'huy_tour'], true)) {
            return $this->error('Chỉ có đơn đang chờ xác nhận hoặc đã hủy mới được xóa.', 409);
        }

        $booking->delete();

        return $this->success(null, 'Xóa đơn đặt tour thành công.');
    }

    public function myBookings(Request $request)
    {
        return $this->index($request);
    }

    public function cancel(CancelBookingRequest $request, string $id)
    {
        $booking = BookTour::find($id);

        if (!$booking) {
            return $this->notFound('Không tìm thấy đơn đặt tour.');
        }

        $currentUser = auth('sanctum')->user();

        if ($booking->user_id && (!$currentUser || $booking->user_id !== $currentUser->id)) {
            return $this->forbidden('Bạn không có quyền hủy đơn này.');
        }

        try {
            $booking = $this->bookingService->cancel($booking, $request->input('ly_do_huy'));
        } catch (ApiException $e) {
            return $this->error($e->getMessage(), $e->getStatusCode());
        }

        return $this->success(new BookingResource($booking), 'Đơn đặt tour đã được hủy.');
    }
}

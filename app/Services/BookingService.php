<?php

namespace App\Services;

use App\Exceptions\Api\ApiException;
use App\Models\Admins\DonTour;
use App\Models\Admins\Tour;
use App\Models\BookTour;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Đóng gói toàn bộ logic nghiệp vụ tạo đơn đặt tour, tách khỏi Controller
 * để dễ tái sử dụng (API, có thể dùng lại cho web) và dễ kiểm thử.
 */
class BookingService
{
    public function __construct(private readonly CustomerResolver $customerResolver)
    {
    }

    /**
     * @throws ApiException khi tour không hợp lệ để đặt
     */
    public function create(array $data, \Illuminate\Http\Request $request): array
    {
        $tour = Tour::find($data['tour_id']);

        if (!$tour) {
            throw new ApiException('Không tìm thấy tour.', 404);
        }

        if ((int) $tour->status !== 1) {
            throw new ApiException('Tour này hiện không khả dụng để đặt.', 422);
        }

        $startDate = Carbon::parse($tour->start_date);
        $endDate = Carbon::parse($tour->end_date);

        if ($startDate->startOfDay()->lessThanOrEqualTo(Carbon::today())) {
            throw new ApiException('Ngày khởi hành phải sau ngày đặt. Tour này không còn ngày khởi hành hợp lệ.', 422);
        }

        if ($endDate->lt($startDate)) {
            throw new ApiException('Ngày kết thúc của tour không hợp lệ.', 422);
        }

        $totalGuests = $data['number_old'] + $data['number_children'];
        if ($tour->number !== null && $totalGuests > $tour->number) {
            throw new ApiException('Số lượng khách vượt quá số chỗ còn trống của tour.', 422);
        }

        $coupon = null;
        if (!empty($data['coupon_code'])) {
            $coupon = \App\Models\Coupon::where('code', $data['coupon_code'])
                ->where('tour_id', $data['tour_id'])
                ->where('status', 1)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->where('number', '>', 0)
                ->first();

            if (!$coupon) {
                throw new ApiException('Mã giảm giá không hợp lệ hoặc đã hết hạn.', 422);
            }
        }

        // Không tin total_money do client gửi lên. Giá được tính lại từ
        // bảng tours để tránh việc client tự sửa giá trong request.
        $adultPrice = (float) $tour->price_old;
        $childPrice = $tour->price_children !== null
            ? (float) $tour->price_children
            : $adultPrice;
        $salePercent = max(0, min(100, (float) ($tour->sale ?? 0)));

        $adultPrice *= (1 - $salePercent / 100);
        $childPrice *= (1 - $salePercent / 100);

        $subtotal = ($adultPrice * (int) $data['number_old'])
            + ($childPrice * (int) $data['number_children']);

        $discountPercent = $coupon ? (float) $coupon->percentage_price : 0;
        $totalMoney = round($subtotal * (1 - $discountPercent / 100), 2);

        $resolved = $this->customerResolver->resolve($request, [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        $booking = DB::transaction(function () use ($data, $resolved, $startDate, $endDate, $totalMoney) {
            $booking = BookTour::create([
                'customer_id' => $resolved->customerId,
                'user_id' => $resolved->userId,
                'tour_id' => $data['tour_id'],
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'date_booking' => now(),
                'start_date' => $startDate->toDateTimeString(),
                'end_date' => $endDate->toDateTimeString(),
                'note' => $data['note'] ?? null,
                'number_old' => $data['number_old'],
                'number_children' => $data['number_children'],
                'total_money' => $totalMoney,
                'status' => DonTour::CHO_XAC_NHAN,
                'sale' => 0,
            ]);

            $this->copyTourLocations($booking->id, $data['tour_id']);

            return $booking;
        });

        $booking->load('tour');

        return [
            'booking' => $booking,
            'temporary_user_id' => $resolved->temporaryUserId,
            'coupon' => $coupon,
        ];
    }

    /**
     * Hủy một đơn đặt tour, đảm bảo tuân theo đúng luồng trạng thái
     * (không thể hủy đơn đã hoàn thành, không hủy 2 lần).
     */
    public function cancel(BookTour $booking, ?string $reason = null): BookTour
    {
        if ($booking->status === DonTour::HUY_TOUR) {
            throw new ApiException('Đơn hàng đã bị hủy trước đó.', 422);
        }

        if ($booking->status === DonTour::DA_HOAN_THANH) {
            throw new ApiException('Đơn hàng đã hoàn thành, không thể hủy.', 422);
        }

        $booking->status = DonTour::HUY_TOUR;
        if ($reason) {
            $booking->ly_do_huy = $reason;
        }
        $booking->save();

        return $booking;
    }

    /**
     * Sao chép lịch trình từ bảng tour_locations sang customer_tour_locations cho đơn đặt.
     */
    private function copyTourLocations(int $bookingId, int $tourId): void
    {
        $tourLocations = DB::table('tour_locations')->where('tour_id', $tourId)->get();

        if ($tourLocations->isEmpty()) {
            return;
        }

        $rows = $tourLocations->map(fn ($location) => [
            'booking_id' => $bookingId,
            'start' => $location->start ?? null,
            'end' => $location->end ?? null,
            'description' => $location->description ?? null,
            'status' => 0,
            'suco' => $location->suco ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        DB::table('customer_tour_locations')->insert($rows);
    }
}

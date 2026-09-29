<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\Coupon\StoreCouponRequest;
use App\Http\Requests\Api\Coupon\UpdateCouponRequest;
use App\Http\Requests\Api\Coupon\ValidateCouponRequest;
use App\Http\Resources\Api\CouponResource;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::where('status', 1)
            ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now())
            ->where('number', '>', 0)
            ->with('tour')
            ->orderByDesc('created_at')
            ->get();

        return $this->success(CouponResource::collection($coupons), 'Danh sách mã giảm giá.');
    }

    public function manageIndex(Request $request)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $coupons = Coupon::with('tour')->orderByDesc('id')->paginate(50);

        return $this->success(CouponResource::collection($coupons), 'Danh sách tất cả mã giảm giá.');
    }

    public function store(StoreCouponRequest $request)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $coupon = Coupon::create($request->validated());
        $coupon->load('tour');

        return $this->created(new CouponResource($coupon), 'Tạo mã giảm giá thành công.');
    }

    public function show(string $id)
    {
        $coupon = Coupon::with('tour')->find($id);

        if (!$coupon) {
            return $this->notFound('Không tìm thấy mã giảm giá.');
        }

        return $this->success(new CouponResource($coupon), 'Chi tiết mã giảm giá.');
    }

    public function update(UpdateCouponRequest $request, string $id)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return $this->notFound('Không tìm thấy mã giảm giá.');
        }

        $coupon->update($request->validated());
        $coupon->load('tour');

        return $this->success(new CouponResource($coupon), 'Cập nhật mã giảm giá thành công.');
    }

    public function destroy(Request $request, string $id)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return $this->notFound('Không tìm thấy mã giảm giá.');
        }

        $coupon->delete();

        return $this->success(null, 'Xóa mã giảm giá thành công.');
    }

    public function validateCoupon(ValidateCouponRequest $request)
    {
        $coupon = Coupon::where('code', $request->code)
            ->where('tour_id', $request->tour_id)
            ->where('status', 1)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('number', '>', 0)
            ->first();

        if (!$coupon) {
            return $this->error('Mã giảm giá không hợp lệ hoặc đã hết hạn.', 422);
        }

        return $this->success(new CouponResource($coupon), 'Mã giảm giá hợp lệ.');
    }
}

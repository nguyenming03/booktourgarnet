<?php

namespace App\Http\Requests\Api\Coupon;

use App\Http\Requests\Api\BaseApiRequest;

class StoreCouponRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'tour_id' => ['required', 'integer', 'exists:tours,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:coupons,code'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'percentage_price' => ['required', 'numeric', 'min:0'],
            'type' => ['required', 'string', 'max:50'],
            'number' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'boolean'],
        ];
    }
}

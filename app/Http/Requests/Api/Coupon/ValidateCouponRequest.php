<?php

namespace App\Http\Requests\Api\Coupon;

use App\Http\Requests\Api\BaseApiRequest;

class ValidateCouponRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'code' => 'required|string|max:255',
            'tour_id' => 'required|integer|exists:tours,id',
        ];
    }
}

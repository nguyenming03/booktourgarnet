<?php

namespace App\Http\Requests\Api\Payment;

use App\Http\Requests\Api\BaseApiRequest;

class StorePaymentRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'booking_id' => 'required|integer|exists:book_tour,id',
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'money' => 'required|numeric|min:0',
            'p_note' => 'nullable|string|max:255',
            'coupon_code' => 'nullable|string|max:255',
        ];
    }
}

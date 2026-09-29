<?php

namespace App\Http\Requests\Api\Payment;

use App\Http\Requests\Api\BaseApiRequest;

class VnpayCreateRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'booking_id' => 'required|integer|exists:book_tour,id',
            'money' => 'required|numeric|min:0',
            'p_note' => 'nullable|string|max:255',
            'bank_code' => 'nullable|string|max:20',
        ];
    }
}

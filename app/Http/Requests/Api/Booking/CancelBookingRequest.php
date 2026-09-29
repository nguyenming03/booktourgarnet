<?php

namespace App\Http\Requests\Api\Booking;

use App\Http\Requests\Api\BaseApiRequest;

class CancelBookingRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'ly_do_huy' => 'nullable|string|max:500',
        ];
    }
}

<?php

namespace App\Http\Requests\Api\Payment;

use App\Http\Requests\Api\BaseApiRequest;

class UpdatePaymentRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'p_note' => ['nullable', 'string', 'max:255'],
            'code_bank' => ['nullable', 'string', 'max:255'],
        ];
    }
}

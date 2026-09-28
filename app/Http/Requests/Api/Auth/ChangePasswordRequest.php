<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\BaseApiRequest;

class ChangePasswordRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}

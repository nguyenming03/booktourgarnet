<?php

namespace App\Http\Requests\Api\Account;

use App\Http\Requests\Api\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateAccountRequest extends BaseApiRequest
{
    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|string|max:255',
            'birth' => 'nullable|date',
            'gender' => ['nullable', Rule::in(['nam', 'nu'])],
            'email' => ['sometimes', 'required', 'email', Rule::unique('users', 'email')->ignore($userId)],
        ];
    }
}

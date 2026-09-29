<?php

namespace App\Http\Requests\Api\Contact;

use App\Http\Requests\Api\BaseApiRequest;

class StoreAdvisoryRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'tour_id' => 'nullable|integer|exists:tours,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'content' => 'required|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên của bạn.',
            'email.required' => 'Vui lòng nhập email của bạn.',
            'email.email' => 'Vui lòng nhập email hợp lệ.',
            'phone_number.required' => 'Vui lòng nhập số điện thoại của bạn.',
            'content.required' => 'Vui lòng nhập nội dung.',
        ];
    }
}

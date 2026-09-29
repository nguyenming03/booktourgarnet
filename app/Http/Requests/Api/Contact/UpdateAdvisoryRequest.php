<?php

namespace App\Http\Requests\Api\Contact;

use App\Http\Requests\Api\BaseApiRequest;

class UpdateAdvisoryRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'tour_id' => ['nullable', 'integer', 'exists:tours,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:255'],
            'phone_number' => ['sometimes', 'required', 'string', 'max:20'],
            'content' => ['sometimes', 'required', 'string', 'max:2000'],
            'status' => ['sometimes', 'string', 'max:50'],
        ];
    }
}

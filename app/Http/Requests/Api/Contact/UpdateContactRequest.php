<?php

namespace App\Http\Requests\Api\Contact;

use App\Http\Requests\Api\BaseApiRequest;

class UpdateContactRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['sometimes', 'required', 'string', 'max:2000'],
            'status' => ['sometimes', 'integer', 'min:0'],
        ];
    }
}

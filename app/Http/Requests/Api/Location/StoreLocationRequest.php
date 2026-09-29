<?php

namespace App\Http\Requests\Api\Location;

use App\Http\Requests\Api\BaseApiRequest;

class StoreLocationRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:200'],
            'slug' => ['required', 'string', 'max:255', 'unique:locations,slug'],
            'image' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
        ];
    }
}

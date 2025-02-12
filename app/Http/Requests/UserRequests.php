<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequests extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Tên Coupons là bắt buộc',
            'name.max' => 'Tên Coupons không được vượt quá 255 kía tự',

        ];
    }
}

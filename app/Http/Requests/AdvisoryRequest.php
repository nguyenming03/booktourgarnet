<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class AdvisoryRequest extends FormRequest
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

            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'content' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên của bạn.',
            'name.string' => 'Vui lòng nhập tên hợp lệ.',
            'name.max' => 'Tên không được dài hơn 255 ký tự.',
            'email.required' => 'Vui lòng nhập email của bạn.',
            'email.email' => 'Vui lòng nhập email hợp lệ.',
            'email.max' => 'Email không được dài hơn 255 ký tự.',
            'phone_number.required' => 'Vui lòng nhập số điện thoại của bạn.',
            'phone_number.string' => 'Vui lòng nhập số điện thoại hợp lệ.',
            'phone_number.max' => 'Số điện thoại không được nhiều hơn 20 ký tự.',
            'content.required' => 'Vui lòng nhập nội dung',
        ];
    }
    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422));
    }
}

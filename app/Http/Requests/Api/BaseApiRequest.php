<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * FormRequest cơ sở cho toàn bộ API: mọi request con chỉ cần khai báo rules()/messages(),
 * lỗi validate sẽ luôn được trả về dưới dạng JSON đồng nhất với format response chung.
 */
abstract class BaseApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Dữ liệu gửi lên không hợp lệ.',
            'errors' => $validator->errors(),
        ], 422));
    }
}

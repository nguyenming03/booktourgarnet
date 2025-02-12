<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $id = $this->route('category');
        return [
            'name' => 'required|max:255|unique:categories,name,' . $id,
            'img_thumb' => 'mimes:jpeg,png,jpg,gif,svg',
            'slug' => 'required|max:255|unique:categories,slug,' . $id,
            'user_id' => 'required',
            'status' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên là bắt buộc.',
            'name.unique' => 'Tên này đã tồn tại.',
            'name.max' => 'Tên không quá 255 ký tự.',
            'img_thumb.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif, hoặc svg.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.max' => 'Slug không quá 255 ký tự.',
            'slug.unique' => 'Slug này đã tồn tại.',
            'user_id.required' => 'Người dùng là bắt buộc.',
            'status.required' => 'Trạng thái là bắt buộc.',
        ];
    }
}

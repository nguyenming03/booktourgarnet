<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
        $id = $this->route('location');

        return [
            'name' => 'required|max:255|unique:locations,name,' . $id,
            'description' => 'required',
            'content' => 'required',
            'slug' => 'required|max:255|unique:locations,slug,' . $id,
         
            'user_id' => 'required',
            'status' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            'name.max' => 'Tên không được quá 255 ký tự',
            'name.unique' => 'Tên đã tồn tại',
            'description.required' => 'Vui lòng nhập mô tả',
            'content.required' => 'Vui lòng nhập nội dung',
            'slug.required' => 'Vui lòng nhập slug',
            'slug.max' => 'Slug không được quá 255 ký tự',
            'slug.unique' => 'Slug đã tồn tại',
            'image.required' => 'Vui lòng chọn ảnh',
            'user_id.required' => 'Vui lòng chọn người tạo',
            'status.required' => 'Vui lòng chọn trạng thái',
        ];
    }
}

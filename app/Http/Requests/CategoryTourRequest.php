<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryTourRequest extends FormRequest
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
        $id = $this->route('categorytour');

        return [
            'category_tour' => 'required|max:255|unique:category_tour,category_tour,' . $id,
            'description' => 'max:5000',
            'slug' => 'required|max:255|unique:category_tour,slug,' . $id,
            'responsibility' => 'max:5000',
            'status' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'category_tour.required' => 'Tên danh mục tour là bắt buộc.',
            'category_tour.max' => 'Tên danh mục tour không được vượt quá 255 ký tự.',
            'category_tour.unique' => 'Tên danh mục tour đã tồn tại.',
            'description.max' => 'Mô tả không được vượt quá 5000 ký tự.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug đã tồn tại.',
            'responsibility.max' => 'Phần trách nhiệm không được vượt quá 5000 ký tự.',
            'status.required' => 'Trạng thái là bắt buộc.',
        ];
    }
}

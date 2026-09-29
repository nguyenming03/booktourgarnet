<?php

namespace App\Http\Requests\Api\Category;

use App\Http\Requests\Api\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends BaseApiRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'category_tour' => ['sometimes', 'required', 'string', 'max:255', 'unique:category_tour'],
            'slug' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('category_tour', 'slug')->ignore($id)],
            'description' => ['nullable', 'string'],
            'status' => ['sometimes', 'boolean'],
            'responsibility' => ['nullable', 'integer', 'min:0'],
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

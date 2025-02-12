<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponsRequests extends FormRequest
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
        $id = $this->route('coupon');

        return [
            'name' => 'required|max:255|unique:coupons,name,' . $id,
            'tour_id' => 'required',
            'code' => 'required|max:10|unique:coupons,code,' . $id,
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'percentage_price' => 'required|numeric|min:0|max:100',
            'status' => 'required',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Tên tour là bắt buộc.',
            'name.string' => 'Tên tour phải là một chuỗi ký tự.',
            'name.max' => 'Tên tour không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên tour đã tồn tại.',

            'tour_id.required' => 'Tour là bắt buộc.',

            'code.required' => 'Mã tour là bắt buộc.',
            'code.string' => 'Mã tour phải là một chuỗi ký tự.',
            'code.max' => 'Mã tour không được vượt quá 10 ký tự.',
            'code.unique' => 'Mã tour đã tồn tại trong hệ thống.',

            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
            'start_date.after_or_equal' => 'Ngày bắt đầu phải là ngày hôm nay hoặc sau ngày hôm nay.',

            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.date' => 'Ngày kết thúc không hợp lệ.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',

            'percentage_price.required' => 'Giá phần trăm là bắt buộc.',
            'percentage_price.numeric' => 'Giá phần trăm phải là một số.',
            'percentage_price.min' => 'Giá phần trăm phải lớn hơn hoặc bằng 0.',
            'percentage_price.max' => 'Giá phần trăm không được vượt quá 100.',

            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là một trong hai giá trị: 0 hoặc 1.',
        ];
    }
}

<?php

namespace App\Http\Requests\Api\Booking;

use App\Http\Requests\Api\BaseApiRequest;

class StoreBookingRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'tour_id' => 'required|integer|exists:tours,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'note' => 'nullable|string|max:1000',
            'number_old' => 'required|integer|min:0',
            'number_children' => 'required|integer|min:0',
            'total_money' => 'nullable|numeric|min:0',
            'coupon_code' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'tour_id.required' => 'Tour là bắt buộc.',
            'tour_id.exists' => 'Tour không tồn tại.',
            'name.required' => 'Vui lòng nhập tên của bạn.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'number_old.required' => 'Số lượng người lớn là bắt buộc.',
            'number_children.required' => 'Số lượng trẻ em là bắt buộc.',
            
        ];
    }

    /**
     * Ràng buộc số khách tối thiểu 1 người (tổng người lớn + trẻ em).
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (($this->input('number_old', 0) + $this->input('number_children', 0)) < 1) {
                $validator->errors()->add('number_old', 'Đơn đặt tour cần ít nhất 1 khách.');
            }
        });
    }
}

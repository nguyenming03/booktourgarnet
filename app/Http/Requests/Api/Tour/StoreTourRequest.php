<?php

namespace App\Http\Requests\Api\Tour;

use App\Http\Requests\Api\BaseApiRequest;
use Illuminate\Validation\Rule;

class StoreTourRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('tours', 'name')->ignore($this->route('id')),],
            'journeys' => ['required', 'string', 'max:255'],
            'schedule' => ['required', 'string', 'max:255'],
            'move_method' => ['required', 'string', 'max:255'],
            'starting_gate' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date', 'after:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'number_guests' => ['required', 'integer', 'min:1'],
            'number' => ['nullable', 'integer', 'min:0'],
            'number_registered' => ['nullable', 'integer', 'min:0'],
            'price_old' => ['required', 'numeric', 'min:0'],
            'price_children' => ['nullable', 'numeric', 'min:0'],
            'sale' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'category_tour_id' => ['required', 'integer', 'exists:category_tour,id'],
            'status' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên là bắt buộc.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên đã tồn tại.',
            'journeys.required' => 'Hành trình là bắt buộc.',
            'journeys.max' => 'Hành trình không được vượt quá 255 ký tự.',
            'schedule.required' => 'Lịch trình là bắt buộc.',
            'schedule.max' => 'Lịch trình không được vượt quá 255 ký tự.',
            'tour_dates.required' => 'Vui lòng chọn ngày.',
            'move_method.required' => 'Phương thức di chuyển là bắt buộc.',
            'move_method.max' => 'Phương thức di chuyển không được vượt quá 255 ký tự.',
            'starting_gate.required' => 'Cổng khởi hành là bắt buộc.',
            'starting_gate.max' => 'Cổng khởi hành không được vượt quá 255 ký tự.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu phải là ngày hợp lệ.',
            'start_date.after' => 'Ngày khởi hành phải sau ngày hiện tại.',
            'start_date.before_or_equal' => 'Ngày bắt đầu không được lớn hơn ngày kết thúc',
            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.date' => 'Ngày kết thúc phải là ngày hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải bằng hoặc sau ngày bắt đầu.',
            'number.numeric' => 'Số lượng này phải là một số.',
            'number.min' => 'Số lượng phải lớn hơn hoặc bằng 0.',
            'number.max_digits' => 'Số lượng không được vượt quá 10 ký tự.',
            'number_guests.required' => 'Số lượng khách là bắt buộc.',
            'number_guests.integer' => 'Số lượng khách phải là số nguyên.',
            'number_guests.min' => 'Số lượng khách phải lớn hơn hoặc bằng 1.',
            'price_old.required' => 'Giá cũ là bắt buộc.',
            'price_old.numeric' => 'Giá cũ phải là số.',
            'price_old.min' => 'Giá cũ không được âm.',
            'price_children.required' => 'Giá trẻ em là bắt buộc.',
            'price_children.numeric' => 'Giá trẻ em phải là số.',
            'price_children.min' => 'Giá trẻ em không được âm.',
            'sale.required' => 'Giảm giá là bắt buộc.',
            'sale.numeric' => 'Giảm giá phải là số.',
            'sale.min' => 'Giảm giá không được nhỏ hơn 0%.',
            'sale.max' => 'Giảm giá không được lớn hơn 100%.',
            'description.required' => 'Mô tả là bắt buộc.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'content.required' => 'Vui lòng nhập nội dung.',
            'location_id.required' => 'Vui lòng chọn địa điểm.',
            'category_tour_id.required' => 'Vui lòng chọn mục tour.',
            'category_services' => 'Vui lòng chọn danh mục dịch vụ.',
            'services.required' => 'Vui lòng chọn ít nhất một dịch vụ.',
            'services.min' => 'Vui lòng chọn ít nhất một dịch vụ.',
            'locations.required' => 'Bạn phải nhập ít nhất một lịch trình.',
            'locations.*.start.required' => 'Điểm bắt đầu là bắt buộc.',
            'locations.*.end.required' => 'Điểm kết thúc là bắt buộc.',
            'locations.*.end.different' => 'Điểm kết thúc phải khác điểm bắt đầu.',
            // 'locations.*.description.required' => 'Vui lòng nhập mô tả.',
            'time.required' => 'Vui lòng nhập số ngày diễn ra.',
            'time.integer' => 'Thời gian phải là một số nguyên.',
            'time.min' => 'Thời gian phải là số dương.',
            'time.max' => 'Thời gian tối đa là 100 ngày.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $registered = (int) $this->input('number_registered', 0);
            $capacity = (int) $this->input('number_guests', 0);
            $remaining = $this->input('number');

            if ($registered > $capacity) {
                $validator->errors()->add('number_registered', 'Số khách đã đăng ký không được lớn hơn sức chứa.');
            }

            if ($remaining !== null && (int) $remaining > $capacity) {
                $validator->errors()->add('number', 'Số chỗ còn lại không được lớn hơn sức chứa.');
            }
        });
    }
}

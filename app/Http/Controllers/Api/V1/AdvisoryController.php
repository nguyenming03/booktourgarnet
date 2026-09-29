<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\Contact\StoreAdvisoryRequest;
use App\Http\Requests\Api\Contact\UpdateAdvisoryRequest;
use App\Models\Advisory;
use Illuminate\Http\Request;

class AdvisoryController extends Controller
{
    public function index(Request $request)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $advisories = Advisory::with('tour:id,name')
            ->orderByDesc('id')
            ->paginate(min(max((int) $request->input('per_page', 20), 1), 100));

        return $this->success($advisories, 'Danh sách yêu cầu tư vấn.');
    }

    public function store(StoreAdvisoryRequest $request)
    {
        $advisory = Advisory::create([
            'tour_id' => $request->tour_id,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'content' => $request->content,
            'status' => 'Đang chờ xử lý',
        ]);

        return $this->created($advisory, 'Thông tin tư vấn đã được gửi thành công.');
    }

    public function show(Request $request, string $id)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $advisory = Advisory::with('tour:id,name')->find($id);

        if (!$advisory) {
            return $this->notFound('Không tìm thấy yêu cầu tư vấn.');
        }

        return $this->success($advisory, 'Chi tiết yêu cầu tư vấn.');
    }

    public function update(UpdateAdvisoryRequest $request, string $id)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $advisory = Advisory::find($id);

        if (!$advisory) {
            return $this->notFound('Không tìm thấy yêu cầu tư vấn.');
        }

        $advisory->update($request->validated());

        return $this->success($advisory->fresh()->load('tour:id,name'), 'Cập nhật yêu cầu tư vấn thành công.');
    }

    public function destroy(Request $request, string $id)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $advisory = Advisory::find($id);

        if (!$advisory) {
            return $this->notFound('Không tìm thấy yêu cầu tư vấn.');
        }

        $advisory->delete();

        return $this->success(null, 'Xóa yêu cầu tư vấn thành công.');
    }
}

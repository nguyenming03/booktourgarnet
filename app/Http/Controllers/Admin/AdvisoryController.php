<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advisory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdvisoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_advisory'])->only(['index']);
        // $this->middleware(['permission:destroy_advisory'])->only(['destroy']);
    }
    public function index(Request $request)
    {
        $data['title'] = "Tư Vấn Liên Hệ";
        $status = $request->get('status');
        $searchQuery = $request->get('search');

        $query = Advisory::query();

        if ($status !== null) {
            $query->where('advisories.status', $status);
        }

        if ($searchQuery !== null && $searchQuery !== '') {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('advisories.name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('advisories.phone_number', 'like', '%' . $searchQuery . '%')
                    ->orWhere('advisories.email', 'like', '%' . $searchQuery . '%')
                    ->orWhere('tours.name', 'like', '%' . $searchQuery . '%');
            });
        }

        $query->join('tours', 'tours.id', '=', 'advisories.tour_id')
            ->select('advisories.*', 'tours.name as tour_name');

        $data['advisory'] = $query->get();


        if ($request->ajax()) {
            return response()->json([
                'data' => $data['advisory']
            ]);
        }

        return view('admin.advisory.index', $data);
    }



    public function advisoryStatus(Request $request, $id)
    {


        try {
            $advisory = Advisory::findOrFail($id);

            $notAllowedStatus = ['Đã hoàn tất', 'Hủy bỏ'];

            if ($advisory->status !== 'Đang chờ xử lý' && $request->status === 'Đang chờ xử lý') {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể quay lại trạng thái "Đang chờ xử lý"!',
                ]);
            }

            $advisory->status = $request->status;
            $advisory->save();

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã có lỗi xảy ra. Vui lòng thử lại!',
            ]);
        }
    }


    public function destroy(string $id)
    {
        try {

            $advisory = Advisory::findOrFail($id);

            $advisory->deleted_at = now();
            $advisory->save();


            return response()->json([
                'success' => true,
                'message' => 'Xóa  thành công!',
            ]);
        } catch (\Exception $e) {

            Log::error('Lỗi khi xóa : ' . $e->getMessage());


            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.',
            ], 500);
        }
    }
}

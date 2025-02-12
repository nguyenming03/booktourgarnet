<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admins\DonTour;
use Illuminate\Http\Request;

class BookTourController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_bookTour'])->only(['index']);
        // $this->middleware(['permission:update_bookTour'])->only(['update']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Danh Sách Đơn Hàng";

        // Lấy ngày tìm kiếm từ request
        $searchDate = $request->input('search_date');

        // Khởi tạo query để lấy danh sách tour
        $query = DonTour::query()->orderByDesc('id');

        // Nếu có ngày tìm kiếm, áp dụng điều kiện lọc
        if ($searchDate) {
            $query->whereDate('date_booking', '=', $searchDate); // Lọc theo ngày cụ thể
        }

        // Lấy danh sách tour sau khi áp dụng điều kiện (nếu có)
        $listTour = $query->get();


        // Các dữ liệu khác
        $trangThaiTour = DonTour::all();
        $type_huy_tour = DonTour::HUY_TOUR;

        // Trả về view cùng dữ liệu
        return view('admin.quanlytour.index', compact('title', 'listTour', 'trangThaiTour', 'type_huy_tour'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $tour = DonTour::query()->findOrFail($id);
        $currentTrangThai = $tour->status;

        $newTrangThai = $request->input('status');
        $trangThai = array_keys(DonTour::TRANG_THAI_TOUR);
        //Kiểm tra nếu đơn hàng đã huye thì không được thay đổi trạng thái nữa
        if ($currentTrangThai === DonTour::HUY_TOUR) {
            return redirect()->route('dontour.index')->with('error', 'Đơn hàng đã bị hủy ko thể thay đổi được trạng thái');
        }
        //Kiểm tra trạng thái mới không được nằm sau trạng thái hiện tại
        if (array_search($newTrangThai, $trangThai) < array_search($currentTrangThai, $trangThai)) {
            return redirect()->route('dontour.index')->with('error', 'Không thể cập nhật ngược đươch trạng thái');
        }
        $tour->status = $newTrangThai;
        // dd($tour);
        $tour->save();
        return redirect()->route('dontour.index')->with('success', 'Cập nhật trạng thái đơn hàng  thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

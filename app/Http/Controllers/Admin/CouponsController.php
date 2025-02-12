<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admins\Tour;
use Illuminate\Http\Request;
use App\Models\Admins\Coupons;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponsRequests;
use App\Models\Status;
use Illuminate\Support\Facades\Storage;

class CouponsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_coupon'])->only(['index']);
        // $this->middleware(['permission:create_coupon'])->only(['create']);
        // $this->middleware(['permission:store_coupon'])->only(['store']);
        // $this->middleware(['permission:edit_coupon'])->only(['edit']);
        // $this->middleware(['permission:update_coupon'])->only(['update']);
        // $this->middleware(['permission:destroy_coupon'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Danh Sách Mã Giảm Giá";
        $status = $request->get('status');
        $query = Coupons::query();

        if ($status !== null) {
            $query->where('status', $status);
        }

        $listcoupons = $query->orderByDesc('id')->get();
        $listtour = Tour::all();

        if ($request->ajax()) {

            $listcoupons = $query->with('tour')->get();
            return response()->json([
                'coupons' => $listcoupons,
                'tour' => $listtour
            ]);
        }

        return view('admin.coupons.index', compact('listcoupons', 'listtour', 'title'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Thêm Mã Giảm Giá";
        //
        $listStatus = Status::query()->get();
        $listTour = Tour::query()->get();
        return view('admin.coupons.add', compact('listStatus', 'listTour', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponsRequests $request)
    {
        if ($request->method('post')) {
            $params = $request->except('_token');


            Coupons::create($params);
            return redirect()->route('coupons.index')->with('success', 'Thêm mới thành công!');;
        }
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
        $title = "Sửa Mã Giảm Giá";
        $listStatus = Status::query()->get();
        $listTour = Tour::query()->get();
        $coupons = Coupons::query()->findOrFail($id);
        return view('admin.coupons.edit', compact('listStatus', 'listTour', 'coupons', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponsRequests $request, string $id)
    {
        //
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $tour = Coupons::findOrFail($id);
            // Cập nhật dữ liệu
            $tour->update($params);

            return redirect()->route('coupons.index')->with('success', 'Cập nhật thành công!');;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    { {

            if ($request->isMethod('DELETE')) {

                $coupons = Coupons::findOrFail($id);

                if ($coupons) {

                    $coupons->delete();

                    return redirect()->route('coupons.index');
                }
                return redirect()->route('coupons.index');
            }
        }
    }


    public function couponStatus(Request $request, $id)
    {
        $coupon = Coupons::find($id);
        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Lỗi'], 404);
        }

        $coupon->status = $coupon->status == 0 ? 1 : 0;
        $coupon->save();

        return response()->json([
            'success' => true,
            'status' => $coupon->status
        ]);
    }
}

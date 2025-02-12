<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admins\Location;
use App\Models\Admins\Tour;
use App\Models\Admins\User;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Requests\LocationRequest;
use Illuminate\Support\Facades\Storage;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_location'])->only(['index']);
        // $this->middleware(['permission:create_location'])->only(['create']);
        // $this->middleware(['permission:store_location'])->only(['store']);
        // $this->middleware(['permission:edit_location'])->only(['edit']);
        // $this->middleware(['permission:update_location'])->only(['update']);
        // $this->middleware(['permission:destroy_location'])->only(['destroy']);
        // $this->middleware(['permission:show_location'])->only(['show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Danh Sách Địa Điểm";
        $listLocation = Location::query();

        $status = $request->get('status');
        if ($status !== null) {
            $listLocation->where('status', $status);
        }

        $listLocation = $listLocation->get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $listLocation,
            ]);
        }

        return view('admin.location.index', compact('listLocation', 'title'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Thêm Địa Điểm";
        $listStatus = Status::query()->get();
        $listUser = User::query()->get();
        $listTour = Tour::query()->get();
        return view('admin.location.add', compact('listStatus', 'title', 'listUser', 'listTour'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LocationRequest $request)
    {
        //
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');

            // Lấy trực tiếp giá trị từ dropdown
            $params['status'] = $request->input('status');

            // Xử lý hình ảnh đại diện
            if ($request->hasFile('image')) {
                $params['image'] = $request->file('image')->store('uploads/location', 'public');
            } else {
                $params['image'] = null;
            }

            // Thêm sản phẩm
            $user = Location::query()->create($params);

            // Lấy id sản phẩm vừa thêm để thêm được album
            $user = $user->id;

            return redirect()->route('location.index')->with('success', 'Thêm địa điểm thành công!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $location = Location::findOrFail($id); // Lấy thông tin của location
        return view('admin.location.details', compact('location'));  // Trả về view chi tiết
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Sửa Địa Điểm";
        //
        $location = Location::query()->findOrFail($id);
        $listUser = User::query()->get();
        $listTour = Tour::query()->get();
        return view('admin.location.edit', compact('location', 'listUser', 'listTour', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LocationRequest $request, string $id)
    {
        //
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $location = Location::findOrFail($id);

            // Xử lý Hình Ảnh
            if ($request->hasFile('image')) {
                // Nếu có ảnh mới, xóa ảnh cũ và lưu ảnh mới
                if ($location->image) {
                    Storage::disk('public')->delete($location->image);
                }
                $params['image'] = $request->file('image')->store('uploads/location', 'public');
            } else {
                // Nếu không có ảnh mới, giữ lại ảnh cũ
                $params['image'] = $location->image;
            }

            // Cập nhật dữ liệu
            $location->update($params);

            return redirect()->route('location.index')->with('success', 'Cập nhật thành công!');;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        //
        {

            if ($request->isMethod('DELETE')) {

                $location = Location::findOrFail($id);

                if ($location) {

                    $location->delete();

                    return redirect()->route('location.index')->with('success', 'Location deleted successfully.');
                }
                return redirect()->route('location.index')->with('success', 'Location deleted successfully.');
            }
        }
    }

    public function locationStatus(Request $request, $id)
    {
        $location = Location::find($id);
        if (!$location) {
            return response()->json(['success' => false, 'message' => 'Lỗi'], 404);
        }

        $location->status = $location->status == 0 ? 1 : 0;
        $location->save();

        return response()->json([
            'success' => true,
            'status' => $location->status
        ]);
    }
}

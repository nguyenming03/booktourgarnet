<?php

namespace App\Http\Controllers\Admin;

use App\Models\Status;
use App\Models\Admins\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_user'])->only(['index']);
        // $this->middleware(['permission:create_user'])->only(['create']);
        // $this->middleware(['permission:store_user'])->only(['store']);
        // $this->middleware(['permission:edit_user'])->only(['edit']);
        // $this->middleware(['permission:update_user'])->only(['update']);
        // $this->middleware(['permission:destroy_user'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Danh Sách Người Dùng";

        $status = $request->get('status');
        $query = User::query();

        if ($status !== null) {
            $query->where('status', $status)->where('role_id', 2);
        }

        $listuser = $query->get();



        if ($request->ajax()) {
            return response()->json([
                'data' => $listuser
            ]);
        }

        return view('admin.user.index', compact('title', 'listuser'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $listStatus = Status::query()->get();
        return view('admin.user.add', compact('listStatus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequests $request)
    {
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');

            // Lấy trực tiếp giá trị từ dropdown
            $params['status'] = $request->input('status');

            // Xử lý hình ảnh đại diện
            if ($request->hasFile('avatar')) {
                $params['avatar'] = $request->file('avatar')->store('uploads/avatar', 'public');
            } else {
                $params['avatar'] = null;
            }

            // Thêm sản phẩm
            $user = User::query()->create($params);

            // Lấy id sản phẩm vừa thêm để thêm được album
            $user = $user->id;

            return redirect()->route('user.index')->with('success', 'Thêm mới thành công!');;
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.details', compact('user'));  // Tạo một partial để hiển thị chi tiết tour
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::query()->findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $user = User::findOrFail($id);

            // Xử lý Hình Ảnh
            if ($request->hasFile('avatar')) {
                // Nếu có ảnh mới, xóa ảnh cũ và lưu ảnh mới
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $params['avatar'] = $request->file('avatar')->store('uploads/avatar', 'public');
            } else {
                // Nếu không có ảnh mới, giữ lại ảnh cũ
                $params['avatar'] = $user->avatar;
            }
            if ($request->has('password') && !empty($request->password)) {
                // Mã hóa mật khẩu mới
                $params['password'] = Hash::make($request->password);
            }
            // Cập nhật dữ liệu
            $user->update($params);

            return redirect()->route('user.index')->with('success', 'Cập nhật thành công!');;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    { {

            if ($request->isMethod('DELETE')) {

                $user = User::findOrFail($id);

                if ($user) {

                    $user->delete();

                    return redirect()->route('user.index');
                }
                return redirect()->route('user.index');
            }
        }
    }


    public function userStatus(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy người dùng'], 404);
        }


        if ($user->role_id == 1) {
            return response()->json(['success' => false, 'message' => 'Không thể thay đổi trạng thái của tài khoản này'], 403);
        }

        $user->status = $user->status == 0 ? 1 : 0;
        $user->save();

        return response()->json([
            'success' => true,
            'status' => $user->status
        ]);
    }
}

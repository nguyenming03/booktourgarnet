<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Guide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HDVController extends Controller
{
    //
    public function index()
    {
        $users = User::where('role_id', '!=', 1)->get(); // Lấy tất cả user mà không có role_id = 1
        return view('admin.hdv.index', compact('users'));
    }
    

   

    
    public function assignGuide($id)
    {
        $user = User::findOrFail($id);
    
        // Tìm bản ghi trong bảng guides có email trùng khớp
        $existingGuide = Guide::where('email', $user->email)->first();
    
        if ($existingGuide) {
            // Nếu tồn tại, gán guide_id của user bằng id của bản ghi trong bảng guides
            $user->guide_id = $existingGuide->id;
            $user->role_id = 3; // Gán role_id thành 3
            $user->save();
    
            return redirect()->route('hdv.index')->with('success', 'Gán quyền hướng dẫn viên thành công với thông tin đã tồn tại!');
        }
    
        // Nếu không tồn tại, tạo bản ghi mới trong bảng guides
        $guider = Guide::create([
            'name' => $user->name,
            'email' => $user->email,
            'phone_number' => $user->phone, // Số điện thoại từ user
            'address' => $user->address,    // Địa chỉ từ user
            'experience' => null,           // Đặt mặc định là null
            'skills' => null,               // Đặt mặc định là null
            'status' => 'active',           // Gán mặc định là 'active'
        ]);
    
        // Cập nhật guide_id và role_id trong bảng users
        $user->guide_id = $guider->id;
        $user->role_id = 3; // Gán role_id thành 3
        $user->save();
    
        return redirect()->route('hdv.index')->with('success', 'Gán quyền hướng dẫn viên thành công!');
    }
    

public function revokeGuide($id)
{
    // Tìm user theo ID
    $user = User::findOrFail($id);

    // Kiểm tra nếu user đã được gán quyền hướng dẫn viên
    if (!$user->guide_id) {
        return redirect()->route('hdv.index')->withErrors(['error' => 'Người dùng này không phải là hướng dẫn viên!']);
    }

    // Cập nhật guide_id và role_id
    $user->guide_id = null; // Xóa guide_id
    $user->role_id = 2;     // Gán role_id là 2
    $user->save();

    return redirect()->route('hdv.index')->with('success', 'Hủy quyền hướng dẫn viên thành công!');
}


}

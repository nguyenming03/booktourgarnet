<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\Account\UpdateAccountRequest;
use App\Http\Resources\Api\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Xem thông tin tài khoản đang đăng nhập.
     */
    public function show(Request $request)
    {
        return $this->success(new UserResource($request->user()), 'Thông tin tài khoản.');
    }

    /**
     * Cập nhật thông tin tài khoản (không bao gồm mật khẩu - xem AuthController@changePassword).
     */
    public function update(UpdateAccountRequest $request)
    {
        $user = $request->user();
        $user->update($request->validated());

        return $this->success(new UserResource($user->fresh()), 'Cập nhật thông tin thành công.');
    }

    /**
     * Xóa tài khoản của chính mình. Yêu cầu xác nhận lại mật khẩu hiện tại để tránh
     * xóa nhầm/xóa do lộ token. Toàn bộ token của tài khoản sẽ bị thu hồi.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            return $this->error('Mật khẩu không chính xác.', 422);
        }

        $user->tokens()->delete();
        $user->delete();

        return $this->success(null, 'Tài khoản đã được xóa.');
    }
}

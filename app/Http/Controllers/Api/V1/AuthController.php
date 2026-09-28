<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\Auth\ChangePasswordRequest;
use App\Http\Requests\Api\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\Admins\Customer;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Đăng ký tài khoản mới. Nếu khách đã từng đặt tour ở dạng vãng lai
     * (định danh qua header X-Temporary-User-Id), các đơn hàng cũ sẽ được
     * gắn lại vào tài khoản mới tạo.
     */
    public function register(RegisterRequest $request)
    {
        $result = DB::transaction(function () use ($request) {
            $name = trim($request->lastName . ' ' . $request->firstName);
            $temporaryUserId = $request->header('X-Temporary-User-Id');

            $anonymousCustomer = $temporaryUserId
                ? Customer::where('temporary_user_id', $temporaryUserId)
                    ->where('email', $request->email)
                    ->first()
                : null;

            $temporaryUserId = $anonymousCustomer ? $temporaryUserId : (string) Str::uuid();

            $user = User::create([
                'name' => $name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'status' => 1,
                'role_id' => 2,
                'temporary_user_id' => $temporaryUserId,
            ]);

            Customer::updateOrCreate(
                ['id' => $user->id],
                [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'type' => 'registered',
                    'temporary_user_id' => $temporaryUserId,
                ]
            );

            if ($anonymousCustomer) {
                Payment::where('customer_id', $anonymousCustomer->id)->update(['user_id' => $user->id]);
            }

            return $user;
        });

        $token = $result->createToken('api-token')->plainTextToken;

        return $this->created([
            'user' => new UserResource($result),
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Đăng ký thành công!');
    }

    /**
     * Đăng nhập bằng email + mật khẩu, trả về Bearer token.
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Email hoặc mật khẩu không chính xác!', 401);
        }

        $user = Auth::user();

        if ((int) $user->status !== 1) {
            return $this->forbidden('Tài khoản của bạn hiện đang bị vô hiệu hóa!');
        }

        $token = $user->createToken($request->input('device_name', 'api-token'))->plainTextToken;

        return $this->success([
            'user' => new UserResource($user),
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Đăng nhập thành công!');
    }

    /**
     * Đăng xuất - thu hồi token hiện tại đang dùng cho request này.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, 'Đã đăng xuất thành công.');
    }

    /**
     * Đăng xuất khỏi tất cả thiết bị (thu hồi toàn bộ token của user).
     */
    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->success(null, 'Đã đăng xuất khỏi tất cả thiết bị.');
    }

    /**
     * Trả về thông tin người dùng đang đăng nhập.
     */
    public function me(Request $request)
    {
        return $this->success(new UserResource($request->user()));
    }

    /**
     * Gửi email chứa liên kết đặt lại mật khẩu.
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $response = Password::sendResetLink($request->only('email'));

        if ($response === Password::RESET_LINK_SENT) {
            return $this->success(null, 'Một liên kết để đặt lại mật khẩu đã được gửi đến email của bạn.');
        }

        return $this->error('Đã có lỗi xảy ra. Vui lòng thử lại.', 422);
    }

    /**
     * Đặt lại mật khẩu dựa trên token nhận qua email, thu hồi mọi token cũ.
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
                $user->tokens()->delete();
            }
        );

        if ($response === Password::PASSWORD_RESET) {
            return $this->success(null, 'Mật khẩu của bạn đã được cập nhật thành công.');
        }

        return $this->error(trans($response), 422);
    }

    /**
     * Đổi mật khẩu khi đã đăng nhập.
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return $this->error('Mật khẩu hiện tại không chính xác.', 422);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return $this->success(null, 'Đổi mật khẩu thành công.');
    }
}

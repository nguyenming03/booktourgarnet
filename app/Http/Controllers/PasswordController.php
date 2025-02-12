<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Models\Admins\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Str;
use ReCaptcha\ReCaptcha;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    public function forgotPassword()
    {
        $data['head_title'] = "Đặt Lại Mật Khẩu";
        return view('client.auth.forgotpassword', $data);
    }

    public function postForgotPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:150',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email quá dài.',
            'g-recaptcha-response.required' => 'Vui lòng xác minh CAPTCHA.',
            'g-recaptcha-response.captcha' => 'Xác minh CAPTCHA không thành công.',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }


        $user = User::getEmailSingle($request->email);

        if ($user) {

            $token = Str::random(30);
            $user->remember_token = $token;
            $user->token_created_at = Carbon::now();
            $user->save();


            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return response()->json([
                'status' => 'success',
                'message' => 'Vui lòng kiểm tra email và làm theo hướng dẫn để đặt lại mật khẩu của bạn!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy tài khoản với email này!'
            ], 404);
        }
    }

    private function isTokenExpired($tokenCreatedAt)
    {
        $createdAt = \Carbon\Carbon::parse($tokenCreatedAt);
        return $createdAt->diffInHours(now()) > 24;
    }

    public function resetPassword($remember_token)
    {
        try {
            $user = User::getTokenSingle($remember_token);

            if (!$user || $this->isTokenExpired($user->token_created_at)) {
                abort(503, 'Service Unavailable');
            }

            $data['user'] = $user;
            return view('client.auth.restpassword', $data);
        } catch (\Exception $e) {

            \Log::error('Lỗi truy xuất người dùng để đặt lại mật khẩu: ' . $e->getMessage());

            abort(503, 'Service Unavailable');
        }
    }

    public function postResetPassword($token, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'g-recaptcha-response.required' => 'Vui lòng xác minh CAPTCHA.',
            'g-recaptcha-response.captcha' => 'Xác minh CAPTCHA không hợp lệ.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = User::getTokenSingle($token);

        if ($user) {
        
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(30);
            $user->save();

            return redirect(url('/'))->with('success', 'Đặt lại mật khẩu thành công!');
        } else {
            return redirect()->back()->with('error', 'Vui lòng thử lại!');
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    public function login()
    {
        // dd(Hash::make('123456789'));
        try {
            if (!empty(Auth::check())) {

                if (Auth::user()->role_id == 1) {
                    return redirect()->route('home-admin');
                }
                return redirect()->route('login')->with('error', 'Tài khoản không có quyền đăng nhập!');
            }
            return view('admin.auth.login');
        } catch (\Exception $e) {
            return response()->view('admin.errors.404', [], 404);
        }
    }

    public function authLogin(Request $request)
    {
        $remember = !empty($request->remember) ? true : false;

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ], true)) {

            if (Auth::user()->role_id == 1) {
                return redirect()->route('home-admin');
            }

            return redirect()->route('home-admin');
        } else {
            return redirect()->back()->with('error', 'Vui lòng nhập đúng email và mật khẩu!');
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login')->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate', // Không lưu cache
            'Pragma' => 'no-cache', // Hỗ trợ thêm cho HTTP/1.0
            'Expires' => '0', // Hết hạn ngay lập tức
        ]);
    }
}

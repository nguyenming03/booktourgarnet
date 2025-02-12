<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->status != 1) {

            if (Auth::check() && Auth::user()->role_id !== 1) {
                Auth::logout();
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tài khoản của bạn đã bị vô hiệu hóa!',
                ], 403);
            }


            return redirect()->route('home')->with('status_error', 'Tài khoản của bạn đã bị vô hiệu hóa.');
        }
        return $next($request);
    }
}

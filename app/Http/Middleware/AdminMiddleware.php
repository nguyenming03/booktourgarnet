<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!empty(Auth::check())) {
            if (Auth::user()->role_id == 1 || Auth::user()->role_id == 3){
                return $next($request);
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập!');
            }
        } else {
            Auth::logout();
            return redirect()->route('login');
        }
    }
}

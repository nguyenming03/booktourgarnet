<?php

namespace App\Http\Middleware;

use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class VerifyNoCaptcha
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
    
        if ($request->has('g-recaptcha-response')) {
            $recaptchaResponse = $request->input('g-recaptcha-response');
            $isCaptchaValid = NoCaptcha::verify($recaptchaResponse);
    
            if (!$isCaptchaValid) {
                return redirect()->back()->withErrors(['g-recaptcha-response' => 'Xác minh CAPTCHA không thành công!']);
            }
        }

        return $next($request);
    }
    
}

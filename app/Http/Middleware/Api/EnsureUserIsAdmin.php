<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Chỉ cho phép quản trị viên (role_id = 1) hoặc nhân viên (role_id = 3) truy cập.
 * Áp dụng cho các route API quản trị (CRUD tour/danh mục/địa điểm/coupon,
 * quản lý toàn bộ đơn hàng - thanh toán - liên hệ - tư vấn).
 *
 * Dùng cùng quy ước role_id với App\Http\Middleware\AdminMiddleware (bản web),
 * nhưng luôn trả JSON và không redirect/logout - phù hợp với API.
 */
class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('sanctum')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần đăng nhập để thực hiện thao tác này.',
            ], 401);
        }

        if (!in_array((int) $user->role_id, [1, 3], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền thực hiện thao tác này.',
            ], 403);
        }

        return $next($request);
    }
}

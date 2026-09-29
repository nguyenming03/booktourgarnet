<?php

namespace App\Services;

use App\Models\Admins\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Phân giải "khách hàng hiện tại" của một request cho luồng đặt tour / thanh toán:
 * - Nếu request có Bearer token hợp lệ (Sanctum) -> khách đã đăng nhập.
 * - Nếu không -> khách vãng lai, định danh bằng header "X-Temporary-User-Id"
 *   (client tự sinh UUID và lưu lại cho các request sau, dùng để gộp đơn hàng
 *   khi khách đăng ký tài khoản).
 */
class CustomerResolver
{
    public function resolve(Request $request, array $guestDefaults = []): ResolvedCustomer
    {
        $user = auth('sanctum')->user();

        if ($user) {
            return new ResolvedCustomer(
                customerId: $user->id,
                userId: $user->id,
                temporaryUserId: null,
                user: $user,
            );
        }

        $temporaryUserId = $request->header('X-Temporary-User-Id') ?: (string) Str::uuid();

        $customer = Customer::firstOrCreate(
            ['temporary_user_id' => $temporaryUserId],
            array_merge([
                'name' => 'Khách hàng ẩn danh',
                'type' => 'anonymous',
            ], $guestDefaults)
        );

        return new ResolvedCustomer(
            customerId: $customer->id,
            userId: null,
            temporaryUserId: $temporaryUserId,
            user: null,
        );
    }
}

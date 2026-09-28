<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Traits\ApiResponser;
use Illuminate\Http\Request;

abstract class Controller extends BaseController
{
    use ApiResponser;

    /**
     * Các endpoint quản trị trong API hiện dùng role_id = 1 theo RoleSeeder.
     * Nếu dự án đã có middleware permission riêng, có thể thay thế helper này
     * bằng middleware permission ở route.
     */
    protected function ensureAdmin(Request $request)
    {
        if (!$request->user() || (int) $request->user()->role_id !== 1) {
            return $this->forbidden('Bạn cần quyền quản trị để thực hiện thao tác này.');
        }

        return null;
    }
}

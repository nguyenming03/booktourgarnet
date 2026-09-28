<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\TourController;


/*
|--------------------------------------------------------------------------
| API Routes - Website đặt tour (v1)
|--------------------------------------------------------------------------
| Được RouteServiceProvider tự động gắn tiền tố "/api" và middleware group "api"
| (throttle:api mặc định 60 request/phút). Toàn bộ route bên dưới có thêm
| tiền tố "v1" -> ví dụ: GET /api/v1/tours.
|
| Xác thực: Laravel Sanctum, kiểu Bearer token
| (header Authorization: Bearer <token>).
|
| Khách vãng lai (đặt tour/thanh toán mà không cần tài khoản): gửi kèm header
| "X-Temporary-User-Id: <uuid-do-client-tự-sinh-và-lưu-lại>" để hệ thống gộp
| đơn hàng khi khách đăng ký tài khoản sau này.
|
| Phân quyền:
|   - Không middleware        : công khai, ai cũng gọi được
|   - auth:sanctum             : cần đăng nhập (bất kỳ tài khoản nào)
|   - auth:sanctum + api.admin : chỉ quản trị viên/nhân viên (role_id 1 hoặc 3)
|
| Ghi chú upload file: các route PUT có nhận file (image/images[]) nên được gọi
| bằng POST kèm field "_method=PUT" (form method spoofing của Laravel), vì
| PHP không parse được multipart/form-data trên request PUT/PATCH thật sự.
*/

Route::prefix('v1')->name('v1.')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');


    Route::prefix('auth')->name('auth.')->group(function () {
        Route::middleware('throttle:10,1')->group(function () {
            Route::post('/register', [AuthController::class, 'register'])->name('register');
            Route::post('/login', [AuthController::class, 'login'])->name('login');
            Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
            Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
        });

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/me', [AuthController::class, 'me'])->name('me');
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::post('/logout-all', [AuthController::class, 'logoutAll'])->name('logout-all');
            Route::put('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
        });
    });

    //tour
    Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
    Route::get('/tours/featured', [TourController::class, 'featured'])->name('tours.featured');
    Route::get('/tours/{id}/related', [TourController::class, 'related'])->whereNumber('id')->name('tours.related');
    Route::get('/tours/{id}', [TourController::class, 'show'])->whereNumber('id')->name('tours.show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/manage/tours', [TourController::class, 'manageIndex'])->name('tours.manage.index');
        Route::post('/tours', [TourController::class, 'store'])->name('tours.store');
        Route::put('/tours/{id}', [TourController::class, 'update'])->whereNumber('id')->name('tours.update');
        Route::patch('/tours/{id}', [TourController::class, 'update'])->whereNumber('id')->name('tours.patch');
        Route::delete('/tours/{id}', [TourController::class, 'destroy'])->whereNumber('id')->name('tours.destroy');
    });

    Route::middleware('auth:sanctum')->group(function () {
        // Tài khoản cá nhân
        Route::get('/account', [AccountController::class, 'show'])->name('account.show');
        Route::put('/account', [AccountController::class, 'update'])->name('account.update');
        Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');
    });
});

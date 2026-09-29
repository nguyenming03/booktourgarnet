<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\TourController;
use App\Http\Controllers\Api\V1\BookingController;


/*
|--------------------------------------------------------------------------
| API Routes - Website đặt tour (v1)
|--------------------------------------------------------------------------
| Xác thực: Laravel Sanctum, kiểu Bearer token
| (header Authorization: Bearer <token>).
| Khách vãng lai (đặt tour): yêu cầu khách hàng phải đăng nhập mới được đặt tour
| Phân quyền:
|   - Không middleware        : công khai, ai cũng gọi được
|   - auth:sanctum             : cần đăng nhập (bất kỳ tài khoản nào)
|   - auth:sanctum + api.admin : chỉ quản trị viên/nhân viên (role_id 1 hoặc 3)
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

     Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->whereNumber('id')->name('bookings.show');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->whereNumber('id')->name('bookings.cancel');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.mine');
        Route::put('/bookings/{id}', [BookingController::class, 'update'])->whereNumber('id')->name('bookings.update');
        Route::patch('/bookings/{id}', [BookingController::class, 'update'])->whereNumber('id')->name('bookings.patch');
        Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->whereNumber('id')->name('bookings.destroy');
    });

    Route::middleware('auth:sanctum')->group(function () {
        // Tài khoản cá nhân
        Route::get('/account', [AccountController::class, 'show'])->name('account.show');
        Route::put('/account', [AccountController::class, 'update'])->name('account.update');
        Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');
    });
});

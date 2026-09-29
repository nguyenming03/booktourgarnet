<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\TourController;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\LocationController;
use App\Http\Controllers\Api\V1\CouponController;

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

    //thanh toán 
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{id}', [PaymentController::class, 'show'])->whereNumber('id')->name('payments.show');
    Route::post('/payments/vnpay/create', [PaymentController::class, 'vnpayCreate'])->name('payments.vnpay.create');
    Route::match(['get', 'post'], '/payments/vnpay/return', [PaymentController::class, 'vnpayReturn'])->name('payments.vnpay.return');
    Route::match(['get', 'post'], '/payments/vnpay/cancel', [PaymentController::class, 'vnpayCancel'])->name('payments.vnpay.cancel');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::put('/payments/{id}', [PaymentController::class, 'update'])->whereNumber('id')->name('payments.update');
        Route::patch('/payments/{id}', [PaymentController::class, 'update'])->whereNumber('id')->name('payments.patch');
        Route::delete('/payments/{id}', [PaymentController::class, 'destroy'])->whereNumber('id')->name('payments.destroy');
    });

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/id/{id}', [CategoryController::class, 'showById'])->whereNumber('id')->name('categories.show-by-id');
    Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/manage/categories', [CategoryController::class, 'manageIndex'])->name('categories.manage.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->whereNumber('id')->name('categories.update');
        Route::patch('/categories/{id}', [CategoryController::class, 'update'])->whereNumber('id')->name('categories.patch');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->whereNumber('id')->name('categories.destroy');
    });

    //địa điểm
    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
    Route::get('/locations/id/{id}', [LocationController::class, 'showById'])->whereNumber('id')->name('locations.show-by-id');
    Route::get('/locations/{slug}', [LocationController::class, 'show'])->name('locations.show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/manage/locations', [LocationController::class, 'manageIndex'])->name('locations.manage.index');
        Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
        Route::put('/locations/{id}', [LocationController::class, 'update'])->whereNumber('id')->name('locations.update');
        Route::patch('/locations/{id}', [LocationController::class, 'update'])->whereNumber('id')->name('locations.patch');
        Route::delete('/locations/{id}', [LocationController::class, 'destroy'])->whereNumber('id')->name('locations.destroy');
    });

    Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
    Route::get('/coupons/{id}', [CouponController::class, 'show'])->whereNumber('id')->name('coupons.show');
    Route::post('/coupons/validate', [CouponController::class, 'validateCoupon'])->name('coupons.validate');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/manage/coupons', [CouponController::class, 'manageIndex'])->name('coupons.manage.index');
        Route::post('/coupons', [CouponController::class, 'store'])->name('coupons.store');
        Route::put('/coupons/{id}', [CouponController::class, 'update'])->whereNumber('id')->name('coupons.update');
        Route::patch('/coupons/{id}', [CouponController::class, 'update'])->whereNumber('id')->name('coupons.patch');
        Route::delete('/coupons/{id}', [CouponController::class, 'destroy'])->whereNumber('id')->name('coupons.destroy');
    });

    Route::middleware('auth:sanctum')->group(function () {
        // Tài khoản cá nhân
        Route::get('/account', [AccountController::class, 'show'])->name('account.show');
        Route::put('/account', [AccountController::class, 'update'])->name('account.update');
        Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');
    });
});

<?php

use App\Models\Admins\CategoryTour;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PayController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\CouponsController;


use App\Http\Controllers\Admin\AdvisoryController;
use App\Http\Controllers\Admin\BookTourController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CategoryServiceController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Client\BookingController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\ServiceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Client\HandbookController;
use App\Http\Controllers\Client\IntroduceController;
use App\Http\Controllers\Client\myAccountController;
use App\Http\Controllers\NotificationUserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionUserController;
use App\Http\Controllers\Admin\StatisticalController;
use App\Http\Controllers\Client\AuthClientController;
use App\Http\Controllers\Admin\CategoryTourController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\HDVController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\ChangeLogController;
use App\Http\Controllers\Client\TourController as ClientTourController;
use App\Http\Controllers\CouponsClientController;
use App\Http\Controllers\GuideManagerController;
use App\Http\Controllers\HuyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// client routes
Route::group(['middleware' => 'checkstatus'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/auth/check-user-status', [AuthClientController::class, 'checkUserStatus'])->name('auth.check-user-status');

    // client dang ky/ dang nhap/quen mat khau/ login gg
    Route::get('/dang-nhap', [AuthClientController::class, 'DangNhap'])->name('dang-nhap');
    Route::post('/post-dang-nhap', [AuthClientController::class, 'postDangNhap'])->name('post-dang-nhap');
    Route::get('/dang-ky', [AuthClientController::class, 'DangKy'])->name('dang-ky');
    Route::post('/post-dang-ky', [AuthClientController::class, 'postDangKy'])->name('post-dang-ky');
    Route::get('/auth/google', [AuthClientController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthClientController::class, 'handleGoogleCallback']);
    Route::get('/logouts', [AuthClientController::class, 'logouts'])->name('logouts');

    // Route::get('reset-mat-khau/{token}', [AuthClientController::class, 'showResetPasswordForm'])->name('reset-mat-khau');
    // Route::post('reset-mat-khau/{token}', [AuthClientController::class, 'resetPassword'])->name('reset-mat-khau.xac-nhan');

    // Route::post('quen-mat-khau', [AuthClientController::class, 'sendResetMK'])->name('password.request');
    // Route::get('reset-mat-khau/{token}', [AuthClientController::class, 'showResetForm'])->name('password.reset');
    // Route::post('reset-mat-khau', [AuthClientController::class, 'reset'])->name('password.update');

    Route::get('quen-mat-khau',                             [PasswordController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('quen-mat-khau',                            [PasswordController::class, 'postForgotPassword'])->name('post-forgot-password')->middleware('throttle:10,1');
    Route::get('dat-lai-mat-khau/{token}',                  [PasswordController::class, 'resetPassword'])->name('reset-password');
    Route::post('dat-lai-mat-khau/{token}',                 [PasswordController::class, 'postResetPassword'])->name('post-reset-password')->middleware('throttle:10,1');



    // Route::resource('tour', ClientTourController::class)->names([
    //đổi pass trang profile
    Route::get('/change-password', [myAccountController::class, 'indexChangePassword'])->name('user.indexChangePassword');
    Route::post('/change-password', [myAccountController::class, 'changePassword'])->name('user.changePassword');
    //them dia chi moi
    Route::get('/address', [myAccountController::class, 'indexAddressNew'])->name('user.indexAddress');
    Route::post('/address', [myAccountController::class, 'addressNew'])->name('user.address');

    Route::get('/don-hang', [myAccountController::class, 'indexOrderMy'])->name('user.indexOrderMy');
    Route::post('/don-hang', [myAccountController::class, 'orderMy'])->name('user.orderMy');
    Route::get('/don-hang/{id}', [myAccountController::class, 'details'])->name('orders.donHangDetails');

    Route::get('/detail-don-hang/{id}', [myAccountController::class, 'detailDoHang'])->name('usser.detailDoHang');
    Route::put('/huy-don-hang/{id}', [myAccountController::class, 'cancelOrder'])->name('usser.cancelOrder');
    Route::put('/yeu-cau-huy/{id}', [myAccountController::class, 'submitRefundRequest'])->name('usser.submitRefundRequest');
    //     'show' => 'client.tour.show',
    //thông tin tài khoản
    Route::get('/my-account', [myAccountController::class, 'index'])->name('my-account.index');
    Route::get('/my-account/{id}', [myAccountController::class, 'edit'])->name('my-account.edit');
    Route::put('/my-account{id}', [myAccountController::class, 'update'])->name('my-account.update');


    // ]);
    Route::get('detail-tour/{id}', [HomeController::class, 'detailTour'])->name('client.tour.show');

    Route::post('/tour/{id}/comment', [HomeController::class, 'storeComment'])->name('posts.comment');



    Route::post('/tour/{id}/comment', [HomeController::class, 'storeComment'])->name('posts.comment');


    // Route::get('/pre-booking', function () {
    //     return view('client.tour.booking');
    // })->name('pre-booking');

    Route::get('/pre-booking/{id}', [ClientTourController::class, 'pre_booking'])->name('tour.pre-booking');
    Route::get('/confirm/{id}', [BookingController::class, 'showBookingInfo'])->name('tour.confirm');

    Route::post('/booking', [BookingController::class, 'store'])->name('tour.booking')->middleware('throttle:10,1');

    Route::post('/payment/store', [PaymentController::class, 'storePayment'])->name('payment.store')->middleware('throttle:10,1');
    Route::post('/payment/vnpay', [PaymentController::class, 'vnpay_payment'])->name('payment.vnpay')->middleware('throttle:10,1');
    Route::get('payment/vnpay-return', [PaymentController::class, 'vnpayReturn'])->name('payment.vnpayReturn');

    Route::get('/payment/success/{payment_id}', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel/{vnp_TxnRef}', [PaymentController::class, 'vnpayCancel'])->name('payment.vnpay.cancel');

    Route::get('payment/failed', [PaymentController::class, 'failure'])->name('payment.failed');

    // Route::get('/test-email', function () {
    //     $email = 'giangtg7dz@gmail.com';
    //     Mail::raw('This is a test email!', function ($message) use ($email) {
    //         $message->to($email)
    //                 ->subject('Test Email');
    //     });
    //     return 'Test email sent!';
    // });

    Route::get('/lien-he', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/post-lien-he', [ContactController::class, 'store'])->name('post.contact.index')->middleware('throttle:10,1');
    Route::get('/gioi-thieu', [IntroduceController::class, 'index'])->name('introduce.index');
    Route::get('/cam-nang-dul-lich', [ServiceController::class, 'index'])->name('service.index');
    Route::get('/cam-nang-dul-lich/{id}', [ServiceController::class, 'show'])->name('service.show');
    Route::get('/cam-nang', [HandbookController::class, 'index'])->name('handbook.index');
    Route::get('/cam-nang/{id}', [HandbookController::class, 'show'])->name('handbook.show');
    Route::post('/tour/{tourId}/reviews', [HomeController::class, 'store'])->name('reviews.store')->middleware('throttle:10,1');
    Route::get('/tour-trong-nuoc', function () {
        return view('client.pages.domesticTour');
    });

    Route::get('/chi-tiet-tour/{id}',   [HomeController::class, 'detailTour'])->name('detail');
    Route::get('/tat-ca-tour',          [HomeController::class, 'allTour'])->name('home.allTour');
    Route::get('/tat-ca-tour/loc',      [HomeController::class, 'filter'])->name('tour.filter');


    Route::get('/tim-kiem',             [ClientTourController::class, 'searchTour'])->name('tour.search');
    Route::get('/tour/{slug}',          [ClientTourController::class, 'tour'])->name('tour.category');
    Route::get('/tour-dia-diem/{slug}', [ClientTourController::class, 'tourLocation'])->name('tour.location');

    Route::get('/favorite',             [FavoriteController::class, 'index'])->name('favorite.index');
    Route::post('/favorite',            [FavoriteController::class, 'addToFavorite'])->name('favorite.add');
    Route::delete('/favorite/{id}',     [FavoriteController::class, 'removeFavorite'])->name('favorite.delete');

    Route::get('/test',                 [ClientTourController::class, 'showTour'])->name('test.showTour');
    Route::post('/advisory',            [ClientTourController::class, 'advisory'])->name('advisory');

    Route::get('/ma-giam-gia', [CouponsClientController::class, 'index'])->name('maGiamGia.index');
});


// admin routes
Route::group(['prefix' => 'admin'], function () {

    Route::get('login',                     [AuthController::class, 'login'])->name('login');
    Route::post('authLogin',                [AuthController::class, 'authLogin'])->name('authLogin');
    Route::get('logout',                    [AuthController::class, 'logout'])->name('logout');
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/home', [StatisticalController::class, 'index'])->name('home-admin');
        // Route::get('/doanh-thu/{timeframe}', [StatisticalController::class, 'getRevenue'])->name('revenue.get');
        Route::post('/home/dashboard-date', [StatisticalController::class, 'filterByDate'])->name('dashboard.filterByDate');
        Route::post('/home/dashboard-btn', [StatisticalController::class, 'filterByBtn'])->name('dashboard.filterByBtn');
        Route::get('/dashboard-data', [StatisticalController::class, 'getDashboardData'])->name('admin.dashboard.data');

        Route::resource('user', UserController::class);
        Route::resource('dontour', BookTourController::class);
        Route::resource('faqs', FaqController::class);
        Route::resource('article', ArticleController::class);
        Route::resource('notifications', NotificationController::class);
        // Route::resource('categorytour', CategoryTour::class);
        Route::resource('trangthaitour', PayController::class);
        Route::get('/quanlytour/{id}', [PayController::class, 'show']);
        // Route::get('/admin/quanlytour/{id}', [PayController::class, 'show'])->name('admin.quanlytour.details');

        // Route::post('/payment-tour/{id}/thanh-toan', [PayController::class, 'ThanhToan'])->name('trangthaitour.updateThanhToan');

        Route::resource('tour', TourController::class);
        Route::resource('coupons', CouponsController::class);


        Route::resource('review', ReviewController::class);
        Route::patch('/review/{id}/toggle-status', [ReviewController::class, 'toggleStatus'])->name('review.toggleStatus');

        Route::resource('location', LocationController::class);
        Route::resource('xu-ly-huy', HuyController::class);
        // Route cho chấp nhận yêu cầu hủy tour
        Route::put('xu-ly-huy/{id}/accept', [HuyController::class, 'acceptCancel'])->name('user.acceptCancel');
        Route::get('/admin/cancellation-histories', [HuyController::class, 'showCancellationHistories'])->name('user.cancellationHistories');


        // Route cho từ chối yêu cầu hủy tour
        Route::put('xu-ly-huy/{id}/reject', [HuyController::class, 'rejectCancel'])->name('user.rejectCancel');

        // Route cho upload ảnh minh chứng hủy
        Route::patch('xu-ly-huy/{id}/upload-proof', [HuyController::class, 'uploadCancelProof'])->name('user.uploadCancelProof');
        Route::resource('category', CategoryController::class);
        Route::resource('categorytour', CategoryTourController::class);
        Route::resource('comments', CommentController::class);


        Route::get('comment',                               [CommentController::class, 'index'])->name('comment.index');
        Route::delete('comment/delete/{id}',                [CommentController::class, 'destroy'])->name('comment.delete');
        Route::post('comment/status/{id}',                  [CommentController::class, 'commentStatus'])->name('comment.commentStatus');
        // thông báo
        Route::resource('notification-user', NotificationUserController::class);
        Route::get('/users/search', [NotificationUserController::class, 'searchUsers'])->name('users.search');
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
        Route::get('admin/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unreadCount');

        // end thông báo

        Route::delete('advisory/delete/{id}',               [AdvisoryController::class, 'destroy'])->name('advisory.delete');
        Route::post('advisory/status/{id}',                 [AdvisoryController::class, 'advisoryStatus'])->name('advisory.advisoryStatus');

        //status
        Route::post('user/status/{id}',                     [UserController::class, 'userStatus'])->name('user.userStatus');
        Route::post('categorytour/status/{id}',             [CategoryTourController::class, 'categorytourStatus'])->name('categorytour.categorytourStatus');
        Route::post('tour/status/{id}',                     [TourController::class, 'tourStatus'])->name('tour.tourStatus');
        Route::post('article/status/{id}',                  [ArticleController::class, 'articleStatus'])->name('article.articleStatus');
        Route::post('coupon/status/{id}',                   [CouponsController::class, 'couponStatus'])->name('coupon.couponStatus');
        Route::post('location/status/{id}',                 [LocationController::class, 'locationStatus'])->name('location.locationStatus');
        Route::post('category/status/{id}',                 [CategoryController::class, 'categoryStatus'])->name('category.categoryStatus');
        Route::post('category/hot/{id}',                    [CategoryController::class, 'categoryHot'])->name('category.categoryHot');
        Route::post('notifications/toggle-status/{id}',     [NotificationController::class, 'toggleStatus'])->name('notifications.toggleStatus');

        //filer status
        Route::get('categorytour',          [CategoryTourController::class, 'index'])->name('categorytour.index');
        Route::get('user',                  [UserController::class, 'index'])->name('user.index');
        Route::get('tour',                  [TourController::class, 'index'])->name('tour.index');
        Route::get('article',               [ArticleController::class, 'index'])->name('article.index');
        Route::get('coupons',               [CouponsController::class, 'index'])->name('coupons.index');
        Route::get('location',              [LocationController::class, 'index'])->name('location.index');
        Route::get('category',              [CategoryController::class, 'index'])->name('category.index');
        Route::get('advisory',              [AdvisoryController::class, 'index'])->name('advisory.index');
        Route::get('comment',               [CommentController::class, 'index'])->name('comment.index');

        // permissions
        Route::resource('permissions', PermissionController::class);
        Route::get('/permission-user', [PermissionUserController::class, 'index'])->name('permission-user.index');
        Route::get('/permission-user/create', [PermissionUserController::class, 'create'])->name('permission-user.create');
        Route::post('/permission-user', [PermissionUserController::class, 'store'])->name('permission-user.store');
        Route::delete('/per-user', [PermissionUserController::class, 'destroy'])->name('per-user.destroy');

        Route::get('/permissions-search', [PermissionUserController::class, 'searchPermissions'])->name('permissions.search');
        // end permissions
        Route::view('403', 'admin.errors.500');

        Route::get('payment-tour', [PayController::class, 'index'])->name('payment_tour.index');
        Route::post('payment-tour', [PayController::class, 'store'])->name('payment_tour.store');

        // Route cập nhật trạng thái tour
        Route::post('/trangthaitour/update/{id}', [PayController::class, 'update'])->name('trangthaitour.update');
        Route::get('/pay/{id}', [PayController::class, 'show'])->name('admins.pay.show');

        // Route cập nhật trạng thái thanh toán
        Route::post('/trangthaitour/updateThanhToan/{id}', [PayController::class, 'ThanhToan'])->name('trangthaitour.updateThanhToan');
        Route::get('/quanlytour/{id}', [PayController::class, 'show']);

        Route::get('contact',                              [AdminContactController::class, 'index'])->name('admin.contact.index');
        Route::post('contact/status/{id}',                 [AdminContactController::class, 'contactStatus'])->name('contact.contactStatus');
        Route::delete('contact/delete/{id}',               [AdminContactController::class, 'destroy'])->name('contact.delete');

        //logs tour
        Route::get('/change-logs', [ChangeLogController::class, 'index'])->name('change-logs.index');
        // end logs

        Route::get('/payment-tour/filter', [PayController::class, 'filter'])->name('admin.quanlytour.filter');
        Route::post('/filter-date-total', [StatisticalController::class, 'filterDateTotal'])->name('admin.filterTotal');


        //service
        Route::get('/service',                  [AdminServiceController::class, 'index'])->name('service.index');
        Route::get('/service/create',           [AdminServiceController::class, 'create'])->name('service.create');
        Route::post('/service/store',           [AdminServiceController::class, 'store'])->name('service.store');
        Route::get('/service/edit/{id}',        [AdminServiceController::class, 'edit'])->name('service.edit');
        Route::post('/service/update/{id}',     [AdminServiceController::class, 'update'])->name('service.update');

        Route::post('service/status/{id}',      [AdminServiceController::class, 'serviceStatus'])->name('service.serviceStatus');
        Route::post('/api/get-services-by-categories', [TourController::class, 'getServicesByCategories']);
        //end service   

        // category service
        Route::get('/category_service',                  [CategoryServiceController::class, 'index'])->name('category_service.index');
        Route::get('/category_service/create',           [CategoryServiceController::class, 'create'])->name('category_service.create');
        Route::post('/category_service/store',           [CategoryServiceController::class, 'store'])->name('category_service.store');
        Route::get('/category_service/edit/{id}',        [CategoryServiceController::class, 'edit'])->name('category_service.edit');
        Route::post('/category_service/update/{id}',     [CategoryServiceController::class, 'update'])->name('category_service.update');

        Route::post('category_service/status/{id}',      [CategoryServiceController::class, 'categoryserviceStatus'])->name('category_service.serviceStatus');
        //end category service

        // guide_manager
        Route::get('/guide-manager', [GuideManagerController::class, 'getToursByGuide'])->name('guide-manager.getToursByGuide');
        Route::get('/guide-manager/createguider/{id}', [GuideManagerController::class, 'createguider'])->name('guide-manager.createguider');

        Route::patch('guide-manager/update/{id}', [GuideManagerController::class, 'updateStatusPayment'])->name('guide-manager.updateStatusPayment');
        // web.php
Route::post('/update-location-status/{id}', [GuideManagerController::class, 'updateLocationStatus'])
->name('guide-manager.updateLocationStatus');

Route::post('/guide-manager/report-issue/{id}', [GuideManagerController::class, 'reportIssue'])->name('guide-manager.reportIssue');

        // end guide_manager

        // assign_guide(book_tour)
        Route::patch('guide-assign/{id}', [GuideManagerController::class, 'assignGuide'])->name('guide-assign');
        // assign_guide
        Route::get('/hdv', [HDVController::class, 'index'])->name('hdv.index');
        Route::post('/hdv/{id}/assign-guide', [HDVController::class, 'assignGuide'])->name('hdv.assignGuide');
        Route::post('/hdv/revoke/{id}', [HDVController::class, 'revokeGuide'])->name('hdv.revokeGuide');

    });
});

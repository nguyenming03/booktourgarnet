<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
    {
        // Kiểm tra nếu lỗi là 404 - Not Found
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            if ($this->isAdminRoute($request)) {
                // Trả về view lỗi cho admin
                return response()->view('admin.errors.404', [], 404);
            } else {
                // Trả về view lỗi cho client
                return response()->view('client.layouts.404', [], 404);
            }
        }

        // Xử lý các lỗi khác như mặc định
        return parent::render($request, $exception);
    }

    /**
     * Kiểm tra xem request có phải của admin không
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    private function isAdminRoute($request)
    {
        // Xác định bằng URL hoặc tên route
        return $request->is('admin/*'); // Kiểm tra nếu URL bắt đầu bằng "admin/"
    }
}

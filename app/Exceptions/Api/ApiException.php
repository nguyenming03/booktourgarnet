<?php

namespace App\Exceptions\Api;

use Exception;

/**
 * Exception nghiệp vụ (không phải lỗi hệ thống) ném ra từ tầng Service,
 * mang theo HTTP status code và (tùy chọn) danh sách lỗi chi tiết để
 * Controller/Exception Handler chuyển thẳng thành response JSON chuẩn.
 */
class ApiException extends Exception
{
    public function __construct(string $message, private readonly int $statusCode = 422, private readonly mixed $errors = null)
    {
        parent::__construct($message);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getErrors(): mixed
    {
        return $this->errors;
    }
}

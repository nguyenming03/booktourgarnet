<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

/**
 * Chuẩn hóa toàn bộ response JSON trả về từ API.
 *
 * Envelope thành công:
 * {
 *   "success": true,
 *   "message": "...",
 *   "data": ...,
 *   "meta": { ... }   // chỉ xuất hiện khi data được phân trang
 *   "links": { ... }  // chỉ xuất hiện khi data được phân trang
 * }
 *
 * Envelope lỗi:
 * {
 *   "success": false,
 *   "message": "...",
 *   "errors": { ... } // chi tiết lỗi validate (nếu có)
 * }
 */
trait ApiResponser
{
    /**
     * Trả về response thành công. $data có thể là mảng, Model, JsonResource,
     * ResourceCollection (kể cả khi bọc paginator) hoặc null.
     */
    protected function success($data = null, string $message = 'Thành công', int $code = 200): JsonResponse
    {
        $payload = [
            'success' => true,
            'message' => $message,
        ];

        if ($data instanceof ResourceCollection) {
            $wrapped = $data->response()->getData(true);
            $payload['data'] = $wrapped['data'] ?? [];
            if (isset($wrapped['meta'])) {
                $payload['meta'] = $wrapped['meta'];
            }
            if (isset($wrapped['links'])) {
                $payload['links'] = $wrapped['links'];
            }
        } elseif ($data instanceof JsonResource) {
            $wrapped = $data->response()->getData(true);
            $payload['data'] = $wrapped['data'] ?? $wrapped;
        } elseif ($data instanceof AbstractPaginator) {
            $payload['data'] = $data->items();
            $payload['meta'] = $this->paginationMeta($data);
        } else {
            $payload['data'] = $data;
        }

        return response()->json($payload, $code);
    }

    /**
     * Trả về response lỗi với thông điệp và (tùy chọn) chi tiết lỗi validate.
     */
    protected function error(string $message = 'Đã xảy ra lỗi', int $code = 400, $errors = null): JsonResponse
    {
        $payload = [
            'success' => false,
            'message' => $message,
        ];

        if (!is_null($errors)) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $code);
    }

    protected function notFound(string $message = 'Không tìm thấy dữ liệu'): JsonResponse
    {
        return $this->error($message, 404);
    }

    protected function unauthorized(string $message = 'Bạn cần đăng nhập để thực hiện thao tác này'): JsonResponse
    {
        return $this->error($message, 401);
    }

    protected function forbidden(string $message = 'Bạn không có quyền thực hiện thao tác này'): JsonResponse
    {
        return $this->error($message, 403);
    }

    protected function created($data = null, string $message = 'Tạo mới thành công'): JsonResponse
    {
        return $this->success($data, $message, 201);
    }

    /**
     * Giống success(), nhưng cho phép gắn thêm các khóa tùy ý ở cấp cao nhất
     * (ví dụ: "summary" thống kê đi kèm một danh sách phân trang).
     */
    protected function successWithExtra($data, array $extra, string $message = 'Thành công', int $code = 200): JsonResponse
    {
        $response = $this->success($data, $message, $code);
        $payload = array_merge($response->getData(true), $extra);

        return response()->json($payload, $response->getStatusCode());
    }

    private function paginationMeta(AbstractPaginator $paginator): array
    {
        $meta = [
            'current_page' => method_exists($paginator, 'currentPage') ? $paginator->currentPage() : null,
            'per_page' => $paginator->perPage(),
        ];

        if (method_exists($paginator, 'total')) {
            $meta['total'] = $paginator->total();
            $meta['last_page'] = $paginator->lastPage();
        }

        return $meta;
    }
}

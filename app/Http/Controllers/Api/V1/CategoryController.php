<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\Category\StoreCategoryRequest;
use App\Http\Requests\Api\Category\UpdateCategoryRequest;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\TourResource;
use App\Models\Admins\CategoryTour;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = CategoryTour::where('status', 1)
            ->withCount(['tours' => fn ($q) => $q->where('status', 1)])
            ->orderBy('category_tour', 'asc')
            ->get();

        return $this->success(CategoryResource::collection($categories), 'Danh sách danh mục.');
    }

    public function manageIndex(Request $request)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $categories = CategoryTour::withCount('tours')
            ->orderByDesc('id')
            ->get();

        return $this->success(CategoryResource::collection($categories), 'Danh sách tất cả danh mục.');
    }

    public function store(StoreCategoryRequest $request)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $category = CategoryTour::create($request->validated());

        return $this->created(new CategoryResource($category), 'Tạo danh mục thành công.');
    }

    public function show(string $slug)
    {
        $category = CategoryTour::where('slug', $slug)->where('status', 1)->first();

        if (!$category) {
            return $this->notFound('Không tìm thấy danh mục.');
        }

        $category->load(['tours' => fn ($q) => $q->where('status', 1)->with(['location', 'images'])]);

        return $this->success([
            'category' => new CategoryResource($category),
            'tours' => TourResource::collection($category->tours),
        ], 'Chi tiết danh mục.');
    }

    public function showById(string $id)
    {
        $category = CategoryTour::find($id);

        if (!$category) {
            return $this->notFound('Không tìm thấy danh mục.');
        }

        $category->load(['tours' => fn ($q) => $q->with(['location', 'images'])]);

        return $this->success([
            'category' => new CategoryResource($category),
            'tours' => TourResource::collection($category->tours),
        ], 'Chi tiết danh mục.');
    }

    public function update(UpdateCategoryRequest $request, string $id)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $category = CategoryTour::find($id);

        if (!$category) {
            return $this->notFound('Không tìm thấy danh mục.');
        }

        $category->update($request->validated());

        return $this->success(new CategoryResource($category->fresh()), 'Cập nhật danh mục thành công.');
    }

    public function destroy(Request $request, string $id)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $category = CategoryTour::find($id);

        if (!$category) {
            return $this->notFound('Không tìm thấy danh mục.');
        }

        if ($category->tours()->exists()) {
            return $this->error('Không thể xóa danh mục đang có tour. Hãy chuyển hoặc xóa các tour trước.', 409);
        }

        $category->delete();

        return $this->success(null, 'Xóa danh mục thành công.');
    }
}

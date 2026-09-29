<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\Tour\StoreTourRequest;
use App\Http\Requests\Api\Tour\UpdateTourRequest;
use App\Http\Resources\Api\TourResource;
use App\Models\Admins\CategoryTour;
use App\Models\Admins\Location;
use App\Models\Admins\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::query()
            ->with(['location', 'category_tour', 'images'])
            ->where('status', 1);

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('category_slug')) {
            $categoryId = CategoryTour::where('slug', $request->category_slug)->value('id');
            $query->when($categoryId, fn($q) => $q->where('category_tour_id', $categoryId));
        } elseif ($request->filled('category_id')) {
            $query->where('category_tour_id', $request->category_id);
        }

        if ($request->filled('location_slug')) {
            $locationId = Location::where('slug', $request->location_slug)->value('id');
            $query->when($locationId, fn($q) => $q->where('location_id', $locationId));
        } elseif ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->filled('price_min')) {
            $query->where('price_old', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price_old', '<=', $request->price_max);
        }

        match ($request->input('sort', 'latest')) {
            'price_asc' => $query->orderBy('price_old', 'asc'),
            'price_desc' => $query->orderBy('price_old', 'desc'),
            'popular' => $query->orderBy('view', 'desc'),
            default => $query->orderBy('id', 'desc'),
        };

        $perPage = min(max((int) $request->input('per_page', 12), 1), 50);
        $tours = $query->paginate($perPage)->appends($request->query());
        return $this->success(TourResource::collection($tours), 'Danh sách tour.');
    }

    /**
     * Danh sách tất cả tour dành cho quản trị/API client có quyền ghi.
     * Không lọc status để có thể kiểm tra cả tour đang ẩn.
     */
    public function manageIndex(Request $request)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $perPage = min(max((int) $request->input('per_page', 20), 1), 100);

        $tours = Tour::with(['location', 'category_tour', 'images'])
            ->when($request->filled('q'), fn($q) => $q->where('name', 'like', '%' . $request->q . '%'))
            ->orderByDesc('id')
            ->paginate($perPage);

        return $this->success(TourResource::collection($tours), 'Danh sách tất cả tour.');
    }

    public function store(StoreTourRequest $request)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $data = $request->validated();

        $data['user_id'] = $request->user()->id;
        $data['status'] = $data['status'] ?? true;
        $data['sale'] = $data['sale'] ?? 0;
        $data['number_registered'] = $data['number_registered'] ?? 0;
        $data['number'] = $data['number'] ?? max(0, (int) $data['number_guests'] - (int) $data['number_registered']);
        $data['view'] = 0;

        $tour = Tour::create($data);
        $tour->load(['location', 'category_tour', 'images']);

        return $this->created(new TourResource($tour), 'Tạo tour thành công.');
    }

    public function show(Request $request, string $id)
    {
        $tour = Tour::with(['location', 'category_tour', 'images', 'tourLocations'])->find($id);

        if (!$tour) {
            return $this->notFound('Không tìm thấy tour.');
        }

        if ((int) $tour->status === 1) {
            $tour->increment('view');
        }

        return $this->success(new TourResource($tour->fresh()->load(['location', 'category_tour', 'images', 'tourLocations'])), 'Chi tiết tour.');
    }

    public function update(UpdateTourRequest $request, string $id)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $tour = Tour::find($id);

        if (!$tour) {
            return $this->notFound('Không tìm thấy tour.');
        }

        $data = $request->validated();
        $tour->update($data);
        $tour->load(['location', 'category_tour', 'images']);

        return $this->success(new TourResource($tour), 'Cập nhật tour thành công.');
    }

    public function destroy(Request $request, string $id)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $tour = Tour::find($id);

        if (!$tour) {
            return $this->notFound('Không tìm thấy tour.');
        }

        $tour->delete();

        return $this->success(null, 'Xóa tour thành công.');
    }

    public function related(Request $request, string $id)
    {
        $tour = Tour::find($id);

        if (!$tour) {
            return $this->notFound('Không tìm thấy tour.');
        }

        $limit = min(max((int) $request->input('limit', 8), 1), 20);

        $related = Tour::where('id', '!=', $tour->id)
            ->where('status', 1)
            ->where(function ($q) use ($tour) {
                $q->where('category_tour_id', $tour->category_tour_id)
                    ->orWhere('location_id', $tour->location_id);
            })
            ->with(['location', 'category_tour', 'images'])
            ->orderByDesc('id')
            ->limit($limit)
            ->get();

        return $this->success(TourResource::collection($related), 'Tour liên quan.');
    }

    public function featured(Request $request)
    {
        $limit = min(max((int) $request->input('limit', 8), 1), 20);

        $tours = Tour::where('status', 1)
            ->with(['location', 'category_tour', 'images'])
            ->orderBy('view', 'desc')
            ->limit($limit)
            ->get();

        return $this->success(TourResource::collection($tours), 'Tour nổi bật.');
    }
}

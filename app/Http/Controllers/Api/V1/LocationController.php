<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\Location\StoreLocationRequest;
use App\Http\Requests\Api\Location\UpdateLocationRequest;
use App\Http\Resources\Api\LocationResource;
use App\Http\Resources\Api\TourResource;
use App\Models\Admins\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::where('status', 1)
            ->withCount(['tours' => fn ($q) => $q->where('status', 1)])
            ->orderBy('name', 'asc')
            ->get();

        return $this->success(LocationResource::collection($locations), 'Danh sách địa điểm.');
    }

    public function manageIndex(Request $request)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $locations = Location::withCount('tours')
            ->orderByDesc('id')
            ->get();

        return $this->success(LocationResource::collection($locations), 'Danh sách tất cả địa điểm.');
    }

    public function store(StoreLocationRequest $request)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['status'] = $data['status'] ?? true;

        $location = Location::create($data);

        return $this->created(new LocationResource($location), 'Tạo địa điểm thành công.');
    }

    public function show(string $slug)
    {
        $location = Location::where('slug', $slug)->where('status', 1)->first();

        if (!$location) {
            return $this->notFound('Không tìm thấy địa điểm.');
        }

        $location->load(['tours' => fn ($q) => $q->where('status', 1)->with(['category_tour', 'images'])]);

        return $this->success([
            'location' => new LocationResource($location),
            'tours' => TourResource::collection($location->tours),
        ], 'Chi tiết địa điểm.');
    }

    public function showById(string $id)
    {
        $location = Location::find($id);

        if (!$location) {
            return $this->notFound('Không tìm thấy địa điểm.');
        }

        $location->load(['tours' => fn ($q) => $q->with(['category_tour', 'images'])]);

        return $this->success([
            'location' => new LocationResource($location),
            'tours' => TourResource::collection($location->tours),
        ], 'Chi tiết địa điểm.');
    }

    public function update(UpdateLocationRequest $request, string $id)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $location = Location::find($id);

        if (!$location) {
            return $this->notFound('Không tìm thấy địa điểm.');
        }

        $location->update($request->validated());

        return $this->success(new LocationResource($location->fresh()), 'Cập nhật địa điểm thành công.');
    }

    public function destroy(Request $request, string $id)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $location = Location::find($id);

        if (!$location) {
            return $this->notFound('Không tìm thấy địa điểm.');
        }

        if ($location->tours()->exists()) {
            return $this->error('Không thể xóa địa điểm đang có tour. Hãy chuyển các tour sang địa điểm khác trước.', 409);
        }

        $location->delete();

        return $this->success(null, 'Xóa địa điểm thành công.');
    }
}

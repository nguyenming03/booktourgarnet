<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admins\CategoryServiceModel;
use Illuminate\Http\Request;

class CategoryServiceController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Danh Mục Dịch Vụ';
        $status = $request->get('status');
        $searchQuery = $request->get('search');

        $query = CategoryServiceModel::query();

        if ($status !== null) {
            $query->where('status', $status);
        }

        if ($searchQuery !== null && $searchQuery !== '') {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('category_services.category_name', 'like', '%' . $searchQuery . '%');
            });
        }
        $data['category_services'] = $query->get();
        if ($request->ajax()) {
            return response()->json([
                'data' => $data['category_services']
            ]);
        }
        return view('admin.category_services.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Thêm Danh Mục';
        return view('admin.category_services.create', $data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'category_name' => 'required|max:255|unique:category_services,category_name',
        ], [
            'category_name.required' => 'Vui lòng nhập tên danh mục',
            'category_name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
            'category_name.unique' => 'Danh mục này đã tồn tại trong hệ thống',
        ]);

        $category_service = new CategoryServiceModel();
        $category_service->category_name = trim($request->category_name);
        $category_service->status = $request->status ?? 1;
        $category_service->save();

        return redirect()->route('category_service.index')->with('success', 'Danh mục đã được thêm thành công');
    }

    public function edit($id)
    {
        $data['title'] = 'Chỉnh Sửa Danh Mục';
        $data['category_services'] = CategoryServiceModel::getSingle($id);
        return view('admin.category_services.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|max:255|unique:category_services,category_name,' . $id,
        ], [
            'category_name.required' => 'Vui lòng nhập tên danh mục',
            'category_name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
            'category_name.unique' => 'Danh mục này đã tồn tại trong hệ thống',
        ]);

        $category_service = CategoryServiceModel::getSingle($id);
        $category_service->category_name = trim($request->category_name);
        $category_service->status = $request->status ?? 1;
        $category_service->save();

        return redirect()->route('category_service.index')->with('success', 'Danh mục đã được cập nhật thành công');
    }

    public function categoryserviceStatus(Request $request, $id)
    {
        $service = CategoryServiceModel::getSingle($id);
        if (!$service) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy danh mục'], 404);
        }
        $service->status = $service->status == 0 ? 1 : 0;
        $service->save();

        return response()->json([
            'success' => true,
            'status' => $service->status
        ]);
    }
}

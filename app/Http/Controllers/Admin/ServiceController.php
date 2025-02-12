<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admins\CategoryServiceModel;
use App\Models\Admins\ServiceModel;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Dịch Vụ';
        $status = $request->get('status');
        $searchQuery = $request->get('search');

        $data['services'] = ServiceModel::getAll($status, $searchQuery);

        if ($request->ajax()) {
            return response()->json([
                'data' => $data['services']->items(),
            ]);
        }

        return view('admin.services.index', $data);
    }



    public function create()
    {
        $data['title'] = 'Thêm Dịch Vụ';
        $data['category_services'] = CategoryServiceModel::getAll();


        if ($data['category_services']->isEmpty()) {

            session()->flash('error', 'Vui lòng tạo danh mục dịch vụ trước.');
            return redirect()->route('admin.category_services.create');
        }

        return view('admin.services.create', $data);
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|max:255|unique:services,name',
            // 'price' => 'numeric',
            'description' => 'required|max:500',
            'category_service_id' => 'required|exists:category_services,id',
        ], [
            'name.required' => 'Vui lòng nhập tên dịch vụ',
            'name.max' => 'Tên dịch vụ không được vượt quá 255 ký tự',
            'name.unique' => 'Dịch vụ này đã tồn tại trong hệ thống',

            'price.required' => 'Vui lòng nhập giá dịch vụ',
            'price.numeric' => 'Giá dịch vụ phải là một số hợp lệ',

            'description.required' => 'Vui lòng nhập mô tả dịch vụ',
            'description.max' => 'Mô tả dịch vụ không được vượt quá 500 ký tự',

            'category_service_id.required' => 'Vui lòng chọn danh mục dịch vụ',
            'category_service_id.exists' => 'Danh mục dịch vụ không tồn tại trong hệ thống',

        ]);



        $service = new ServiceModel();
        $service->name = trim($request->name);
        $service->price = trim($request->price);
        $service->description = trim($request->description);
        $service->category_service_id = trim($request->category_service_id);
        $service->status = $request->status ?? 1;
        $service->save();

        return redirect()->route('service.index')->with('success', 'Dịch vụ đã được thêm thành công');
    }

    public function edit($id)
    {
        $data['title'] = 'Chỉnh Sửa Dịch Vụ';
        $data['service'] = ServiceModel::getSingle($id);
        $data['category_services'] = CategoryServiceModel::getAll();


        if ($data['category_services']->isEmpty()) {

            session()->flash('error', 'Vui lòng tạo danh mục dịch vụ trước.');
            return redirect()->route('admin.category_services.create');
        }
        return view('admin.services.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255|unique:services,name,' . $id,
            'price' => 'numeric',
            'description' => 'required|max:500',
            'category_service_id' => 'required|exists:category_services,id',
        ], [
            'name.required' => 'Vui lòng nhập tên dịch vụ',
            'name.max' => 'Tên dịch vụ không được vượt quá 255 ký tự',
            'name.unique' => 'Dịch vụ này đã tồn tại trong hệ thống',

            'price.required' => 'Vui lòng nhập giá dịch vụ',
            'price.numeric' => 'Giá dịch vụ phải là một số hợp lệ',

            'description.required' => 'Vui lòng nhập mô tả dịch vụ',
            'description.max' => 'Mô tả dịch vụ không được vượt quá 500 ký tự',

            'category_service_id.required' => 'Vui lòng chọn danh mục dịch vụ',
            'category_service_id.exists' => 'Danh mục dịch vụ không tồn tại trong hệ thống',
        ]);

        $service = ServiceModel::getSingle($id);
        $service->name = trim($request->name);
        $service->price = trim($request->price);
        $service->description = trim($request->description);
        $service->category_service_id = trim($request->category_service_id);
        $service->status = $request->status ?? 1;
        $service->save();

        return redirect()->route('service.index')->with('success', 'Dịch vụ đã được cập nhật thành công');
    }

    public function serviceStatus(Request $request, $id)
    {
        $service = ServiceModel::getSingle($id);
        if (!$service) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy dịch vụ'], 404);
        }
        $service->status = $service->status == 0 ? 1 : 0;
        $service->save();

        return response()->json([
            'success' => true,
            'status' => $service->status
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admins\Category;
use App\Models\Admins\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_category'])->only(['index']);
        // $this->middleware(['permission:create_category'])->only(['create']);
        // $this->middleware(['permission:store_category'])->only(['store']);
        // $this->middleware(['permission:edit_category'])->only(['edit']);
        // $this->middleware(['permission:update_category'])->only(['update']);
        // $this->middleware(['permission:destroy_category'])->only(['destroy']);
        // $this->middleware(['permission:show_category'])->only(['show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Danh Sách Danh Mục";

        $status = $request->get('status');
        $hot = $request->get('hot');

        $query = Category::query();

        if ($status !== null) {
            $query->where('status', $status);
        }

        if ($hot !== null) {
            $query->where('hot', $hot);
        }

        $listCategory = $query->get();
        $listUser = User::query()->get();

        if ($request->ajax()) {

            return response()->json([
                'data' => $listCategory
            ]);
        }
        return view('admin.category.index', compact('listCategory', 'listUser', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $title = "Thêm Danh Mục";
        $listUser = User::query()->get();
        $parents = Category::all();
        return view('admin.category.add', compact('parents', 'listUser'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {

        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            // Lấy trực tiếp giá trị từ dropdown
            $params['status'] = $request->input('status');
            // Xử lý hình ảnh đại diện
            if ($request->hasFile('img_thumb')) {
                $params['img_thumb'] = $request->file('img_thumb')->store('uploads/thumbnails', 'public');
            } else {
                $params['img_thumb'] = null;
            }
            try {
                // Thêm sản phẩm
                $category = Category::query()->create($params);
                return redirect()
                    ->route('category.index')
                    ->with('success', 'Thêm mới thành công!');;
            } catch (\Exception $e) {
                return redirect()
                    ->route('category.index')
                    ->with('error', 'Có lỗi xảy ra khi thêm danh mục!');
            }
        }
    }






    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $category = Category::findOrFail($id);
        return view('admin.category.details', compact('category')); // Trả về view chi tiết tour
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $title = "Sửa Danh Mục";
        $category = Category::findOrFail($id);

        // Truyền danh sách cha và thông tin người dùng để hiển thị trong form
        $parents = Category::where('id', '!=', $id)->get(); // Không cho phép chọn chính nó làm cha
        $listUser = User::query()->get();

        return view('admin.category.edit', compact('category', 'parents', 'listUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        // Lấy thông tin danh mục cần cập nhật
        $category = Category::findOrFail($id);

        // Lấy các tham số từ request, ngoại trừ `_token` và `_method`
        $params = $request->except('_token', '_method');

        // Cập nhật hình ảnh nếu có
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $article = Category::findOrFail($id);

            // Xử lý Hình Ảnh
            $params['img_thumb'] = $request->file('img_thumb')
                ? $request->file('img_thumb')->store('uploads/thumbnails', 'public')
                : 'default-thumbnail.jpg'; // or set null if the column is nullable


            // Cập nhật dữ liệu
            $category->update($params);

            return redirect()->route('category.index')->with('success', 'Cập nhật thành công!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Tìm và xóa danh mục
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Xóa danh mục thành công!');
    }


    public function categoryStatus(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Lỗi'], 404);
        }

        $category->status = $category->status == 0 ? 1 : 0;
        $category->save();

        return response()->json([
            'success' => true,
            'status' => $category->status
        ]);
    }

    public function categoryHot(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Lỗi'], 404);
        }

        $category->hot = $category->hot == 0 ? 1 : 0;
        $category->save();

        return response()->json([
            'success' => true,
            'status' => $category->hot
        ]);
    }
}

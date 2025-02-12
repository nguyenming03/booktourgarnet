<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admins\Article;
use App\Models\Admins\Category;
use App\Models\Admins\User;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_article'])->only(['index']);

        // $this->middleware(['permission:create_article'])->only(['create']);
        // $this->middleware(['permission:store_article'])->only(['store']);
        // $this->middleware(['permission:edit_article'])->only(['edit']);
        // $this->middleware(['permission:update_article'])->only(['update']);
        // $this->middleware(['permission:destroy_article'])->only(['destroy']);
        // $this->middleware(['permission:show_article'])->only(['show']);

        

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Danh Sách Bài Viết";

        $listUser = User::all();
        $listCategory = Category::all();
        $query = Article::query()->orderByDesc('id');


        $status = $request->get('status');
        if ($status !== null) {
            $query->where('status', $status);
        }

        if ($request->ajax()) {

            $listArticle = $query->with('category')->get();

            return response()->json([
                'data' => $listArticle
            ]);
        }


        $listArticle = $query->get();

        return view('admin.article.index', compact('title', 'listArticle', 'listCategory', 'listUser'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $title = "Thêm Bài Viết";
        $listCategory = Category::all(); // Lấy tất cả danh mục
        $listUser = User::query()->get();
        return view('admin.article.create', compact('listUser', 'listCategory'));
    }
    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    //     if ($request->isMethod('POST')) {
    //         $params = $request->except('_token');

    //         // Lấy trực tiếp giá trị từ dropdown
    //         $params['status'] = $request->input('status');

    //         // Xử lý hình ảnh đại diện
    //         $params['img_thumb'] = $request->file('img_thumb') 
    //         ? $request->file('img_thumb')->store('uploads/thumbnails', 'public') 
    //         : 'default-thumbnail.jpg'; // or set null if the column is nullable

    //         // Thêm sản phẩm
    //         $user = Article::query()->create($params);

    //         // Lấy id sản phẩm vừa thêm để thêm được album
    //         $user = $user->id;

    //         return redirect()->route('article.index')->with('success', 'Thêm bài viết thành công!');
    //     }
    // }
    public function store(ArticleRequest $request)
    {
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            // dd($request);

            // Lấy trực tiếp giá trị từ dropdown
            $params['status'] = $request->input('status');

            // Xử lý hình ảnh đại diện
            if ($request->hasFile('img_thumb')) {
                $params['img_thumb'] = $request->file('img_thumb')->store('uploads/thumbnails', 'public');
            } else {
                $params['img_thumb'] = null;
            }

            // Thêm sản phẩm
            $article = Article::query()->create($params);

            // Lấy id sản phẩm vừa thêm để thêm được album
            $article = $article->id;
            // $article = Article::query()->create($params);
            //Lấy id sản phẩm vừa thêm để thêm được album 
            //Xử lý thêm album

            return redirect()->route('article.index')->with('success', 'Thêm mới thành công!');
            return redirect()->route('article.index')->with('success', 'Thêm mới thành công!');
        }
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        $article = Article::findOrFail($id); // Lấy thông tin của location
        return view('admin.article.details', compact('article'));  // Trả về view chi tiết
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Sửa Bài Viết";
        $article = Article::query()->findOrFail($id);
        $listCategory = Category::all();
        $listUser = User::query()->get();
        return view('admin.article.edit', compact('article', 'listCategory', 'listUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $params = $request->except('_token', '_method');
            $article = Article::findOrFail($id);

            // Xử lý Hình Ảnh
            if ($request->hasFile('img_thumb')) {
                if ($article->img_thumb && Storage::disk('public')->exists($article->img_thumb)) {
                    Storage::disk('public')->delete($article->img_thumb); // Xóa ảnh cũ
                }
                $params['img_thumb'] = $request->file('img_thumb')->store('uploads/thumbnails', 'public');
            }

            // Cập nhật dữ liệu
            $article->update($params);

            return redirect()->route('article.index')->with('success', 'Cập nhật thành công!');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if ($request->isMethod('DELETE')) {
            $article = Article::find($id);

            if (!$article) {
                return redirect()->route('article.index')->with('error', 'Bài viết không tồn tại.');
            }

            // Xóa ảnh đại diện nếu có
            if ($article->img_thumb && Storage::disk('public')->exists($article->img_thumb)) {
                Storage::disk('public')->delete($article->img_thumb);
            }

            $article->delete();

            return redirect()->route('article.index')->with('success', 'Xóa bài viết thành công.');
        }
    }


    public function articleStatus(Request $request, $id)
    {
        $artic = Article::find($id);
        if (!$artic) {
            return response()->json(['success' => false, 'message' => 'Lỗi'], 404);
        }

        $artic->status = $artic->status == 0 ? 1 : 0;
        $artic->save();

        return response()->json([
            'success' => true,
            'status' => $artic->status
        ]);
    }
}

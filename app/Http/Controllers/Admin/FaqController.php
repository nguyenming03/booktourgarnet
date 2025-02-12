<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_faq'])->only(['index']);
        $this->middleware(['permission:create_faq'])->only(['create']);
        $this->middleware(['permission:store_faq'])->only(['store']);
        $this->middleware(['permission:edit_faq'])->only(['edit']);
        $this->middleware(['permission:update_faq'])->only(['update']);
        $this->middleware(['permission:destroy_faq'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Danh Sách FAQS";

        if (request()->ajax()) {
            $faqs = Faq::select('faqs.*'); // Lấy kèm dữ liệu của status
            return DataTables()->of($faqs)
                ->addColumn('status', function ($faq) {
                    if ($faq->status == 1) {
                        return '<span class="text-success">Hiển thị</span>';
                    } else {
                        return '<span class="text-danger">Ẩn</span>';
                    }
                })
                ->addColumn('action', function ($faq) {
                    $editUrl = route('faqs.edit', $faq->id);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-subtle-secondary btn-icon btn-sm edit-item-btn" data-id="' . $faq->id . '"><i class="ph-pencil"></i></a>
                        <a href="#deleteRecordModal" id="deleteItem" data-bs-toggle="modal" data-id="' . $faq->id . '" class="btn btn-subtle-danger btn-icon btn-sm remove-item-btn"><i class="ph-trash"></i></a>
                    ';
                })
                ->rawColumns(['status', 'action']) // Cho phép HTML hiển thị trong các cột này
                ->make(true);
        }

        return view('admin.faq.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Danh Sách FAQS";
        return view('admin.faq.add', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'question' => 'required|min:3',
            'answer' => 'required|min:3',
            'status' => 'required|min:0|max:1',
        ]);
        // dd($request);
        if ($data) {
            Faq::create($data);
            session()->flash('success', 'Thêm mới thành công.');
            return back();
        } else {
            session()->flash('error', 'Thêm mới thất bại.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        $title = "Danh Sách FAQS";
        return view('admin.faq.edit', compact('title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'question' => 'required|min:3',
            'answer' => 'required|min:3',
            'status' => 'required|min:0|max:1',
        ]);
        // dd($request);
        if ($data) {
            $faq->update($data);
            session()->flash('success', 'Cập nhật thành công.');
            return back();
        } else {
            session()->flash('error', 'Cập nhật thất bại.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $check = $faq->delete();
        if ($check) {

            return response()->json([
                'status' => true,
                'message' => 'xóa thành công.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Xóa thất bại.'
            ]);
        }
    }
}

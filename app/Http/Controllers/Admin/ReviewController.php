<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admins\Review;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_review'])->only(['index']);
        // $this->middleware(['permission:destroy_review'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listReview = Review::paginate(10); // Lấy 10 bản ghi mỗi trang
        return view('admin.review.index', compact('listReview'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function destroy(Request $request, string $id)
    {
        if ($request->isMethod('DELETE')) {
            $review = Review::find($id);

            if (!$review) {
                return redirect()->route('review.index')->with('error', 'Đánh giá không tồn tại.');
            }

            $review->delete();

            return redirect()->route('review.index')->with('success', 'Xóa đánh giá thành công.');
        }
    }
}

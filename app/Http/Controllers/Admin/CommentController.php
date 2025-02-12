<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admins\Tour;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_comment'])->only(['index']);
        // $this->middleware(['permission:destroy_comment'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['title'] = "Danh Sách Bình Luận";

        $status = $request->get('status');
        $searchQuery = $request->get('search');

        $query = Comment::query();

        if ($status !== null) {
            $query->where('comment.status', $status);
        }

        if ($searchQuery !== null && $searchQuery !== '') {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('comment.name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('tour.name', 'like', '%' . $searchQuery . '%');
            });
        }

        $query->join('tours', 'tours.id', '=', 'comment.tour_id')

//         ->join('users', 'users.id', '=', 'comment.user_id') 
//         ->select('comment.*', 'tours.name as tour_name', 'users.name as user_name');  

            ->join('users', 'users.id', '=', 'comment.user_id')
            ->select('comment.*', 'tours.name as tour_name', 'users.name as user_name');

        $data['listComments'] = $query->get();

        if ($request->ajax()) {
            return response()->json([
                'data' => $data['listComments']
            ]);
        }
        return view('admin.comment.index', $data);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $comment = Comment::findOrFail($id);


            $comment->deleted_at = now();
            $comment->save();


            return response()->json([
                'success' => true,
                'message' => 'Xóa bình luận thành công!',
            ]);
        } catch (\Exception $e) {

            Log::error('Lỗi khi xóa bình luận: ' . $e->getMessage());


            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.',
            ], 500);
        }
    }


    public function commentStatus(Request $request, $id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json(['success' => false, 'message' => 'Lỗi'], 404);
        }

        $comment->status = $comment->status == 0 ? 1 : 0;
        $comment->save();

        return response()->json([
            'success' => true,
            'status' => $comment->status
        ]);
    }
    public function storeComment(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);
        // Validate dữ liệu
        $validated = $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id', // Để trả lời bình luận
            'anonymous_name' => 'nullable|string|max:255',
        ]);
        // Tạo bình luận
        $comment = Comment::create([
            'tour_id' => $tour->id,
            'user_id' => auth()->check() ? auth()->id() : null,
            'parent_id' => $validated['parent_id'] ?? null,
            'anonymous_name' => auth()->check() ? null : $validated['anonymous_name'],
            'content' => $validated['content'],
        ]);
        // Trả về phản hồi JSON
        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'user_name' => $comment->user ? $comment->user->name : $comment->anonymous_name,
                'user_avatar' => $comment->user ? Storage::url($comment->user->avatar) : asset('default-avatar.png'),
                'created_at' => $comment->created_at->format('d M Y, H:i'),
                'content' => $comment->content,
            ],
        ]);
    }
    public function storeReply(Request $request, $tour_id, $comment_id)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500',
            'tour_id' => 'required|exists:tours,id',
            'parent_id' => 'required|exists:comments,id',
        ]);
        try {
            $reply = Comment::create([
                'tour_id' => $tour_id,
                'user_id' => auth()->id(),
                'content' => $validated['content'],
                'parent_id' => $comment_id,
            ]);
            return response()->json([
                'status' => 'success',
                'reply' => [
                    'user_name' => $reply->user->name,
                    'avatar' => Storage::url($reply->user->avatar),
                    'created_at' => $reply->created_at->diffForHumans(),
                    'content' => $reply->content,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau.',
            ], 500);
        }
    }





}

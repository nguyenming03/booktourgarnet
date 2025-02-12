<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id(); // ID người dùng hiện tại

        $favorite_tours = Favorite::with('tour') // lấy data của tour
            ->where('user_id', $userId)
            ->get();

        return view('client.pages.favorite', compact('favorite_tours'));
    }

    public function addToFavorite(Request $request)
    {
        $userId = auth()->id(); // Lấy ID người dùng hiện tại

        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Bạn cần đăng nhập để thêm vào danh sách yêu thích!']);
        }

        $tourId = $request->tour_id;

        // Kiểm tra nếu đã tồn tại
        $exists = Favorite::where('user_id', $userId)->where('tour_id', $tourId)->exists();

        if ($exists) {
            return response()->json(['status' => 'error', 'message' => 'Tour đã có trong danh sách yêu thích!']);
        }

        // Lưu vào cơ sở dữ liệu
        Favorite::create([
            'user_id' => $userId, // Truyền giá trị user_id
            'tour_id' => $tourId,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Đã thêm vào danh sách yêu thích!']);
    }

    public function removeFavorite(Request $request)
    {
        $favorite = Favorite::findOrFail($request->id);
        $favorite->delete();

        return response()->json(['status' => true, 'message' => 'Xóa thành công!']);
    }
}

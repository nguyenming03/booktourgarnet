<?php

namespace App\Http\Controllers\Client;

use NoCaptcha;
use App\Models\Admins\Tour;
use Illuminate\Http\Request;
use App\Models\Admins\Location;
use App\Http\Controllers\Controller;
use App\Models\Admins\Article;
use App\Models\Admins\Category;
use App\Models\Admins\CategoryTour;
use App\Models\Article as ModelsArticle;

use App\Models\Comment;
use App\Models\Coupon;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Rating;
use App\Models\Review;
use App\Models\TourLocation;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class HomeController extends Controller
{
    //
    public function index(Request $request)
    {
        // Lấy tất cả các tour theo thứ tự giảm dần theo ID
        $listtour = Tour::orderByDesc('id')->get();
        $listarticle = Article::inRandomOrder()->first();
        $listarticles = Article::inRandomOrder()->take(4)->get();

        // Lấy 6 tour được xem nhiều nhất
        $Tourmoinhat = Tour::withoutTrashed()
            ->where('status', 1)
            ->orderBy('view', 'desc')
            ->take(6)
            ->get();


        // Tính điểm trung bình của mỗi tour trong danh sách mới nhất
        foreach ($Tourmoinhat as $tour) {
            $tour->average_rating = Review::where('tour_id', $tour->id)->avg('rating');
            $tour->rating_count = Review::where('tour_id', $tour->id)->count();
        }



        // Lấy tất cả các danh mục cha (không có parent_id)
        $categoryes = Category::whereNull('parent_id')->with('children')->get();

        // Lấy tất cả các danh mục tour cùng với các tour thuộc mỗi danh mục
        $categories = CategoryTour::with('tours')->get();

        // Lấy ngẫu nhiên 5 địa điểm có trạng thái 'active' và chưa bị xóa
        $locations = Location::where('status', 1)
            ->whereNull('deleted_at')
            ->inRandomOrder()
            ->take(5)
            ->get();

        $article = Article::where('status', 1)
            ->inRandomOrder() // Lấy dữ liệu theo thứ tự ngẫu nhiên
            ->take(6)         // Giới hạn số lượng bài viết là 4
            ->get();


        // // Lấy thông báo
        // $notifications = collect(); // Tạo một collection rỗng mặc định
        // $unreadNotifications = collect(); // Thông báo chưa đọc
        // $user = auth()->user();

        // if ($user) {
        //     $notifications = Notification::query()
        //         ->whereHas('users', function ($q) use ($user) {
        //             $q->where('user_id', $user->id); // Lấy thông báo dành riêng cho người dùng
        //         })
        //         ->where('is_active', 1) // Chỉ lấy thông báo đang hoạt động
        //         ->orderByDesc('created_at') // Sắp xếp thông báo mới nhất
        //         ->get();

        //     // Lấy thông báo chưa đọc
        //     $unreadNotifications = Notification::query()
        //     ->whereHas('users', function ($q) use ($user) {
        //         $q->where('user_id', $user->id)
        //           ->where('is_read', 0); // Chỉ lấy thông báo chưa đọc
        //     })
        //     ->where('is_active', 1)
        //     ->orderByDesc('created_at')
        //     ->get();
        // }


        return view('client.home', compact('listarticles', 'listarticle', 'listtour', 'Tourmoinhat', 'locations', 'categories', 'categoryes', 'article'));
    }
    public function show($id)
    {
        $tour = Tour::findOrFail($id);
        $suggestedTours = Tour::inRandomOrder()->take(6)->get();

        // Lấy bình luận gốc (parent_id = null) và kèm theo các bình luận con
        $comments = Comment::where('post_id', $tour->id)
            ->whereNull('parent_id')
            ->with('children', 'user')
            ->get();

        return view('posts.show', compact('post', 'comments'));
    }

    public function detailTour($id)
    {
        $tour = Tour::with(['tourDates', 'tourLocations.location'])->findOrFail($id);
//         $dates = DB::table('tour_dates')->where('tour_id', $tour['id'])->get();
// dd($dates);
        // Truy vấn các ngày liên quan trong bảng tour_dates thông qua mối quan hệ đã định nghĩa
    $tourDates = $tour->tourDates->pluck('tour_date')->toArray(); // Lấy danh sách ngày dưới dạng mảng
// Debug để kiểm tra kết quả
    // dd($tourDates);
        $suggestedTours = Tour::withoutTrashed()
            ->where('status', 1)
            ->inRandomOrder()
            ->distinct('id')
            ->take(6)
            ->get();


        $averageRating = Review::where('tour_id', $id)->avg('rating');

        $tour->increment('view');

        $userHasBooked = false;
        $canReview = false;

        if (auth()->check()) {
            $userId = auth()->id();

            $userHasBooked = DB::table('book_tour')
                ->where('tour_id', $id)
                ->where('user_id', $userId)
                ->exists();
            $canReview = Payment::join('book_tour', 'payments.booking_id', '=', 'book_tour.id')
                ->where('book_tour.tour_id', $id)
                ->where('book_tour.user_id', $userId)
                ->where('payments.status_id', 6)
                ->exists();
        }
        $itineraries = $tour->tourLocations->map(function ($location) {
            return [
                'start_date' => $location->start_date, // Ngày bắt đầu
                'end_date' => $location->end_date,     // Ngày kết thúc
                'location_name' => $location->location->name ?? 'Không xác định', // Tên địa điểm
                'is_start' => $location->is_start,
                'is_end' => $location->is_end,
            ];
        });


        // $tourDates = $tour->tourDates->pluck('tour_date');

        $tour = Tour::with(['categoryServices' => function ($query) {
            $query->where('status', 1);
        }, 'services' => function ($query) {
            $query->where('status', 1);
        }])->findOrFail($id);

        $uniqueCategories = $tour->categoryServices->unique('id');

        $tourLocations = DB::table('tour_locations')
            ->where('tour_id', $id)
            ->get();

        $data = [
            'tour' => $tour,
            'averageRating' => round($averageRating, 1),
            'category' => Category::find($tour->category_tour_id),
            'images' => $tour->images,
            'first_image' => $tour->images->first(),
            'comments' => Comment::where('tour_id', $tour->id)
                ->whereNull('parent_id')
                ->with('children.user')
                ->get(),
            'userHasBooked' => $userHasBooked,
            'canReview' => $canReview,
            'suggestedTours' => $suggestedTours,
            'itineraries' => $itineraries,
            'tourDates' => $tourDates,
            'uniqueCategories' => $uniqueCategories,
            'tourLocations' => $tourLocations,
        ];
        return view('client.tour.detail', $data);
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

    public function store(Request $request, $tourId)
    {
        $userId = auth()->id();

        // Kiểm tra người dùng đã hoàn tất tour (trạng thái tour = 6 trong bảng payments)


        // Kiểm tra xem người dùng đã đánh giá tour này chưa
        $existingReview = Review::where('user_id', $userId)->where('tour_id', $tourId)->first();
        if ($existingReview) {
            return response()->json(['error' => 'Bạn đã đánh giá tour này.'], 400);
        }

        // Lưu đánh giá
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Review::create([
            'user_id' => $userId,
            'tour_id' => $tourId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json(['success' => 'Đánh giá của bạn đã được lưu!']);
    }

    public function allTour()
    {
        $tours = Tour::where('status', 1)->get();

        foreach ($tours as $tour) {
            $tour->average_rating = Review::where('tour_id', $tour->id)->avg('rating');
            $tour->rating_count = Review::where('tour_id', $tour->id)->count();
        }

        $data = [
            'header_title' => "Tất Cả Tour",
            'getTour' => $tours,
            'locations' => Location::where('status', 1)->get(),
            'ratings' => Rating::select('ratings.*')->get(),
        ];

        return view('client.pages.tourAll', $data);
    }

    public function filter(Request $request)
    {
        try {
            $query = Tour::query();

            if ($request->has('min_price') && $request->has('max_price')) {
                $minPrice = $request->min_price;
                $maxPrice = $request->max_price;
                if (is_numeric($minPrice) && is_numeric($maxPrice)) {
                    $query->whereBetween('price_old', [$minPrice, $maxPrice]);
                }
            }

            if ($request->has('location') && !empty($request->location)) {
                $location = $request->location;
                $query->where('location_id', $location);
            }

            if ($request->has('rating') && !empty($request->rating)) {
                $ratingId = $request->rating;


                if (is_numeric($ratingId) && $ratingId >= 1 && $ratingId <= 5) {
                    $query->whereHas('reviews', function ($q) use ($ratingId) {
                        $q->where('rating', $ratingId);
                    });
                }
            }


            $tours = $query->with('reviews')->get();

            foreach ($tours as $tour) {
                $tour->average_rating = $tour->reviews->avg('rating');
                $tour->rating_count = $tour->reviews->count();
            }
            return response()->json([
                'success' => true,
                'html' => view('client.pages.filter_results', compact('tours'))->render()
            ]);
        } catch (\Exception $e) {

            Log::error('Lỗi trong filter: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra'], 500);
        }
    }
}

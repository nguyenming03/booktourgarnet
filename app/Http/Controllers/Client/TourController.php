<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdvisoryRequest;
use App\Models\Admins\Categorys;
use App\Models\Admins\Location;
use App\Models\Admins\Review;
use App\Models\Admins\Tour;
use App\Models\Advisory;
use App\Models\BookTour;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Http\Request;

class TourController extends Controller
{
    // public function index()
    // {
    //     //

    //     $listtour = Tour::orderBYDesc('id')->get();

    //     // dd($listtour);

    //     // $listlocation = Location::query()->get();

    //     return view('client.home', compact('listtour'));
    // }

    public function show(string $id)
    {

        $tour = Tour::query()->findOrFail($id);

        return view('client.tour.detail', compact('tour'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    public function confirm($id)
    {
        $booking = BookTour::findOrFail($id);

        return view('client.tour.confirm', ['booking' => $booking]); // Trả về view confirm
    }

    //     public function confirm($id)
    // {
    //     $booking = BookTour::findOrFail($id); 

    //     return view('client.tour.confirm', ['booking' => $booking]);
    // }

    public function pre_booking($id)
    {
        $tour = Tour::findOrFail($id);
        $coupons = Coupon::where('status', 1)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('tour_id', '=', $id)
            ->where('number', '>', 0)
            ->select('code', 'percentage_price', 'start_date', 'end_date')
            ->get()
            ->map(function ($coupon) {
                $coupon->start_date = \Carbon\Carbon::parse($coupon->start_date)->format('d-m-Y');
                $coupon->end_date = \Carbon\Carbon::parse($coupon->end_date)->format('d-m-Y');
                return $coupon;
            });

        return view('client.tour.booking', ['tour' => $tour, 'coupons' => $coupons]);
    }


    public function searchTour(Request $request)
    {
        $query = $request->input('query');
        $tours = Tour::search($query)->paginate(12);
        return view('client.pages.search', compact('tours'));
    }
    public function detailTour($id)
    {
        $data['tour'] = Tour::find($id);
        $data['category'] = Category::find($data['tour']->category_tour_id);
        $data['location'] = Location::find($data['tour']->location_id);
        $data['images'] = $data['tour']->images;
        $data['first_image'] = $data['images']->first();
        // dd($data['images']);  

        return view('client.tour.detail', $data);
    }


    public function showTour()
    {
        return view('client.tour.detail1');
    }

    public function tour($slug)
    {
        $category = Category::with('tours')->where('slug', $slug)->firstOrFail();


        foreach ($category->tours as $tour) {
            $tour->average_rating = Review::where('tour_id', $tour->id)->avg('rating');
            $tour->rating_count = Review::where('tour_id', $tour->id)->count();
        }

        return view('client.pages.tour', compact('category'));
    }

    public function advisory(AdvisoryRequest $request)
    {
        try {
            $advisory = new Advisory;
            $advisory->tour_id = $request->tour_id;
            $advisory->name = $request->name;
            $advisory->phone_number = $request->phone_number;
            $advisory->email = $request->email;
            $advisory->content = $request->content;
            $advisory->status = "Đang chờ xử lý";
            $advisory->save();

            return response()->json([
                'success' => true,
                'message' => 'Thông tin tư vấn đã được gửi thành công.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã có lỗi. Vui lòng thử lại',
            ]);
        }
    }

    public function tourLocation($slug)
    {
        $location = Location::where('slug', $slug)->firstOrFail();

        $tours = $location->tours()->with(['location'])->where('status', 1)->get();

        return view('client.pages.tour_location', compact('location', 'tours'));
    }
}

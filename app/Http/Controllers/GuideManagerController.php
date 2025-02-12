<?php

namespace App\Http\Controllers;

use App\Models\Admins\Tour;
use App\Models\BookTour;
use App\Models\Guide;
use App\Models\Payment;
use App\Models\TourLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GuideManagerController extends Controller
{
    public function getToursByGuide()
    {
        $user = Auth::user();

        // Kiểm tra nếu người dùng có hướng dẫn viên (guide) gắn kèm
        $guide = $user->guide;

        // Nếu không có hướng dẫn viên, trả về thông báo hoặc điều hướng khác
        if (!$guide) {
            return redirect()->route('home-admin')->with('error', 'Không tìm thấy hướng dẫn viên cho người dùng này.');
        }

        // Lấy thông tin hướng dẫn viên và các tour mà họ được gán
        $guideTours = Guide::with(['tours.tour']) // Eager load tours
            ->where('id', $guide->id)
            ->first();


        // if (!$guideTours) {
        //     return redirect()->route('home-admin')->with('error', 'Hướng dẫn viên không có tour nào được gán.');
        // }

        // dd($guideTours);
        // Trả về view với danh sách tour
        return view('admin.guide_manager.index', compact('guideTours'));
    }
    public function createguider($id)
    {
        $user = Auth::user();
    
        // Kiểm tra nếu người dùng có hướng dẫn viên (guide) gắn kèm
        $guide = $user->guide;
    
        // Nếu không có hướng dẫn viên, trả về thông báo hoặc điều hướng khác
        if (!$guide) {
            return redirect()->route('home-admin')->with('error', 'Không tìm thấy hướng dẫn viên cho người dùng này.');
        }
    
        // Truy vấn bảng book_tour để lấy tour_id từ id được truyền vào
        $bookTour = DB::table('book_tour')->where('id', $id)->first();
    
        // Kiểm tra nếu không tìm thấy book_tour
        if (!$bookTour) {
            return redirect()->route('home-admin')->with('error', 'Không tìm thấy thông tin booking.');
        }
    
        // Lấy thông tin từ bảng payment dựa trên booking_id
        $payment = DB::table('payments')->where('booking_id', $id)->first();
    
        // Kiểm tra nếu không tìm thấy payment
        if (!$payment) {
            return redirect()->route('home-admin')->with('error', 'Không tìm thấy thông tin thanh toán cho booking này.');
        }
    
        // Lấy thông tin hướng dẫn viên và các tour mà họ được gán (lọc theo pay_id)
        $guideTours = Guide::with(['tours' => function ($query) use ($payment) {
                $query->where('pay_id', $payment->id); // Chỉ lấy tour có pay_id khớp
            }])
            ->where('id', $guide->id)
            ->first();
    
        // Dùng booking_id để truy vấn bảng customer_tour_locations
        $tourLocations = DB::table('customer_tour_locations')
            ->where('booking_id', $id)
            ->get();
    
        // Kiểm tra nếu không có lịch trình
        if ($tourLocations->isEmpty()) {
            return redirect()->route('home-admin')->with('error', 'Không tìm thấy lịch trình cho booking này.');
        }
    
        // Kiểm tra tất cả lịch trình đã được xác nhận
        $allConfirmed = $tourLocations->every(function ($location) {
            return $location->status == 1; // status = 1 là đã xác nhận
        });
    
        // Trả về view với danh sách lịch trình, trạng thái xác nhận và thông tin thanh toán
        return view('admin.guide_manager.xacnhan', compact('tourLocations', 'allConfirmed', 'payment', 'guideTours'));
    }
    
    



    
    
    public function updateStatusPayment($id)
    {
        try {
            $payment = Payment::findOrFail($id);
    
            // Kiểm tra nếu payment không liên kết với booking
            $bookTour = DB::table('book_tour')->where('id', $payment->booking_id)->first();
            if (!$bookTour) {
                return redirect()->back()->with('error', 'Không tìm thấy thông tin booking.');
            }
    
            $bookingId = $bookTour->id;
    
            // Kiểm tra tất cả lịch trình trong customer_tour_locations đã được xác nhận
            $unconfirmedLocations = DB::table('customer_tour_locations')
                ->where('booking_id', $bookingId)
                ->where('status', 0) // Chỉ kiểm tra status = 0 (chưa được xác nhận)
                ->count();
    
            if ($unconfirmedLocations > 0) {
                return redirect()->back()->with('error', 'Vẫn còn lịch trình chưa được xác nhận.');
            }
    
            // Tất cả lịch trình đã được xác nhận
            $payment->status_id = 6; // 6: Trạng thái hoàn thành
            $payment->save();
    
            return redirect()->back()->with('success', 'Tour đã được hoàn thành.');
        } catch (\Exception $e) {
            \Log::error('Lỗi hoàn thành tour: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    

    public function assignGuide(Request $request, $id)
    {
        // Validate input
        $validatedData = $request->validate([
            'guide_id' => 'required|exists:guides,id',
        ]);
    
        // Tìm booking tour
        $bookingTour = BookTour::find($id);
    
        if (!$bookingTour) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy booking tour với ID: ' . $id,
            ], 404);
        }
    
        // Kiểm tra nếu booking có ngày bắt đầu và ngày kết thúc
        if (!$bookingTour->start_date || !$bookingTour->end_date) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tour không có thông tin ngày bắt đầu hoặc ngày kết thúc.',
            ], 400);
        }
    
        // Kiểm tra trùng lịch với các bản ghi khác
        $conflictingBookings = BookTour::where('guide_id', $validatedData['guide_id'])
            ->where(function ($query) use ($bookingTour) {
                $query->whereBetween('start_date', [$bookingTour->start_date, $bookingTour->end_date])
                    ->orWhereBetween('end_date', [$bookingTour->start_date, $bookingTour->end_date])
                    ->orWhere(function ($q) use ($bookingTour) {
                        $q->where('start_date', '<=', $bookingTour->start_date)
                            ->where('end_date', '>=', $bookingTour->end_date);
                    });
            })
            ->exists();
    
        if ($conflictingBookings) {
            return response()->json([
                'success' => false,
                'message' => 'Hướng dẫn viên đã được gán cho một tour khác trong khoảng thời gian này.',
            ], 400);
        }
    
        // Gán hướng dẫn viên cho booking tour
        $bookingTour->guide_id = $validatedData['guide_id'];
        $bookingTour->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Hướng dẫn viên đã được gán thành công!',
        ]);
    }
    





    
public function updateLocationStatus(Request $request, $id)
{
    try {
        $location = DB::table('customer_tour_locations')->where('id', $id)->first();

        if (!$location) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy lịch trình.']);
        }

        // Cập nhật trạng thái của lịch trình
        DB::table('customer_tour_locations')->where('id', $id)->update([
            'status' => $request->input('status', 1) // Đặt status = 1
        ]);

        // Lấy thông tin booking_id từ lịch trình
        $bookingId = $location->booking_id;

        // Kiểm tra nếu tất cả các lịch trình trước đó chưa được xác nhận
        $unconfirmedLocations = DB::table('customer_tour_locations')
            ->where('booking_id', $bookingId)
            ->where('id', '!=', $id) // Loại trừ lịch trình hiện tại
            ->where('status', 1) // Đếm số lịch trình đã được xác nhận
            ->count();

        if ($unconfirmedLocations == 0) {
            // Lấy thông tin payment liên kết với booking
            $payment = Payment::where('booking_id', $bookingId)->first();
            if ($payment) {
                // Cập nhật trạng thái payment thành "Tour đang diễn ra"
                $payment->status_id = 3; // 3: Trạng thái "Tour đang diễn ra"
                $payment->save();
            }
        }

        return response()->json(['success' => true, 'message' => 'Lịch trình đã được xác nhận.']);
    } catch (\Exception $e) {
        \Log::error('Lỗi khi xác nhận lịch trình: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
    }
}

public function reportIssue(Request $request, $id)
{
    try {
        // Lấy thông tin từ bảng customer_tour_locations
        $location = DB::table('customer_tour_locations')->where('id', $id)->first();

        if (!$location) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy lịch trình.']);
        }

        // Cập nhật lý do gặp sự cố
        DB::table('customer_tour_locations')->where('id', $id)->update([
            'suco' => $request->input('reason')
        ]);

        // Lấy thông tin payment từ booking_id
        $bookingId = $location->booking_id;

        $payment = Payment::where('booking_id', $bookingId)->first();
        if ($payment) {
            // Chuyển trạng thái của payment sang 4 (Tour gặp sự cố)
            $payment->status_id = 4; // 4: Trạng thái gặp sự cố
            $payment->save();
        }

        return response()->json(['success' => true, 'message' => 'Trạng thái tour đã được cập nhật.']);
    } catch (\Exception $e) {
        \Log::error('Lỗi khi báo sự cố: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
    }
}


    

}

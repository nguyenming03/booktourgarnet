<?php

namespace App\Http\Controllers\Client;

use App\Models\Admins\Tour;
use Illuminate\Http\Request;
use App\Models\Admins\Location;
use App\Http\Controllers\Controller;
use App\Models\Admins\Customer;
use App\Models\BookTour;
use App\Models\Coupon;
use App\Models\Payment;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class BookingController extends Controller
{

    public function store(Request $request)
    {
        // Xác thực dữ liệu gửi lên
        $messages = [
            'name.required' => 'Vui lòng nhập tên của bạn.',
            'name.string' => 'Tên phải là chuỗi.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.string' => 'Số điện thoại phải là chuỗi.',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu phải là ngày hợp lệ.',
            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.date' => 'Ngày kết thúc phải là ngày hợp lệ.',
            'number_old.required' => 'Số lượng người lớn là bắt buộc.',
            'number_old.integer' => 'Số lượng người lớn phải là số nguyên.',
            'number_children.required' => 'Số lượng trẻ em là bắt buộc.',
            'number_children.integer' => 'Số lượng trẻ em phải là số nguyên.',
            'total_money.required' => 'Tổng tiền là bắt buộc.',
            'total_money.numeric' => 'Tổng tiền phải là số.',
            'tour_id.required' => 'Tour là bắt buộc.',
            'tour_id.exists' => 'Tour không tồn tại.',
            'g-recaptcha-response.required' => 'Vui lòng xác minh.',
            'g-recaptcha-response.captcha' => 'Captcha không hợp lệ.',
            'agree_policy.required' => 'Bạn cần đồng ý với chính sách để tiếp tục.',
        ];
    
        // Xác thực dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'note' => 'nullable|string',
            'number_old' => 'required|integer|min:0',
            'number_children' => 'required|integer|min:0',
            'total_money' => 'required|numeric|min:0',
            'status' => 'nullable|integer',
            'sale' => 'nullable|integer',
            'tour_id' => 'required|exists:tours,id',
            'g-recaptcha-response' => 'required|captcha',
            'agree_policy' => 'required',
        ], $messages);
    
        // Kiểm tra mã giảm giá
        $coupon = DB::table('coupons')
            ->where('code', $request->coupon)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('number', '>', 0)
            ->where('tour_id', $validated['tour_id'])
            ->first();
    
        if ($coupon) {
            session(['code' => $coupon->code]);
        }
    
        // Xử lý khách hàng
        if (auth()->check()) {
            $customerId = auth()->user()->id;
            $userId = auth()->user()->id;
        } else {
            $temporaryUserId = Session::get('temporary_user_id');
            if (!$temporaryUserId) {
                $temporaryUserId = Str::uuid();
                Session::put('temporary_user_id', $temporaryUserId);
            }
    
            $customer = Customer::firstOrCreate(
                ['temporary_user_id' => $temporaryUserId],
                [
                    'name' => $validated['name'] ?? 'Khách hàng ẩn danh',
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'type' => 'anonymous',
                ]
            );
    
            $customerId = $customer->id;
            $userId = null;
        }
    
        // Tạo bản ghi book_tour và sao chép lịch trình
        $bookTour = null;
        DB::transaction(function () use ($validated, $customerId, $userId, &$bookTour) {
            // Tạo bản ghi đặt tour
            $bookTour = BookTour::create([
                'customer_id' => $customerId,
                'user_id' => $userId,
                'tour_id' => $validated['tour_id'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'date_booking' => now(),
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'note' => $validated['note'] ?? null,
                'number_old' => $validated['number_old'],
                'number_children' => $validated['number_children'],
                'total_money' => $validated['total_money'],
                'status' => $validated['status'] ?? 0,
                'sale' => $validated['sale'] ?? 0,
            ]);
    
            // Sao chép lịch trình từ tour_locations sang customer_tour_locations
            $this->storeCustomerTourLocations($bookTour->id, $validated['tour_id']);
        });
    
        // Kiểm tra và chuyển hướng
        if ($bookTour && $bookTour->id) {
            return redirect()->route('tour.confirm', ['id' => $bookTour->id]);
        }
    
        return redirect()->back()->withErrors(['error' => 'Đặt tour không thành công. Vui lòng thử lại.']);
    }
    
    /**
     * Sao chép lịch trình từ bảng tour_locations sang customer_tour_locations
     */
    private function storeCustomerTourLocations($bookingId, $tourId)
    {
        $tourLocations = DB::table('tour_locations')->where('tour_id', $tourId)->get();
    
        foreach ($tourLocations as $location) {
            DB::table('customer_tour_locations')->insert([
                'booking_id' => $bookingId,
                'start' => $location->start ?? null,
                'end' => $location->end ?? null,
                'description' => $location->description ?? null,
                'status' => 0,
                'suco' => $location->suco ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    



    public function showBookingInfo($id)
    {

        $code = session('code');




        // Lấy thông tin đặt tour từ bảng book_tour
        $booking = BookTour::findOrFail($id);
        //dd($booking);
        // $pay = Payment::findOrFail($id);
        $booking1 = BookTour::with('tour')->find($id);

        if (!$booking1) {
            return redirect()->back()->with('error', 'Booking not found');
        }

        $tourName = $booking1->tour ? $booking->tour->name : 'No Tour Found';


        // Trả về view và truyền dữ liệu
        return view('client.tour.confirm', compact('booking', 'tourName', 'booking1', 'code'));
    }
}

<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\BookingSuccess;
use App\Models\Admins\Tour;
use App\Models\BookTour;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    // Xử lý lưu thanh toán
    public function storePayment(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'money' => 'required|numeric',
            'p_note' => 'nullable|string|max:255',
            'customer_name' => 'required_if:user_id,null|string|max:255',
            'customer_email' => 'required_if:user_id,null|email|max:255',
            'customer_phone' => 'required_if:user_id,null|string|max:20',
        ]);

        // Lấy thông tin booking
        $booking = BookTour::find($request->booking_id);
        if (!$booking) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin đặt tour!');
        }

        /// Lấy thông tin tour
        $tour = Tour::find($booking->tour_id);

        if (!$tour) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin tour!');
        }

        // Kiểm tra trạng thái tour
        if ($tour->status == 0) {
            return redirect()->back()->with('error', 'Tour này đã bị ẩn và không thể đặt!');
        }

        // Kiểm tra số lượng tour
        if ($tour->number < 1) {
            return redirect()->back()->with('error', 'Tour đã hết số lượng!');
        }

        // Giảm số lượng trong bảng Tour trước khi tiếp tục xử lý
        $tour->decrement('number');

        // Lấy trạng thái thanh toán mặc định
        $pendingStatus = DB::table('payment_statuses')->where('name', 'Chưa thanh toán')->first();

        $coupon = Coupon::where('code', $request->coupon)->first();
        $paymentMethod = DB::table('payment_methods')->find($request->payment_method_id);
        if (!$paymentMethod) {
            return redirect()->back()->with('error', 'Phương thức thanh toán không hợp lệ!');
        }

        // Xử lý thông tin khách hàng
        if (auth()->check()) {
            // Đã đăng nhập
            $customerId = auth()->user()->id;
            $userId = auth()->user()->id;
        } else {
            // Xử lý khách hàng ẩn danh
            $temporaryUserId = Session::get('temporary_user_id');
            if (!$temporaryUserId) {
                $temporaryUserId = (string) Str::uuid();
                Session::put('temporary_user_id', $temporaryUserId);
            }

            // Tìm khách hàng ẩn danh
            $customer = DB::table('customers')->where('temporary_user_id', $temporaryUserId)->first();

            if (!$customer) {
                // Nếu chưa tồn tại, tạo khách hàng mới
                $customerId = DB::table('customers')->insertGetId([
                    'name' => $request->customer_name,
                    'email' => $request->customer_email,
                    'phone' => $request->customer_phone,
                    'temporary_user_id' => $temporaryUserId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $customerId = $customer->id;
            }

            $userId = null; // Không có user_id vì là khách ẩn danh
        }

        // Tạo thanh toán
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'customer_id' => $customerId,
            'user_id' => $userId,
            'money' => $request->money,
            'p_note' => $request->p_note,
            'payment_status_id' => $pendingStatus->id,
            'payment_method_id' => $paymentMethod->id,
            'coupon_id' => $coupon ? $coupon->id : null,
            'status_id' => 1,
            'time' => now(),
        ]);

        // Cập nhật cột pay_id trong bảng book_tour
        $booking->update([
            'pay_id' => $payment->id,
        ]);

        // Nếu có mã giảm giá, giảm số lượng của mã
        if ($coupon && $coupon->number > 0) {
            $coupon->decrement('number', 1);
            session()->forget('code');
        }

        if ($paymentMethod->name === 'direct') {
            // Mail::to($booking['email'])->send(new BookingSuccess($payment));
            return redirect()->route('payment.success', ['payment_id' => $payment->id]);
        }

        return redirect()->back()->with('error', 'Phương thức thanh toán không hợp lệ!');
    }








    public function success($payment_id)
    {
        $payment = Payment::find($payment_id);

        $tour_id = BookTour::find($payment->booking_id)?->tour_id;
        $tour = Tour::find($tour_id);
        $tour_name = $tour->name;
        $start_date = $tour->start_date;
        $schedule = $tour->schedule;
        //         $tour_name = Tour::find($tour_id)?->name;
        // $start_date = Tour::find($tour_id)?->start_date;
        $guest = BookTour::find($payment->booking_id)?->number_old + BookTour::find($payment->booking_id)?->number_children;

        $name = BookTour::find($payment->booking_id)?->name;

        if (PaymentMethod::find($payment->payment_method_id)?->name == "direct") {
            $payment_method = "Thanh toán trực tiếp tại điểm check-in";
        } else {
            $payment_method = PaymentMethod::find($payment->payment_method_id)?->name;
        }

        if (!$payment) {
            return redirect()->route('payment.failed')->with('error', 'Không tìm thấy thông tin thanh toán!');
        }
        // Kiểm tra trạng thái của tour
        if ($tour->status == 0) {
            return redirect()->route('payment.failed')->with('error', 'Tour này đã bị ẩn và không thể tiếp tục xử lý!');
        }

        // Lấy thông tin booking từ payment
        $booking = BookTour::findOrFail($payment->booking_id);

        // Lấy trạng thái "Đã thanh toán" từ bảng payment_statuses
        $paidStatus = DB::table('payment_statuses')->where('name', 'Đã thanh toán')->first();

        // Kiểm tra phương thức thanh toán
        $paymentMethod = DB::table('payment_methods')->find($payment->payment_method_id);

        if (!$paymentMethod) {
            return redirect()->route('payment.failed')->with('error', 'Phương thức thanh toán không hợp lệ!');
        }

        // Nếu thanh toán qua VNPay hoặc các phương thức online
        if ($paymentMethod->name === 'vnpay' || $paymentMethod->name === 'credit-card') {
            // Cập nhật trạng thái thanh toán thành "Đã thanh toán"
            $payment->payment_status_id = $paidStatus->id;
            $payment->save();
            // Kiểm tra số lượng tour
            if ($tour->number < 1) {
                return redirect()->route('payment.failed')->with('error', 'Tour này đã bị ẩn và không thể tiếp tục xử lý!');
            }
            // Giảm số lượng trong bảng Tour
            $tour = Tour::find($tour_id);
            $tour->decrement('number'); // Giảm 1 đơn vị số lượng

            // Xử lý dữ liệu gửi email
            $payment_status = PaymentStatus::find($payment->payment_status_id)?->name;
            $data = [
                'name_tour' => $tour_name,
                'user' => $name,
                'payment_status' => $payment_status,
                'payment_method' => $payment_method,
                'start_date' => $start_date,
                'booked_time' => $payment->time,
                'money' => $payment->money,
                'guests' => $guest,
                'code' => $payment->code_vnpay
            ];
            $pdfData = [
                'customer_name' => $name,
                'name_tour' => $tour_name,
                'money' => $payment->money,
                'start_date' => $start_date,
                'payment_status' => $payment_status,
                'payment_method' => $payment_method,
                'schedule' => $schedule,

                'guests' => $guest,
                'code' => $payment->code_vnpay,
                'time' => $payment->time,
                'bookings' => $payment->bookTours->map(function ($booking) {
                    return [
                        'tour_name' => $booking->tour_name,
                        'date' => $booking->date,
                        'guests' => $booking->guests,
                        'total_price' => $booking->total_price,
                    ];
                }),
            ];

            // Gửi email thông báo cho khách hàng
            Mail::to($booking['email'])->queue(new BookingSuccess($data, $pdfData));

            // Trả về view success cho thanh toán online
            return view('client.payment.success-online', compact('payment', 'booking'));
        }

        // Nếu thanh toán trực tiếp (Cash on Delivery)
        if ($paymentMethod->name === 'direct') {
            // Cập nhật trạng thái thanh toán thành "Chờ thanh toán"
            $pendingStatus = DB::table('payment_statuses')->where('name', 'Chưa thanh toán')->first();
            $payment->payment_status_id = $pendingStatus->id;
            $payment->save();

            // // Giảm số lượng trong bảng Tour
            // $tour = Tour::find($tour_id);
            // $tour->decrement('number'); // Giảm 1 đơn vị số lượng

            // Xử lý dữ liệu gửi email
            $payment_status = PaymentStatus::find($payment->payment_status_id)?->name;
            $data = [
                'name_tour' => $tour_name,
                'user' => $name,
                'payment_status' => $payment_status,
                'payment_method' => $payment_method,
                'start_date' => $start_date,
                'booked_time' => $payment->time,
                'money' => $payment->money,
                'guests' => $guest,
                'code' => $payment->code_vnpay
            ];
            $pdfData = [
                'customer_name' => $name,
                'name_tour' => $tour_name,
                'money' => $payment->money,
                'start_date' => $start_date,
                'payment_status' => $payment_status,
                'payment_method' => $payment_method,
                'schedule' => $schedule,

                'guests' => $guest,
                'code' => $payment->code_vnpay,
                'time' => $payment->time,
                'bookings' => $payment->bookTours->map(function ($booking) {
                    return [
                        'tour_name' => $booking->tour_name,
                        'date' => $booking->date,
                        'guests' => $booking->guests,
                        'total_price' => $booking->total_price,
                    ];
                }),
            ];
            $paymentLocation = "Hà Nội"; // hoặc xác định nơi thanh toán
            Mail::to($booking['email'])->queue(new BookingSuccess($data, $pdfData));

            // Trả về view success cho thanh toán trực tiếp
            return view('client.payment.success-direct', compact('payment', 'booking', 'paymentLocation'));
        }

        // Nếu phương thức thanh toán không hợp lệ
        return redirect()->route('payment.failed')->with('error', 'Phương thức thanh toán không hợp lệ!');
    }



    public function vnpayCancel(Request $request)
    {
        $payment = Payment::where('transaction', $request->vnp_TxnRef)->first();

        if ($payment) {

            $cancelledStatus = DB::table('statuses')->where('name', 'Huỷ')->first();
            $payment->status_id = $cancelledStatus->id;
            $payment->save();
        }

        return redirect()->route('payment.failed')->with('error', 'Thanh toán VNPay đã bị huỷ.');
    }
    public function vnpay_payment(Request $request)
    {

        // Xử lý thông tin khách hàng
        if (auth()->check()) {
            // Nếu người dùng đã đăng nhập
            $customerId = auth()->user()->id;
            $userId = auth()->user()->id;
        } else {
            // Nếu người dùng chưa đăng nhập, tạo khách hàng ẩn danh
            $temporaryUserId = Session::get('temporary_user_id');
            if (!$temporaryUserId) {
                $temporaryUserId = (string) Str::uuid(); // Tạo UUID
                Session::put('temporary_user_id', $temporaryUserId);
            }

            // Kiểm tra xem khách hàng ẩn danh đã tồn tại trong bảng customers chưa
            $customer = DB::table('customers')->where('temporary_user_id', $temporaryUserId)->first();

            if (!$customer) {
                // Tạo khách hàng mới nếu chưa tồn tại
                $customerId = DB::table('customers')->insertGetId([
                    'name' => $request->customer_name,
                    'email' => $request->customer_email,
                    'phone' => $request->customer_phone,
                    'temporary_user_id' => $temporaryUserId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $customerId = $customer->id; // Sử dụng ID của khách hàng đã tồn tại
            }

            $userId = null; // Không có user_id vì người dùng không đăng nhập
        }
        $userId = auth()->user()->id ?? null;
        $booking = BookTour::find($request->booking_id);

        if (!$booking) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin đặt tour!');
        }


        $pendingStatus = DB::table('payment_statuses')->where('name', 'Chưa thanh toán')->first();


        $payment = Payment::create([
            'booking_id' => $booking->id,
            'user_id' => $userId,
            'customer_id' => $customerId,
            'money' => $request->money,
            'p_note' => $request->input('p_note', ''),
            'payment_method' => 'vnpay',
            'payment_method_id' => intval($request->payment_method_id),
            'payment_status_id' => $pendingStatus->id,
            'time' => now(),

        ]);
        // Cập nhật cột pay_id trong bảng book_tour
        $booking->update([
            'pay_id' => $payment->id,
        ]);


        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('payment.vnpayReturn', ['payment_id' => $payment->id]);
        $vnp_TmnCode = "GKKOYDOM"; // Mã website tại VNPAY 
        $vnp_HashSecret = "07HSNBEXRMJQYXP7MLGNGRTRBVMQI68M"; // Chuỗi bí mật


        $vnp_TxnRef = $payment->id;
        $vnp_OrderInfo = 'Thanh toán đơn hàng ID ' . $payment->id;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->money * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];


        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );


        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }


        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        // Tính mã bảo mật
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        // Trả về URL thanh toán VNPay
        $returnData = array(
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url,
        );


        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }


    public function vnpayReturn(Request $request)
    {

        $vnp_response_code = $request->input('vnp_ResponseCode');
        $payment_id = $request->input('vnp_TxnRef');
        $code_vnpay = $request->input('vnp_TransactionNo');


        $payment = Payment::find($payment_id);

        if (!$payment) {
            return redirect()->route('payment.failed')->with('error', 'Không tìm thấy giao dịch!');
        }


        if ($vnp_response_code === '00') {

            $payment->vnp_response_code = $vnp_response_code;
            $payment->transaction = $payment_id;
            $payment->code_vnpay = $code_vnpay;
            $payment->payment_status_id = DB::table('payment_statuses')->where('name', 'Đã thanh toán')->first()->id;
            $payment->save();


            return redirect()->route('payment.success', ['payment_id' => $payment->id])
                ->with('success', 'Thanh toán thành công!');
        } else {
            // Nếu thanh toán bị hủy (ví dụ như có trạng thái "Đã huỷ")
            $payment->vnp_response_code = $vnp_response_code;
            $payment->transaction = $payment_id;
            $payment->code_vnpay = $code_vnpay;
            $payment->status_id = DB::table('statuses')->where('name', 'Đã huỷ')->first()->id;
            $payment->save();


            return redirect()->route('payment.failed', ['payment_id' => $payment->id])
                ->with('error', 'Thanh toán đã bị hủy!');
        }
    }


    public function failure()
    {

        return view('client.payment.failure');
    }
}

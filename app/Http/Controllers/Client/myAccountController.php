<?php

namespace App\Http\Controllers\Client;

use App\Models\BookTour;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Admins\Customer;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class myAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Kiểm tra nếu người dùng đã đăng nhập
        if (auth()->check()) {
            // Lấy thông tin người dùng đã đăng nhập
            $user = auth()->user();

            // Lấy `temporary_user_id` của người dùng (nếu có)
            $temporaryUserId = $user->temporary_user_id;

            // Lấy danh sách thanh toán dựa trên user_id hoặc customer_id thông qua temporary_user_id
            $payments = Payment::where(function ($query) use ($user, $temporaryUserId) {
                $query->where('user_id', $user->id); // Lấy các payment liên quan tới user_id
                if ($temporaryUserId) {
                    // Tìm khách hàng ẩn danh theo temporary_user_id
                    $anonymousCustomer = Customer::where('temporary_user_id', $temporaryUserId)->first();
                    if ($anonymousCustomer) {
                        $query->orWhere('customer_id', $anonymousCustomer->id);
                    }
                }
            })
                ->with(['booking.tour', 'paymentStatus', 'paymentMethod'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Nếu không đăng nhập, lấy temporary_user_id từ session
            $temporaryUserId = Session::get('temporary_user_id');

            if (!$temporaryUserId) {
                return redirect()->route('home')->with('error', 'Không tìm thấy thông tin khách hàng ẩn danh.');
            }

            // Tìm khách hàng ẩn danh dựa trên temporary_user_id
            $customer = Customer::where('temporary_user_id', $temporaryUserId)->first();

            if (!$customer) {
                return redirect()->route('home')->with('error', 'Không tìm thấy khách hàng ẩn danh.');
            }

            // Lấy danh sách thanh toán của khách hàng ẩn danh
            $payments = Payment::where('customer_id', $customer->id)
                ->with(['booking.tour', 'paymentStatus', 'paymentMethod'])
                ->orderBy('created_at', 'desc')
                ->get();

            // Vì không có người dùng đăng nhập, không cần truyền biến $user
            $user = null;
        }

        // Trả về view với thông tin người dùng và danh sách thanh toán
        return view('client.myAccount.Account', compact('user', 'payments'));
    }





    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string|min:6|max:255',
            'new_password' => 'required|string|min:6|max:255|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'current_password.string' => 'Mật khẩu hiện tại phải là chuỗi ký tự.',
            'current_password.min' => 'Mật khẩu hiện tại phải có ít nhất 6 ký tự.',
            'current_password.max' => 'Mật khẩu hiện tại không được vượt quá 255 ký tự.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.string' => 'Mật khẩu mới phải là chuỗi ký tự.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'new_password.max' => 'Mật khẩu mới không được vượt quá 255 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);


        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mật khẩu hiện tại không đúng.'
            ], 400);
        }


        $user = auth()->user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Đổi mật khẩu thành công.'
        ]);
    }

    public function addressNew(Request $request)
    {
        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits:10',
            'address' => 'required|string|max:255',
            'zip' => 'nullable|string|max:10',
            'IsDefault' => 'nullable|boolean',
        ], [
            'name.required' => 'Vui lòng nhập tên.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'phone.digits' => 'Số điện thoại phải có 10 chữ số.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'zip.string' => 'Mã bưu chính phải là chuỗi ký tự.',
            'zip.max' => 'Mã bưu chính không được vượt quá 10 ký tự.',
            'IsDefault.boolean' => 'Trạng thái mặc định phải là true hoặc false.',
        ]);

        // Cập nhật thông tin người dùng
        $user = auth()->user();
        $user->name = $request->name ?? auth()->user()->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật địa chỉ thành công!',
        ]);
    }
    public function detailDoHang($id)
    {
        $payment = Payment::with([
            'booking.tour',
            'booking.status',
            'paymentMethod',
            'paymentStatus',
            'user',
            'booking'
        ])->findOrFail($id);

        return view('client.myAccount.detailDonHang', compact('payment'));
    }

    public function cancelOrder(Request $request, $id)
    {
        // Validate lý do hủy
        $request->validate([
            'ly_do_huy' => 'required|string|max:255',
        ]);

        // Tìm thông tin thanh toán và booking liên quan
        $payment = Payment::with(['booking', 'booking.tour'])->findOrFail($id);
        $bookTour = $payment->booking;

        if (!$bookTour) {
            return redirect()->back()->with('error', 'Thông tin đặt tour không tồn tại.');
        }
        if ($payment->status_id == 2) {
            return redirect()->back()->with('error', 'Tour đã được xác nhận, không thể hủy nếu có vẫn đề hãy liên hệ với chúng tôi.');
        }
        if ($payment->status_id == 5) {
            return redirect()->back()->with('error', 'Tour đang diễn ra, không thể hủy nếu có vẫn đề hãy liên hệ với chúng tôi.');
        }
        // // Kiểm tra nếu tour đã hoàn thành (status_id = 6)
        // if ($payment->status_id == 6) {
        //     return redirect()->back()->with('error', 'Tour đã hoàn thành, không thể hủy nếu có vẫn đề hãy liên hệ với chúng tôi.');
        // }

        // Kiểm tra nếu tour đã hoàn thành (status_id = 6)
        if ($payment->status_id == 6) {
            return redirect()->back()->with('error', 'Tour đã hoàn thành, không thể hủy nếu có vẫn đề hãy liên hệ với chúng tôi.');
        }

        // Kiểm tra điều kiện thanh toán VNPay
        if ($payment->payment_status_id != 2) {
            // Nếu không phải thanh toán qua VNPay, cho phép hủy mà không hoàn lại tiền
            $bookTour->ly_do_huy = $request->ly_do_huy;
            $bookTour->status = 13; // Đặt trạng thái "Đã hủy"
            $bookTour->save();

            $payment->status_id = 13; // Đặt trạng thái "Đã hủy"
            $payment->save();

            return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công.');
        }

        // Lấy ngày đặt tour và ngày hiện tại
        $bookingStartDate = $bookTour->start_date; // Ngày bắt đầu từ booking
        $currentDate = now();                      // Ngày hiện tại

        // Kiểm tra điều kiện hoàn tiền
        $refundRate = 1.0; // Mặc định hoàn lại 100%
        if ($currentDate->greaterThanOrEqualTo($bookingStartDate)) {
            $refundRate = 0.9; // Hoàn lại 90% nếu đã qua ngày đặt
        }

        $refundAmount = $payment->money * $refundRate;

        // Cập nhật trạng thái đặt tour và thanh toán
        $bookTour->ly_do_huy = $request->ly_do_huy;
        $bookTour->status = 13; // Đặt trạng thái "Đã hủy"
        $bookTour->save();

        $payment->status_id = 13; // Đặt trạng thái "Đã hủy"
        $payment->refund_amount = $refundAmount;
        $payment->save();

        // Gửi thông báo thành công với thông tin hoàn tiền
        $message = "Đơn hàng đã được hủy thành công. Số tiền hoàn lại: "
            . number_format($refundAmount, 0, ',', '.') . "đ.Vui lòng gửi yêu cầu hoàn tiền ở dưới. Chúng tôi sẽ liên hệ với bạn sớm nhất";

        return redirect()->back()->with('success', $message);
    }
    public function submitRefundRequest(Request $request, $id)
    {

        $request->validate([
            'account_name'   => 'required|string|max:255', // Tên tài khoản
            'account_number' => 'required|string|max:50',  // Số tài khoản
            'bank' => 'required|string|max:50',  // Số tài khoản
            'qr_code'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ảnh QR (tùy chọn)
        ]);

        // Tìm thông tin thanh toán và booking liên quan
        $payment = Payment::with(['booking', 'booking.tour'])->findOrFail($id);
        $bookTour = $payment->booking;

        // Kiểm tra nếu không có booking hoặc không tồn tại
        if (!$bookTour) {
            return redirect()->back()->with('error', 'Thông tin đặt tour không tồn tại.');
        }

        // Lưu đường dẫn ảnh QR nếu được tải lên
        $qrCodePath = null;
        if ($request->hasFile('qr_code')) {
            $qrCodePath = $request->file('qr_code')->store('qr_codes', 'public'); // Lưu vào thư mục `storage/app/public/qr_codes`
        }

        // Cập nhật thông tin vào bảng `book_tour`
        $bookTour->update([
            'account_name'   => $request->account_name,
            'account_number' => $request->account_number,
            'bank' => $request->bank,
            'qr_code'        => $qrCodePath,
        ]);

        // Gửi thông báo hoặc phản hồi về kết quả
        return redirect()->back()->with('success', 'Yêu cầu hoàn tiền đã được gửi thành công. Chúng tôi sẽ xử lý trong thời gian sớm nhất.');
    }
}

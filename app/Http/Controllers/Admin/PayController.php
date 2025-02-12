<?php

namespace App\Http\Controllers\Admin;

use App\Models\Status;
use App\Models\Payment;
use App\Models\BookTour;
use App\Models\Admins\Tour;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Guide;

class PayController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_pay'])->only(['index']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Danh Sách Đơn Hàng";


        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');


        $query = Payment::query()->orderByDesc('id');


        if ($startDate && $endDate) {
            $query->whereBetween('time', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('time', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('time', '<=', $endDate);
        }

        $listTour = $query->paginate(10);

        // $listTour = $query->get();
        $trangThaiTour = Status::pluck('name', 'id')->toArray();
        $trangThaiThanhToan = PaymentStatus::pluck('name', 'id')->toArray();
        // dd($listTour, $trangThaiTour, $trangThaiThanhToan);

        if ($request->ajax()) {

            return response()->json([
                'data' => $listTour,
                'trangThaiTour' => $trangThaiTour,
                'trangThaiThanhToan' => $trangThaiThanhToan,
            ]);
        }
        $guides =  Guide::all(['id','name']);


        return view('admin.quanlytour.index', compact('title', 'listTour', 'trangThaiTour', 'trangThaiThanhToan', 'guides'));
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
        $quanlytour = Payment::findOrFail($id);

        return view('admin.quanlytour.details', compact('quanlytour'));  // Trả về view chi tiết
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
    // public function update(Request $request, string $id)
    // {
    //     // Tìm thông tin Payment
    //     $tour = Payment::query()->findOrFail($id);

    //     // Lấy giá trị hiện tại và giá trị mới
    //     $paymentStatusId = $tour->payment_status_id;
    //     $currentTrangThai = $tour->status_id;
    //     $newTrangThai = $request->input('status_id');

    //     // Kiểm tra điều kiện: chỉ cho phép chuyển status_id sang 6 nếu payment_status_id là 2
    //     if ($newTrangThai == 6 && $paymentStatusId != 2) {
    //         return redirect()->route('trangthaitour.index')
    //             ->with('error', 'Chỉ có thể chuyển trạng thái "Đã thanh toán" (ID: 6) khi trạng thái thanh toán (payment_status_id) là "Đã đặt cọc" (ID: 2).');
    //     }

    //     // Kiểm tra điều kiện: không cho phép chuyển ngược trạng thái
    //     if ($newTrangThai < $currentTrangThai) {
    //         return redirect()->route('trangthaitour.index')
    //             ->with('error', 'Không thể chuyển trạng thái ngược. Vui lòng chọn trạng thái hợp lệ.');
    //     }

    //     // Kiểm tra điều kiện: không cho phép chuyển status_id sang 13 nếu payment_status_id là 2
    //     if ($newTrangThai == 13 && $paymentStatusId == 2) {
    //         return redirect()->route('trangthaitour.index')
    //             ->with('error', 'Không thể chuyển trạng thái sang ID: 13 vì khách hàng đã thanh toán (payment_status_id là 2).');
    //     }

    //     // Gán trạng thái mới và lưu
    //     $tour->status_id = $newTrangThai;
    //     $tour->save();

    //     return redirect()->route('trangthaitour.index')
    //         ->with('success', 'Cập nhật trạng thái đơn hàng thành công');
    // }


    public function update(Request $request, $id)
    {
        try {
            $tour = Payment::findOrFail($id);

            $currentStatus = $tour->status_id;
            $newStatus = $request->input('status_id');
            $paymentStatusId = $tour->payment_status_id;

            // Trạng thái "hoàn thành" không được thay đổi
            if ($currentStatus == 13) {
                return response()->json(['success' => false, 'message' => 'Trạng thái đã hoàn thành không thể thay đổi nữa.']);
            }
            // Không được chuyển về trạng thái cũ
            if ($newStatus < $currentStatus) {
                return response()->json(['success' => false, 'message' => 'Không thể chuyển trạng thái cũ.']);
            }
            // Kiểm tra điều kiện: Nếu chuyển trạng thái sang hủy (status_id == 13) và đã thanh toán
            if ($newStatus == 13 && $paymentStatusId == 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể hủy tour do khách hàng đã thanh toán.'
                ]);
            }
            // if ($newStatus == 2 && $paymentStatusId != 2) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Khách chưa thanh toán.'
            //     ]);
            // }
            if ($newStatus == 5 && $paymentStatusId != 2) {
                return response()->json(['success' => false, 'message' => 'Khách hàng chưa thanh toán.']);
            }
            // Kiểm tra điều kiện: chỉ cho phép chuyển status_id sang 6 nếu payment_status_id là 2
            if ($newStatus == 6 && $paymentStatusId != 2) {
                return response()->json(['success' => false, 'message' => 'Khách hàng chưa thanh toán.']);
            }

            // Cập nhật trạng thái
            $tour->status_id = $newStatus;
            $tour->save();



            // Gửi thông báo nếu trạng thái là 6 hoặc 13
            if ($newStatus == 6 || $newStatus == 13) {
                $message = ($newStatus == 6) ? ' đã hoàn thành.' : ' đã bị hủy.';

                // Tạo thông báo trong bảng notifications
                $notification = Notification::create([
                    'title' => 'Thông báo trạng thái tour',
                    'content' => "Chuyến đi  {$tour->booking->tour->name}: $message",
                    'all_user' => 0,
                    'type' => 'tour_status',
                    'is_active' => 1,
                ]);

                // Gửi thông báo tới người dùng liên quan
                NotificationUser::create([
                    'notification_id' => $notification->id,
                    'user_id' => $tour->user_id,
                    'is_read' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $disabled = ($newStatus == 6 || $newStatus == 13) ? true : false;
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái tour thành công.',
                'disabled' => $disabled,
                'new_status' => $newStatus
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi cơ sở dữ liệu: ' . $ex->getMessage()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function ThanhToan(Request $request, string $id)
    {
        $tour = Payment::findOrFail($id);
        $currentStatus = $tour->status_id;
        $paymentStatusId = $request->input('payment_status_id');

        // Nếu trạng thái thanh toán đã được cập nhật trước đó
        if ($tour->payment_status_id == 3) {
            return response()->json([
                'success' => false,
                'message' => 'Trạng thái thanh toán đã được cập nhật, không thể thay đổi nữa.',
                'disabled' => true

            ]);
        }

        // Kiểm tra nếu yêu cầu hoàn tiền nhưng tour chưa được hủy
        if ($paymentStatusId == 3 && $currentStatus != 13) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể hoàn tiền vì tour chưa được hủy.'
            ]);
        }

        // Cập nhật trạng thái thanh toán
        $tour->payment_status_id = $paymentStatusId;
        $tour->save();

        // Nếu trạng thái thanh toán là "hoàn tiền" (payment_status_id == 3)
        if ($paymentStatusId == 3) {
            // Tạo thông báo trong bảng notifications
            $notification = Notification::create([
                'title' => 'Thông báo hoàn tiền',
                'content' => "Chuyến đi {$tour->booking->tour->name} đã được hoàn số tiền " . number_format($tour->refund_amount, 0, ',', '.') . "đ thành công.",
                'all_user' => 0,
                'type' => 'refund',
                'is_active' => 1,
            ]);

            // Gửi thông báo tới người dùng liên quan
            NotificationUser::create([
                'notification_id' => $notification->id,
                'user_id' => $tour->user_id,
                'is_read' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thanh toán thành công.',
            'disabled' => $tour->payment_status_id == 2 ? true : false,
            'new_status' => $tour->payment_status_id
        ]);
    }



    public function filter(Request $request)
    {
        // Log request parameters for debugging
        try {
            $status_id = $request->get('status_id');
            $search = $request->input('search');
            $payment_status_id = $request->get('payment_status_id');

            $query = Payment::query()->with(['booking.user', 'booking.tour', 'users']);

            // Search filter
            if ($search) {
                $query->where(function ($query) use ($search) {
                    // Tìm kiếm trong booking.user
                    $query->whereHas('booking.user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%')
                            ->orWhere('phone', 'like', '%' . $search . '%');
                    })
                        // Tìm kiếm trong booking.tour
                        ->orWhereHas('booking.tour', function ($q) use ($search) {
                            $q->where('name', 'like', '%' . $search . '%');
                        })
                        // Tìm kiếm trong bảng booking
                        ->orWhereHas('booking', function ($q) use ($search) {
                            $q->where('name', 'like', '%' . $search . '%');
                        })
                        // Tìm kiếm trong bảng users
                        ->orWhereHas('users', function ($q) use ($search) {
                            $q->where('name', 'like', '%' . $search . '%')
                                ->orWhere('phone', 'like', '%' . $search . '%');
                        });
                });
            }

            // Status filter
            if ($status_id !== null) {
                $query->where('payments.status_id', $status_id);
            }

            // Payment status filter
            if ($payment_status_id !== null) {
                $query->where('payments.payment_status_id', $payment_status_id);
            }

            // Get paginated results
            $listTour = $query->paginate(10);

            // Get possible statuses for filtering
            $trangThaiTour = Status::pluck('name', 'id')->toArray();
            $trangThaiThanhToan = PaymentStatus::pluck('name', 'id')->toArray();

            // Return rendered HTML as a response
            $html = view('admin.quanlytour.tour_list', compact('listTour', 'trangThaiThanhToan', 'trangThaiTour'))->render();

            return response()->json([
                'html' => $html,
            ]);
        } catch (\Exception $e) {
            Log::error('Filter error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Something went wrong!'
            ], 500);
        }
    }
}

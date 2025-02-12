<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admins\DonTour;
use App\Models\Admins\Tour;
use App\Models\Admins\User;
use App\Models\BookTour;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(['permission:view_dashboard'])->only(['index']);
    }
    public function index(Request $request)
    {

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        //tính tiền hôm nay so với hôm qua
        $revenueToday = Payment::whereDate('created_at', $today)->sum('money');
        $revenueYesterday = Payment::whereDate('created_at', $yesterday)->sum('money');
        $percentage = 0;
        if ($revenueYesterday > 0) {
            $percentage = (($revenueToday - $revenueYesterday) / $revenueYesterday) * 100;
        }
        // Lấy tổng số lượng đơn đặt tour hôm nay và ngày hôm qua
        $bookTourToday = Payment::whereDate('created_at', $today)->count();
        $bookTourYesterday = Payment::whereDate('created_at', $yesterday)->count();

        // Tính phần trăm thay đổi số lượng đơn đặt tour hôm nay so với ngày hôm qua
        $percentageChange = 0;
        if ($bookTourYesterday > 0) {
            $percentageChange = (($bookTourToday - $bookTourYesterday) / $bookTourYesterday) * 100;
        }
        //tỉnh tổng tiền các tour
        $totalMoneyhihi = Payment::where('status_id', 6)->where('payment_status_id', 2)->sum('money');
        $totalMoney = Payment::whereDate('created_at', $today)->where('status_id', 6)->where('payment_status_id', 2)->sum('money');
        //doanh thu tháng
        $totalMoneyMonth = Payment::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->where('status_id', 6)->where('payment_status_id', 2)->sum('money');

        //lượt truy cập web hôm nay so với hôm qua
        // $visitorCount = DB::table('view_web')->count();
        $todayVisitors = DB::table('view_web')
            ->whereDate('visited_at', Carbon::today())
            ->distinct('ip_address')
            ->count('ip_address');

        $yesterdayVisitors = DB::table('view_web')
            ->whereDate('visited_at', Carbon::yesterday())
            ->distinct('ip_address')
            ->count('ip_address');

        $percentageChangeViewWev = 0;
        if ($yesterdayVisitors > 0) {
            $percentageChangeViewWev = (($todayVisitors - $yesterdayVisitors) / $yesterdayVisitors) * 100;
        }



        //tính số lượng tour hôm nay
        $orderCountToday = Payment::whereDate('created_at', $today)
            ->where('status_id', '!=', 13)
            ->count();
        //đơn hàng tháng này
        $orderCountMonth = Payment::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->where('status_id', '!=', 13)->count();



        // Lấy top 5 tour được đặt nhiều nhất
        $top5Tours = Tour::withCount('bookTours')->orderBy('book_tours_count', 'desc')->take(5)->get();
        // Đếm số khách hàng đã đặt tour hôm nay
        $customerCount = Payment::whereDate('created_at', $today)->distinct('user_id')->count('user_id');
        // dd($totalMoney);chào

        // $averageRating = Review::where('tour_id', $id)->avg('rating');

        // Lấy top 5 tour được đặt nhiều nhất
        // $topBookedTours = BookTour::selectRaw('tour_id, COUNT(*) as total_bookings')
        //     ->groupBy('tour_id')
        //     ->orderBy('total_bookings', 'desc')
        //     ->with('tour')
        //     ->get();

        // $chartData = $topBookedTours->map(function ($item) {
        //     return [
        //         'label' => trim($item->tour->name ?? 'Không xác định'), //tours
        //         'y' => $item->total_bookings, // đặt
        //     ];
        // });

        // thống kê trạng thái tour
        // $statuses = BookTour::select('status', \DB::raw('COUNT(*) as count'))
        // ->groupBy('status')
        // ->get();
        // $total = $statuses->sum('count');
        // $chartData = $statuses->map(function ($item) use ($total) {
        //     return [
        //         'y' => round(($item->count / $total) * 100, 2),
        //         'label' => $this->getStatusName($item->status),
        //     ];
        // });


        // Truy vấn tổng tiền đã chi tiêu của mỗi người dùng
        $topUsers = User::select('users.id', 'users.name', DB::raw('SUM(book_tour.total_money) as total_spent'))
            ->join('book_tour', 'users.id', '=', 'book_tour.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();
        $dataPoints = [];
        foreach ($topUsers as $user) {
            $dataPoints[] = ["label" => $user->name, "y" => (float) $user->total_spent];
        }


        // thông kê số lượng đặt tour ngày

        // Tính tỷ lệ hủy đơn hàng
        $totalPayments = Payment::count();
        $statuses = Status::withCount('payments')->get();
        $tyLe = $statuses->map(function ($status) use ($totalPayments) {
            return [
                'name' => $status->name,
                'count' => $status->payments_count,
                'percentage' => $totalPayments > 0 ? round(($status->payments_count / $totalPayments) * 100, 2) : 0,
            ];
        });


        //lấy ra lượt view các tour
        // $tourReview = Tour::with('reviews','reviews.user')->get();
        $tourReview = Tour::with(['reviews', 'reviews.user'])
            ->withCount(['bookTours as total_bookings' => function ($query) {
                $query->whereNull('ly_do_huy');
            }])
            ->addSelect(['total_revenue' => BookTour::selectRaw('SUM(total_money)')
                ->whereColumn('book_tour.tour_id', 'tours.id')
                ->whereNull('ly_do_huy')])
            ->paginate(10); // Phân trang

        // Lấy những người chi tiêu nhiều nhất
        $topSpendingUsers = Payment::select('user_id', DB::raw('SUM(money) as total_spent'))
            ->groupBy('user_id')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        $userNames = [];
        $totalSpent = [];

        foreach ($topSpendingUsers as $payment) {
            $user = User::find($payment->user_id);
            $userNames[] = $user ? $user->name : 'Khách chưa đăng ký';
            $totalSpent[] = $payment->total_spent;
        }
        // dd($tourReview);
        // Lấy 10 tour được đặt nhiều nhất trong khoảng thời gian

        // $top5Tours = Tour::withCount('bookTours')
        //     ->orderBy('book_tours_count', 'desc')
        //     ->take(5)
        //     ->get();

        // $chartData = $top5Tours->map(function ($tour) {
        //     return [
        //         'label' => $tour->name,
        //         'y' => $tour->book_tours_count,
        //     ];
        // });

        //lấy các đơn hàng ngày hôm nay
        $paymentsOrderToday = Payment::whereDate('created_at', $today)
            ->with('booking', 'bookTours', 'user', 'paymentMethod', 'paymentStatus')
            ->where('status_id', '!=', 13)
            ->paginate(10);

        $data = [
            'title' => 'Dashboard',
            'totalMoney'                            => $totalMoney,
            'totalMoneyhihi'                            => $totalMoneyhihi,
            'totalMoneyMonth'                       => $totalMoneyMonth,

            'orderCountToday'                       => $orderCountToday,
            'orderCountMonth'                       => $orderCountMonth,

            'top5Tours'                             => $top5Tours,
            'customerCount'                         => $customerCount,
            'percentage'                            => $percentage,
            'percentageChange'                      => $percentageChange,
            // 'chartData'                             => $chartData,
            'dataPoints'                            => $dataPoints,
            'tyLe'                                  => $tyLe,
            'tourReview'                            => $tourReview,
            'todayVisitors'                         => $todayVisitors,
            'yesterdayVisitors'                     => $yesterdayVisitors,
            'percentageChangeViewWev'               => round($percentageChangeViewWev, 2),
            'userNames'                             => $userNames,
            'totalSpent'                            => $totalSpent,
            'top5Tours'                             => $top5Tours,
            'paymentsOrderToday'                    => $paymentsOrderToday,
        ];

        // dd($totalMoney); 

        // dd($tourReview);
        return view('admin.dashboard', $data);
    }
    protected function getStatusName($statusId)
    {
        $statusNames = [
            1 => 'Chờ xác nhận',
            2 => 'Đã xác nhận',
            5 => 'Chưa hoàn thành',
            6 => 'Đã hoàn thành',
            13 => 'Đã hủy',
        ];

        return $statusNames[$statusId] ?? 'Không xác định';
    }

    public function filterByDate(Request $request)
    {
        $data = $request->all();
        $from_date = $data['from_date'] ?? Carbon::today()->subDays(7)->toDateString();
        $to_date = $data['to_date'] ?? Carbon::today()->toDateString();

        $chartData = DonTour::select(
            DB::raw('DATE(created_at) as created_at'),
            DB::raw('SUM(total_money) as money'),
            DB::raw('COUNT(id) as soLuongDon'),
            'tour_id'
        )
            ->whereBetween('created_at', [$from_date, $to_date])
            ->with('tour:name,id')
            ->groupBy(DB::raw('DATE(created_at)'), 'tour_id')
            ->orderBy('created_at', 'ASC')
            ->get();

        $formattedData = $chartData->map(function ($value) {
            return [
                'tour_name' => $value->tour->name ?? 'Chưa xác định',
                'soLuongDon' => $value->soLuongDon,
                'money' => $value->money,
                'date' => $value->created_at,
            ];
        });

        return response()->json($formattedData);
    }
    public function filterByBtn(Request $request)
    {
        $data = $request->all();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dauthangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoithangtrc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $sub365day = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();

        if ($data['dashboard_value'] == '7day') {
            $from_date = $sub7days;
            $to_date = $now;
        } elseif ($data['dashboard_value'] == 'thangTrc') {
            $from_date = $dauthangtruoc;
            $to_date = $cuoithangtrc;
        } elseif ($data['dashboard_value'] == 'thangNay') {
            $from_date = $dauthangnay;
            $to_date = $now;
        } else {
            $from_date = $sub365day;
            $to_date = $now;
        }

        $chart_data = Payment::select(
            DB::raw('DATE(created_at) as ngayDat'),
            DB::raw('SUM(money) as total'),
            DB::raw('COUNT(id) as soLuongDon')
        )
            ->whereBetween('created_at', [$from_date, $to_date])
            ->groupBy('ngayDat')
            ->orderBy('ngayDat', 'ASC')
            ->get();

        return response()->json($chart_data);
    }
    //     public function getDashboardData(Request $request)
    // {
    //     $year = $request->get('year', now()->year);

    //     $monthlyRevenue = Payment::selectRaw('MONTH(created_at) as month, SUM(money) as total')
    //         ->whereYear('created_at', $year)
    //         ->where('status_id', '=', 6)
    //         ->groupByRaw('MONTH(created_at)')
    //         ->orderBy('month')
    //         ->pluck('total', 'month');

    //     $dataChart = [];
    //     for ($i = 1; $i <= 12; $i++) {
    //         $dataChart[] = $monthlyRevenue->get($i, 0);
    //     }

    //     return response()->json(['dataChart' => $dataChart]);
    // }
    public function getDashboardData(Request $request)
    {
        $year = $request->get('year', 2024); // Lấy năm từ request, mặc định là 2024

        $dataChart = Payment::whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, SUM(money) as total')
            ->where('status_id', '=', 6)
            ->where('payment_status_id', '=', 2)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Chuyển dữ liệu sang dạng đầy đủ 12 tháng
        $formattedData = [];
        for ($i = 1; $i <= 12; $i++) {
            $formattedData[] = $dataChart[$i] ?? 0;
        }

        return response()->json(['dataChart' => $formattedData]);
    }

    public function filterDateTotal(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $totalMoneyMonth = Payment::whereBetween('created_at', [$fromDate, $toDate])
            ->where('status_id', 6)
            ->where('payment_status_id', 2)
            ->sum('money');

        $totalMoney = Payment::whereDate('created_at', $toDate)
            ->where('status_id', 6)
            ->where('payment_status_id', 2)
            ->sum('money');

        $orderCountMonth = Payment::whereBetween('created_at', [$fromDate, $toDate])
            ->where('status_id', '!=', 13)
            ->count();

        $orderCountToday = Payment::whereDate('created_at', $toDate)
            ->where('status_id', '!=', 13)
            ->count();

        $todayVisitors = DB::table('view_web')->whereBetween('created_at', [$fromDate, $toDate])->distinct('ip_address')->count();

        // $todayVisitors = DB::table('view_web')
        // ->whereDate('visited_at', Carbon::today())
        // ->distinct('ip_address')
        // ->count('ip_address');

        $customerCount = Payment::whereDate('created_at', $toDate)
            ->distinct('user_id')->count('user_id');

        return response()->json([
            'totalMoneyMonth' => number_format($totalMoneyMonth, 0, ',', '.') . ' đ',
            'totalMoney' => number_format($totalMoney, 0, ',', '.') . ' đ',
            'orderCountMonth' => $orderCountMonth,
            'orderCountToday' => $orderCountToday,
            'todayVisitors' => $todayVisitors,
            'customerCount' => $customerCount,
        ]);
    }
}

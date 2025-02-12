<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponsClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::where('status', 1)->whereDate('start_date', '>=', Carbon::now())->whereDate('end_date', '>=', Carbon::now())->orderBy('created_at', 'desc')->with('tour')->get();
        $coupons->each(function ($coupon) {
            $endDate = Carbon::parse($coupon->end_date);
            $coupon->days_remaining = $endDate->diffInDays(Carbon::now());
        });
        return view('client.coupons.index', compact('coupons'));
    }
}

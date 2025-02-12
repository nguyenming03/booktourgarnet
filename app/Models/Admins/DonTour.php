<?php

namespace App\Models\Admins;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonTour extends Model
{
    use HasFactory;
    protected $table = 'book_tour';
    const TRANG_THAI_TOUR = [
        'cho_xac_nhan' => 'Chờ xác nhận',
        'da_xac_nhan' => 'Đã xác nhận',
        'da_hoan_thanh' => 'Đã hoàn Thành',
        'huy_tour' => 'Tour đã hủy'
    ];
    const TRANG_THAI_THANH_TOAN = [
        'chua_thanh_toan' => 'Chưa thanh toán',
        'da_thanh_toan' => 'Đã thanh toán',
        
    ];

    const CHO_XAC_NHAN = 'cho_xac_nhan';
const DA_XAC_NHAN = 'da_xac_nhan';
const DA_HOAN_THANH = 'da_hoan_thanh';
const HUY_TOUR = 'huy_tour';
const CHUA_THANH_TOAN = 'chua_thanh_toan';
const DA_THANH_TOAN = 'da_thanh_toan';
protected $fillable = [
    'user_id ',
    'tour_id',
    'guide_id ',
    'name',
    'email',
    'phone',
    'sale',
    'address',
    'date_booking',
    'start_date',
    'note',
    'number_old',
    'number_children',
    'total_money',
    'paymentstatus',
    'status',
    'ly_do_huy',
    'sale',
];

public function user(){
    return $this->belongsTo(User::class);
}
public function tour(){
    return $this->belongsTo(Tour::class);
}
public function pay(){
    return $this->hasMany(Payment::class);
}
}

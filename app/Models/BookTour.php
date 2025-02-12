<?php

namespace App\Models;

use App\Models\Admins\Customer;
use App\Models\Admins\Tour;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTour extends Model
{
    use HasFactory;
    protected $table = 'book_tour';

    // Các trường có thể mass-assignable (dùng trong phương thức create hoặc update)
    protected $fillable = [
        'user_id',
        'tour_id',
        'name',
        'email',
        'phone',
        'address',
        'date_booking',
        'start_date',
        'end_date',
        'note',
        'number_old',
        'number_children',
        'total_money',
        'status',
        'ly_do_huy',
        'account_name',
        'account_number',
        'bank',
        'sale',
        'qr_code',
        'pay_id',
        'customer_id',
    ];

    // Nếu sử dụng Carbon để làm việc với ngày tháng
    protected $dates = [
        'date_booking',
        'start_date',
    ];

    // Các quan hệ với các model khác, ví dụ: user, tour, guide
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function custom()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }
    // app/Models/BookTour.php
    public function pay()
    {
        return $this->belongsTo(Payment::class, 'pay_id');
    }

    // public function guide()
    // {
    //     return $this->belongsTo(Guide::class);
    // }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status', 'id');
    }

    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';

    // Cột nào được phép gán giá trị (mass assignment)
    protected $fillable = [
        'booking_id',
        'user_id',
        'money',
        'coupon_id',
        'p_note',
        'vnp_response_code',
        'transaction',
        'code_vnpay',
        'code_bank',
        'time',
        'status_id',
        'cancel_proof_image',
        'confirmation_code',
        'payment_method_id',
        'customer_id',
        'pay_id',
        'payment_status_id',
    ];

    // Quan hệ với bảng book_tour (một payment thuộc một booking)
    // public function booking()
    // {
    //     return $this->belongsTo(BookTour::class, 'booking_id');
    // }

    // Quan hệ với bảng users (một payment thuộc một người dùng)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }
    // app/Models/Pay.php
    public function bookTours()
    {
        return $this->hasMany(BookTour::class, 'pay_id');
    }

    // In Payment.php model
    public function book_tour()
    {
        return $this->hasOne(BookTour::class);
    }
    public function booking()
    {
        return $this->belongsTo(BookTour::class);
    }
    
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id'); // Điều chỉnh theo schema
    }
    
    // In BookTour.php model (if users relation exists)

    public function bookTour()
{
    return $this->belongsTo(BookTour::class, 'booking_id'); // Đặt đúng tên cột foreign key
}


}

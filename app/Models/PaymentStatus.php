<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    use HasFactory;

    protected $table = 'payment_statuses';

    // Quan hệ với bảng Payments
    public function payments()
    {
        return $this->hasMany(Payment::class, 'payment_status_id');
    }
}

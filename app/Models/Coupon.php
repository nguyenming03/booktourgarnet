<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'tour_id',
        'name',
        'code',
        'start_date',
        'end_date',
        'percentage_price',
        'number',

        'start_date',
        'end_date',
        'type',
        'status'
    ];

    // Quan hệ với Category
    public function tour()
    {
        // Cập nhật lại đúng tên cột khóa ngoại 'category_tour_id'
        return $this->belongsTo(Tour::class, 'tour_id');
    }
}

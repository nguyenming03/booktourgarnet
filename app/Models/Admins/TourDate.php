<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourDate extends Model
{
    use HasFactory;
    // Tên bảng
    protected $table = 'tour_dates';
    // Các trường có thể được gán giá trị
    protected $fillable = [
        'tour_id',  // ID của tour
        'tour_date' // Ngày của tour
    ];
    /**
     * Quan hệ với model Tour
     * Một ngày thuộc về một tour
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }
}

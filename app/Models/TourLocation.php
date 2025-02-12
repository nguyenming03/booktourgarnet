<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourLocation extends Model
{
    use HasFactory;
    // Tên bảng (nếu không theo mặc định bảng tên sẽ là tour_locations)
    protected $table = 'tour_locations';

    // Các trường có thể được gán giá trị mass assignable
    protected $fillable = [
        'tour_id',       // ID của tour
        'location_id',   // ID của địa điểm
        'is_start',      // Có phải là điểm bắt đầu không
        'is_end',        // Có phải là điểm kết thúc không
        'status',        // Có phải là điểm kết thúc không
    ];

    // Quan hệ với bảng `tour` (một tour có nhiều địa điểm)
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    // Quan hệ với bảng `location_update` (một địa điểm có nhiều mối quan hệ với tour)
    public function location()
    {

        return $this->belongsTo(LocationUpdate::class);
    }
}

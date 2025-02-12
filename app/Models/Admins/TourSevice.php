<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourSevice extends Model
{
    use HasFactory;
    protected $table = 'tour_sevice';  // Tên bảng thực sự trong cơ sở dữ liệu
    protected $fillable = [
        'tour_id',
        'category_service_id',
        'service_id',
        'created_at',
         'updated_at'
        
    ];
    
}

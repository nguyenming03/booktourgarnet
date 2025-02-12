<?php

namespace App\Models\Admins;

use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'locations';  // Tên bảng thực sự trong cơ sở dữ liệu
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'content',
        'status',
        'tour_id',
        'user_id',
    ];
    // Định nghĩa quan hệ Location có nhiều Tours
    public function tours()
    {
        return $this->hasMany(Tour::class,'location_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}

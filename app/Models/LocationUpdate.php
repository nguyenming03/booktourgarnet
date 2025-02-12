<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationUpdate extends Model
{
    use HasFactory;
    // Tên bảng (nếu không theo mặc định bảng tên sẽ là locations_updates)
    protected $table = 'locations_update';

    // Các trường có thể được gán giá trị mass assignable
    protected $fillable = [
        'name',  // Tên của địa điểm
    ];

    // Quan hệ với bảng `tour_locations`
    public function tourLocations()
    {
        return $this->hasMany(TourLocation::class);
    }
}

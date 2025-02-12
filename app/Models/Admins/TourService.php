<?php

namespace App\Models\Admins;

use App\Models\Review;
use App\Models\Comment;
use App\Models\BookTour;
use App\Models\Favorite;
use App\Models\TourLocation;
use GuzzleHttp\Psr7\Request;
use App\Models\LocationUpdate;
use App\Models\Admins\TourDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TourService extends Model
{
    use HasFactory;
    protected $table = 'tour_service';
    protected $fillable = [
        'tour_id',
        'category_service_id',
        'service_id',
    ];

    public function categoryService()
    {
        return $this->belongsTo(CategoryServiceModel::class, 'category_service_id');
    }
}

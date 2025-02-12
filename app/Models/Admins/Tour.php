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

class Tour extends Model
{
    use HasFactory;
    protected $table = 'tours';  // Tên bảng thực sự trong cơ sở dữ liệu
    protected $fillable = [
        'name',
        'title',
        'journeys',
        'schedule',
        'move_method',
        'starting_gate',
        'start_date',
        'time',
        'end_date',
        'number_guests',
        'price_old',
        'price_children',
        'number_registered',
        'sale',
        'number',
        'view',
        'description',
        'content',
        'image',
        'location_id',
        'user_id',
        'album_img',
        'status',
        'category_tour_id',
    ];
    use SoftDeletes;
    protected $casts = [
        'status' => 'boolean',
    ];

    public static function getAll()
    {
        return self::all();
    }

    // Định nghĩa quan hệ Tour thuộc về User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function imagetour()
    {
        return $this->hasMany(ImageTour::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'tour_id');  // 'tour_id' là khóa ngoại trong bảng comments
    }
    // Định nghĩa quan hệ Tour thuộc về Location
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function guides()

    {
        return $this->hasMany(Coupons::class, 'tour_id');
    }
    public function category_tour()
    {
        return $this->belongsTo(CategoryTour::class, 'tour_id');
    }


    public function scopeSearch($query, $searchTerm)
    {

        return $query->where('name', 'like', '%' . $searchTerm . '%');
        // ->orWhere('title', 'like', '%' . $searchTerm . '%')  
        // ->orWhere('description', 'like', '%' . $searchTerm . '%')
        // ->orWhere('content', 'like', '%' . $searchTerm . '%')
        // ->orWhere('journeys', 'like', '%' . $searchTerm . '%')
        // ->orWhere('schedule', 'like', '%' . $searchTerm . '%')
        // ->orWhere('move_method', 'like', '%' . $searchTerm . '%')
        // ->orWhere('starting_gate', 'like', '%' . $searchTerm . '%')
        // ->orWhere('start_date', 'like', '%' . $searchTerm . '%')
        // ->orWhere('end_date', 'like', '%' . $searchTerm . '%')
        // ->orWhere('price_old', 'like', '%' . $searchTerm . '%')
        // ->orWhere('price_children', 'like', '%' . $searchTerm . '%')
        // ->orWhere('sale', 'like', '%' . $searchTerm . '%');



    }

    public function images()
    {
        return $this->hasMany(ImageTour::class, 'tour_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    public function bookTours()
    {
        return $this->hasMany(BookTour::class, 'tour_id');
    }
    public function reviews()
    {

        // return $this->hasMany(Review::class, 'tour_id');


        return $this->hasMany(Review::class);
    }
    public function tourDates()
    {
        return $this->hasMany(TourDate::class, 'tour_id');
    }
    public function tourLocations()
    {
        return $this->hasMany(TourLocation::class);
    }
    public function locations()
    {
        return $this->belongsToMany(LocationUpdate::class, 'tour_locations')
            ->withPivot('is_start', 'is_end'); // Các trường phụ trong bảng `tour_locations`
    }

    public function categoryServices()
    {
        return $this->belongsToMany(CategoryServiceModel::class, 'tour_service', 'tour_id', 'category_service_id');
    }


    public function services()
    {
        return $this->belongsToMany(ServiceModel::class, 'tour_service', 'tour_id', 'service_id');
    }
}

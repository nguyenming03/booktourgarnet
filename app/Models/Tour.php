<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $table = 'tours';
    protected $fillable = [
        'name',
        'journeys',
        'schedule',
        'tourDays',
        'move_method',
        'starting_gate',
        'start_date',
        'end_date',
        'number',
        'number_guests',
        'price_old',
        'price_children',
        'sale',
        'view',
        'description',
        'content',
        'image',
        'location_id',
        'user_id',
        'category_tour_id',
        'number_registered',
        'star',
        'status'
    ];

    // Quan hệ với Category
    public function category()
    {
        // Cập nhật lại đúng tên cột khóa ngoại 'category_tour_id'
        return $this->belongsTo(Category::class, 'category_tour_id');
    }
}

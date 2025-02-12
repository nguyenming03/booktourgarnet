<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category_tour';
    protected $fillable = [
        'category_tour',
        'description',
        'slug',
        'status',
        'responsibility',
    ];



    // Quan hệ với các tour
    public function tours()
    {
        // Quan hệ với tours, không cần chỉ định cột khóa ngoại vì mặc định Laravel sẽ sử dụng 'category_id'
        return $this->hasMany(Tour::class, 'category_tour_id');
    }
}

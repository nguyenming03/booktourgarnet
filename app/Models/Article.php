<?php

namespace App\Models;

use App\Models\Admins\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'articles';

    protected $fillable = [
        'title',
        'slug',
        'show_home',
        'active',
        'view',
        'description',
        'avatar',
        'content',
        'category_id',
        'user_id',
        'status',
    ];

    // Thiết lập mối quan hệ với model Category
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    // Thiết lập mối quan hệ với model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

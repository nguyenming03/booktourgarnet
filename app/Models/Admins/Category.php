<?php

namespace App\Models\Admins;

use App\Models\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';  // Tên bảng thực sự trong cơ sở dữ liệu
    protected $fillable = [
        'name',
        'parent_id',
        'slug',
        'img_thumb',
        'description',
        'hot',
        'user_id',
        'status',
    ];
    public function status()
 {
     return $this->belongsTo(Status::class);
 }
 public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function parent()
{
    return $this->belongsTo(Category::class, 'parent_id');
}
public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}

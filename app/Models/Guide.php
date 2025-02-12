<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'address',
        'experience',
        'skills',
        'status'
    ];

    public function tours()
    {
        return $this->hasMany(BookTour::class, 'guide_id');
    }
    // Quan hệ với bảng users
    public function user()
    {
        return $this->hasOne(User::class);  // Một hướng dẫn viên có thể có một tài khoản người dùng
    }
}

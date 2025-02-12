<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    /**
     * Tên bảng trong database (nếu không dùng mặc định).
     */
    protected $table = 'reviews';

    /**
     * Các thuộc tính có thể gán hàng loạt.
     */
    protected $fillable = [
        'user_id',
        'tour_id',
        'rating',
    ];

    /**
     * Định nghĩa quan hệ với User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Định nghĩa quan hệ với Tour.
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}

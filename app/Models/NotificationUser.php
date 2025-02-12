<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationUser extends Model
{
    use HasFactory;

    protected $table = 'notification_user';
    protected $fillable = ['notification_id', 'user_id', 'is_read','read_at'];

    // Mối quan hệ với bảng Notification
    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }

    // Mối quan hệ với bảng User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}

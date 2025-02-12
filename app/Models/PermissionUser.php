<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionUser extends Model
{
    use HasFactory;
    protected $table = 'user_permission';

    protected $fillable = [
        'user_id',
        'permission_id',
    ];

   // Quan hệ với model Permission
   public function permission()
   {
       return $this->belongsTo(Permission::class, 'permission_id');
   }

   // Quan hệ với model User
   public function user()
   {
       return $this->belongsTo(User::class, 'user_id');
   }

    
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'avatar',
        'birth',
        'gender',
        'password',
        'status',
        'remember_token',
        'temporary_user_id',
        'role_id',
        'guide_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Mối quan hệ với Notification thông qua bảng trung gian notification_user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_user')
            ->withPivot('is_read', 'created_at')
            ->withTimestamps();
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    public function bookTours()
    {
        return $this->hasMany(BookTour::class, 'user_id');
    }


    // Khai báo mối quan hệ với Permission
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission', 'user_id', 'permission_id');
    }

    public function hasPermission($permissionName)
    {
        return $this->permissions()->where('name', $permissionName)->exists();
    }

    // gán và thu hồi quyền
    public function assignPermission($permissionId)
    {
        $this->permissions()->attach($permissionId);
    }

    public function revokePermission($permissionId)
    {
        $this->permissions()->detach($permissionId);
    }

    public function permissionUsers()
    {
        return $this->hasMany(PermissionUser::class);
    }

    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }
}

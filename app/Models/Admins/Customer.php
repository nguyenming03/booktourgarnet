<?php

namespace App\Models\Admins;

use App\Models\BookTour;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'temporary_user_id',
        'type', // 'registered' or 'anonymous'
    ];
    public function bookTours()
    {
        return $this->hasMany(BookTour::class, 'customer_id');
    }
}

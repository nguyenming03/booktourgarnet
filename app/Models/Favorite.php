<?php

namespace App\Models;

use App\Models\Admins\Tour;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';

    protected $fillable = [
        'user_id',
        'tour_id',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

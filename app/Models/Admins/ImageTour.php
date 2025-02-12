<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageTour extends Model
{
    use HasFactory;
    protected $table = 'images';
    protected $fillable = [
        'tour_id',
        'image',

    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'album_img');
    }
}

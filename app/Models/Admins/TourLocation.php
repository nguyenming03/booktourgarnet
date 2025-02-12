<?php

namespace App\Models\Admins;


use Illuminate\Database\Eloquent\Model;

class TourLocation extends Model
{
    protected $fillable = [
        'tour_id',
        'start',
        'end',
        'description',
    ];

    // Mối quan hệ với bảng tours
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}

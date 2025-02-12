<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancellationHistory extends Model
{
    use HasFactory;
    protected $table = 'cancellation_histories';

    protected $fillable = [
        'booking_id',
        'status',
        'reason',
        'admin_comment',
        'proof_image',
        'proof_code',
        'requested_at',
        'processed_by',
        'processed_at',
    ];
    public function booking()
    {
        return $this->belongsTo(BookTour::class, 'booking_id');
    }
}

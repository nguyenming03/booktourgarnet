<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupons extends Model
{
    use HasFactory;
    protected $table = 'coupons';  // Tên bảng thực sự trong cơ sở dữ liệu
    protected $fillable = [
        'name',
        'tour_id',
        'code',
        'start_date',
        'end_date',
        'percentage_price',
        'number',
        'type',
        'status',
    ];
    use SoftDeletes;
    protected $cats = [
        'status' => 'boolean',
    ];
    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

}

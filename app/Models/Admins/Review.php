<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Review extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'reviews';
    protected $fillable = [
        'user_id',
        'tour_id',
        'rating',
    ];
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
    static public function getAll()
    {
        $return = self::select(
            'review.*',
            'users.name as user_name',
            'tours.name as tour_name'
        )
            ->join('users', 'users.id', 'review.user_id')
            ->join('tours', 'tours.id', 'review.tour_id')
            ->where('review.deleted_at', '=', null);

        if (!empty(request()->get('search'))) {
            $search = request()->get('search');
            $return = $return->where(function ($query) use ($search) {
                $query->Where('users.name', 'like', '%' . $search . '%')
                    ->orWhere('tours.name', 'like', '%' . $search . '%');
            });
        }

        $return = $return   ->orderBy('id', 'desc')
            ->paginate(10);

        return $return;
    }
}


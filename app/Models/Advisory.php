<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advisory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'advisories';
    protected $fillable = ['tour_id', 'name', 'email', 'phone_number', 'content'];

    static public function getAll()
    {
        $return =  self::select('advisories.*', 'tours.name as tour_name')
            ->join('tours',  'tours.id', 'advisories.tour_id')
            ->where('advisories.deleted_at', '=', null);

        if ($status = request()->get('status')) {
            $return = $return->where('advisories.status', '=', $status);
        }

        if (!empty(request()->get('search'))) {
            $search = request()->get('search');
            $return = $return->where(function ($query) use ($search) {
                $query->where('advisories.id', '=', $search)
                    ->orWhere('advisories.name', 'like', '%' . $search . '%')
                    ->orWhere('advisories.email', 'like', '%' . $search . '%')
                    ->orWhere('advisories.phone_number', 'like', '%' . $search . '%')
                    ->orWhere('advisories.tour_id', '=', $search)
                    ->orWhere('tours.name', 'like', '%' . $search . '%');
            });
        }
        $return = $return->orderBy('advisories.id', 'desc')
            ->paginate(10);

        return $return;
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}

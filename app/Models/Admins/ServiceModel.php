<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceModel extends Model
{
    use HasFactory;
    protected $table = 'services';

    protected $fillable = [
        'name',
        'price',
        'description',
        'status',
    ];

    static public function getAll($status = null, $searchQuery = null)
    {
        $query = self::select('services.*', 'category_services.category_name as category_name')
            ->join('category_services', 'category_services.id', '=', 'services.category_service_id')
            ->where('category_services.status', '=', 1);

        if ($status !== null) {
            $query->where('services.status', $status);
        }

        if ($searchQuery !== null && $searchQuery !== '') {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('services.name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('services.price', 'like', '%' . $searchQuery . '%')
                    ->orWhere('services.description', 'like', '%' . $searchQuery . '%')
                    ->orWhere('category_services.category_name', 'like', '%' . $searchQuery . '%');
            });
        }
        return $query
            ->orderBy('services.id', 'desc')
            ->paginate(10);
    }


    static public function getSingle($id)
    {
        return self::find($id);
    }

    public function categoryServices()
    {
        return $this->belongsToMany(CategoryServiceModel::class, 'tour_service', 'service_id', 'category_service_id');
    }

    public function categoryService()
    {
        return $this->belongsTo(CategoryServiceModel::class, 'category_service_id');
    }
}

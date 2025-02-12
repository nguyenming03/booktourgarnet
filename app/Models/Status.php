<?php

namespace App\Models;

use App\Models\Admins\Location;
use App\Models\Admins\UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = 'statuses';

    
    protected $fillable = ['name'];

   
    public function payments()
    {
        return $this->hasMany(Payment::class, 'status_id');
    }
}

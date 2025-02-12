<?php

namespace App\Models;

use App\Models\Admins\Tour;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'comment';
    protected $fillable = ['tour_id', 'user_id', 'parent_id', 'anonymous_name', 'content'];
    use SoftDeletes;  // Thêm trait SoftDeletes
    // Quan hệ đến bình luận cha
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Quan hệ đến các bình luận con
    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Quan hệ đến bài viết
    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    // Quan hệ đến người dùng
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }
    static public function getAll()
    {
        $return = self::select(
            'comment.*',
            'users.name as user_name',
            'tours.name as tour_name'
        )
            ->join('users', 'users.id', 'comment.user_id')
            ->join('tours', 'tours.id', 'comment.tour_id')
            ->where('comment.deleted_at', '=', null);

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

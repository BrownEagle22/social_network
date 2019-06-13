<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    protected $table = 'comments';
    protected $guarded = [];
    protected $fillable = ['text'];

    public function post() {
        return $this->belongsTo('App\Post');
    }

    public function user() {
        return $this->belongsTo('App\User', 'owner_id');
    }

    public function likes() {
        return $this->hasMany('App\CommentLike');
    }

    public function addLikeData()
    {
        $this['like_count'] = $this->likes()
            ->where('is_positive', '=', 1)
            ->get()->count();
            
        $this['dislike_count'] = $this->likes()
            ->where('is_positive', '=', 0)
            ->get()->count();

        $commentLike = null;
        if (Auth::check())
        {
            $commentLike = $this->likes()
                ->where('user_id', '=', Auth::user()['id'])
                ->first();            
        }

        $this['user_liked'] = $this['user_disliked'] = false;
        if ($commentLike)
        {
            if ($commentLike['is_positive'])
                $this['user_liked'] = true;
            else
                $this['user_disliked'] = true;
        }
    }
}

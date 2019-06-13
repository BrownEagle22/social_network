<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $table = 'posts';
    protected $guarded = [];
    protected $fillable = ['title', 'description', 'picture_path', 'privacy_type_id', 'deleter_id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'owner_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function likes()
    {
        return $this->hasMany('App\PostLike');
    }

    public function addLikeData()
    {
        $this['like_count'] = $this->likes()
            ->where('is_positive', '=', 1)
            ->get()->count();
            
        $this['dislike_count'] = $this->likes()
            ->where('is_positive', '=', 0)
            ->get()->count();

        $postLike = null;
        if (Auth::check())
        {
            $postLike = $this->likes()
                ->where('user_id', '=', Auth::user()['id'])
                ->first();            
        }

        $this['user_liked'] = $this['user_disliked'] = false;
        if ($postLike)
        {
            if ($postLike['is_positive'])
                $this['user_liked'] = true;
            else
                $this['user_disliked'] = true;
        }
    }

    public function addCommentCount() {
        $this['comment_count'] = $this->comments()
        ->where('deleter_id', null)
        ->get()->count();
    }
}

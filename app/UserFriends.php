<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFriends extends Model
{
    protected $table = 'user_friends';
    protected $guarded = [];

    public function friend() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function friendWith() {
        return $this->belongsTo('App\User', 'user_friend_id');
    }
}

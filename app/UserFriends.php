<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFriends extends Model
{
    protected $table = 'user_friends';
    protected $guarded = [];
    protected $fillable = ['user_id', 'user_friend_id', 'is_accepted'];

    public function friend() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function friendWith() {
        return $this->belongsTo('App\User', 'user_friend_id');
    }
}

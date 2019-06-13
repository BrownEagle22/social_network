<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'surname', 'picture_path', 'date_born',
        'description', 'online_till', 'role', 'privacy_type_id', 'deleter_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function activities() {
        return $this->hasMany('App\Activity');
    }

    public function posts() {
        return $this->hasMany('App\Post', 'owner_id');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    /*public function friends() {
        $friendIds = [];
        foreach (UserFriends::all() as $userFriend)
        {
            if ($userFriend['user_id'] === Auth::user()['id'])
                $friendIds[] = $userFriend['user_friend_id'];
            else if ($userFriend['user_friend_id'] === Auth::user()['id'])
                $friendIds[] = $userFriend['user_id'];
        }

        return User::where('deleter_id', '=', null)
            ->whereIn('id', $friendIds);
    }*/

    public function friends() {
        return $this->belongsToMany('App\User', 'user_friends', 'user_id', 'user_friend_id');
    }

    public function friendsReverse() {
        return $this->belongsToMany('App\User', 'user_friends', 'user_friend_id', 'user_id');
    }

    public function messagesReceived() {
        return $this->belongsToMany('App\Message', 'user_messages');
    }

    public function messagesSent() {
        return $this->hasMany('App\Message', 'user_from_id');
    }

    public function isModerator() {
        return ($this->role === 2);
    }

    public function isAdmin() {
        return ($this->role === 3);
    }
}

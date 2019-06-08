<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $guarded = [];

    public function sender() {
        return $this->belongsTo('App\User', 'user_from_id');
    }

    public function receivers() {
        return $this->belongsToMany('App\User', 'user_messages');
    }

    public function isDeleted($userId) {
        return MessageDeletion::where('user_id', '=', $userId)
            ->where('message_id', '=', $this->id)->get()->count() === 0;
    }
}

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
        $userMessage = UserMessage::where('user_id', '=', $userId)
            ->where('message_id', '=', $this->id)->get();

        if ($userMessage->count() === 0)
            return true;
        else
            return $userMessage->first()->is_deleted;
    }

    public function isRead($userId) {
        $userMessage = UserMessage::where('user_id', '=', $userId)
            ->where('message_id', '=', $this->id)->get();

        if ($userMessage->count() === 0)
            return true;
        else
            return $userMessage->first()->is_read;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageDeletion extends Model
{
    protected $table = 'message_deletions';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function message() {
        return $this->belongsTo('App\Message');
    }
}

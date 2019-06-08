<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    protected $table = 'user_messages';
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function message() {
        return $this->belongsTo('App\Message');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrivacyType extends Model
{
    protected $table = 'privacy_type';
    protected $guarded = [];

    public function users() {
        return $this->hasMany('App\User');
    }

    public function posts() {
        return $this->hasMany('App\Post');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    public function userone() {
        return $this->belongsTo('App\User', 'user_one', 'id');
    }

    public function usertwo() {
        return $this->belongsTo('App\User', 'user_two', 'id');
    }

    public function message() {
    	return $this->hasMany('App\Models\Message', 'conversation_id', 'id');
    }

}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Placement extends Model
{
     use SoftDeletes;

        protected $fillable = [
        'user_id', 'root_id','spillover_id', 'uplines' ];

        protected $dates = ['deleted_at'];
        

        public function user() {
    	return $this->belongsTo('App\User')->withTrashed();
        }

        public function spillover() {
    	return $this->belongsTo('App\User', 'spillover_id')->withTrashed();
        }

}

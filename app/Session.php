<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    //
    protected $table='sessions';    
    protected $dates=['last_activity'];
    protected $with=['user'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    }  
}

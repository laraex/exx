<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{
    use SoftDeletes;
    
    protected $table = 'activity_log';

    protected $dates = ['deleted_at'];

    protected $appends = array('loguser');

    public function loguser()
    {
        return $this->belongsTo('App\User', 'causer_id', 'id');
    }


    
}

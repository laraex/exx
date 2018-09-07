<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberGroupUserLink extends Model
{
    use SoftDeletes;
    
    protected $table = 'membergroup_user_link';
    protected $fillable = [
    	'membergroup_id',
    	'user_id',
    ];

    protected $dates = ['deleted_at'];  
    protected $with = ['user'];

    public function user()
    {
    	return $this->belongsTo('App\User','user_id');
    }
}

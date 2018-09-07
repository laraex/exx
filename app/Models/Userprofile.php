<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Userprofile extends Model
{
    use SoftDeletes;
   
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id', 'usergroup_id'
        ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function usercountry()
    {
        return $this->belongsTo('App\Models\Country', 'country', 'id');
    }
    public function nationality()
    {
        return $this->belongsTo('App\Models\Nationality', 'nationality_id', 'id');
    }

}

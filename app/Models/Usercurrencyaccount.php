<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class Usercurrencyaccount extends Model
{
    use SoftDeletes, PresentableTrait;
   
    protected $dates = ['deleted_at'];

    protected $presenter = "App\Presenters\SitePresenter";

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function userprofile() 
    {
        return $this->belongsTo('App\Models\Userprofile','user_id');
    }

    public function currency() 
    {
       return $this->belongsTo('App\Models\Currency');
    }


    public function scopeUserGroup($query, $usergroup_id) 
    {
        return $query->whereHas('userprofile', function ($q) use ($usergroup_id) 
        {
            $q->where('usergroup_id',$usergroup_id);
        });
    }

    // public function fundtransferuser() {
    //     return $this->hasMany('App\Models\Fundtransfer');
    // }

    // public function country()
    // {
    //     return $this->belongsTo('App\Country', 'country', 'id');
    // }

}

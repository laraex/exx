<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Userpayaccounts extends Model
{
     use SoftDeletes;
    
    protected $dates = ['deleted_at'];

    protected $with = ['paymentgateways'];

    public function payment() 
    {
        return $this->belongsTo('App\Models\Paymentgateway', 'paymentgateways_id', 'id');
    }
    public function scopegetAccountDetails($query,$user_id,$paymentgateway_id)
    {
        return $query->where([['user_id', $user_id],['paymentgateways_id', $paymentgateway_id]]);
    }

    public function paymengateway() 
    {
        return $this->hasMany('App\Models\Paymentgateway', 'paymentgateways_id', 'id');
    }

    public function paymentgateways() 
    {
        return $this->belongsTo('App\Models\Paymentgateway', 'paymentgateways_id');
    }

    // public function user()
    // {
    //     return $this->hasManyThrough('App\User','user_id','id');
    // }
}

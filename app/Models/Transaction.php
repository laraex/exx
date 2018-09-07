<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\LivefeedEvent;
use App\Traits\LivefeedProcess;

class Transaction extends Model
{
    use PresentableTrait, SoftDeletes;

    protected $presenter = "App\Presenters\SitePresenter";

    protected $table = "transactions";

     protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'user_id','currency_id','account_id', 'amount','type','status','accounting_code_id', 'request','response', 'comment','entity_id','entity_name' ];
    protected $appends=['AssociatedModel'];

    protected $with = ['currency','usercurrencyaccount'];

    // public function fromaccount() {
    //     return $this->belongsTo('App\Useraccount');
    // }

    // public function toaccount() {
    //     return $this->belongsTo('App\Useraccount');
    // }
         public static function boot() {
        parent::boot();

        static::created(function($model) {

            $transaction=LivefeedProcess::getlivefeed($model);
            event(new LivefeedEvent($transaction));
        });

         static::updated(function($model) {

            $transaction=LivefeedProcess::getlivefeed($model);
            event(new LivefeedEvent($transaction));
        });
    }

    public function accountingcode() 
    {
        return $this->belongsTo('App\Models\Accountingcode', 'accounting_code_id', 'id');
    }

    public function scopeNew($query) {
        return $query->where([
                    ['deposit_status', 'new'],
             ]);
    }
    public function getAssociatedModelAttribute()
    {

        if(!is_null($this->entity_name))
        {
            $replace='App\\';
            $functionname=str_replace($replace,'',$this->entity_name);
            return $this->$functionname;

         // return $this->hasMany($this->entity_name,$this->entity_id);
        }
        return '';

    }
    public function externalexchange()
    {
       
         return  $this->belongsTo('App\ExternalExchange','entity_id','id');
    }

    public function user()
    {
        return $this->hasManyThrough('App\User','App\Models\Usercurrencyaccount','id','id','account_id','user_id');
    }

    public function usercurrencyaccount()
    {
        return $this->belongsTo('App\Models\Usercurrencyaccount','account_id');
    }

    /*public function currency()
    {
        return $this->hasManyThrough('App\Models\Currency','App\Models\Usercurrencyaccount','id','id','account_id','currency_id');
    }*///Imp
     public function currency()
    {
        return $this->belongsTo('App\Models\Currency','currency_id');
    }

    // public function couponcode()
    // {
    //     return $this->belongsTo('App\CouponCode','entity_id','id');
    // }

     public function scopeBalanceBefore($query,$user_id,$currency_id)
    {
        return $query->where([['user_id', $user_id],['currency_id',$currency_id],['status','approve']]);
    } 
   /* public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
     public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_id');
    }*/
  

    
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Events\WalletEvent;
use Laracasts\Presenter\PresentableTrait;

class ExternalExchange extends Model
{
    use PresentableTrait;
    
    protected $presenter = "App\Presenters\SitePresenter";
    protected $table='external_exchange';
    protected $fillable=['user_id','from_currency_id','to_currency_id','amount','total_exchange_amount','exchange_rate_variant','fee','base_fee','transaction_id','fee_total','exchangerate_per','exchangerate_variant','response','to_response','type'];


    protected $with=['from_currency','to_currency','user'];
     public static function boot() {
        parent::boot();

        static::created(function($model) {

                      event(new WalletEvent($model));

        });

        
    }


     public function from_currency() 
     {
        return $this->belongsTo('App\Models\Currency','from_currency_id','id');
    }


     public function to_currency() {
        return $this->belongsTo('App\Models\Currency','to_currency_id','id');
    }
     public function user()
    {

        return $this->belongsTo('App\User', 'user_id');
    }
}

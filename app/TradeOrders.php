<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\TradeAddEvent;

class TradeOrders extends Model
{
    //
    protected $table='trade_orders';
    protected $fillable=['user_id','type','amount','quantity','from_coin_id','to_coin_id','status','commission','comments','order_id','buy_order_id','sell_order_id','parent_id','order_at','ref_id','total_exchange_amount','exchange_rate_variant','fee','base_fee','fee_total','exchangerate_per','exchangerate_variant','response','cancel_response','from_currency_rate','to_currency_rate','total_amount'];
    protected $dates=['cancel_at','order_at'];
    protected $with=['user'];
       public static function boot() {
     parent::boot();

        static::created(function($model) {
           // event(new TradeEvent());
             event(new TradeAddEvent());
        });

        
    }


    public function fromcurrency()
    {
        return $this->belongsTo('App\Models\Currency', 'from_coin_id');
    }
    public function tocurrency()
    {
        return $this->belongsTo('App\Models\Currency', 'to_coin_id');
    }
     public function order()
    {
        return $this->belongsTo('App\TradeOrders', 'order_id');
    }
     public function buyorder()
    {
        return $this->belongsTo('App\TradeOrders', 'buy_order_id');
    }
     public function sellorder()
    {
        return $this->belongsTo('App\TradeOrders', 'sell_order_id');
    }
     public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}

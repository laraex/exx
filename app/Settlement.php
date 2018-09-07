<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    //
       protected $table='settlements';
       protected $fillable=['user_id','currency_id','entity_id','entity_name','to','type','amount','status','response','mode'];
    public function orderref()
    {
        return $this->belongsTo('App\TradeOrders', 'entity_id');
    }
     public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoinTransactions extends Model
{
	 protected $table='coin_transactions';

	  protected  $fillable=['user_id','paymentgateway_id','from_address','to_address',
	  'txid','amount','confirmations','network','timeStamp','time_stamp','created_at','updated_at', 'token'];
    //

	public function payment()
    {
        return $this->belongsTo('App\Models\Paymentgateway', 'paymentgateway_id', 'id');
    }
    
}

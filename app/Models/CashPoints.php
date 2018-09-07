<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashPoints extends Model
{
    protected $table='cashpoints';

    protected  $fillable=['user_id','currency_id','amount','type',
    'status','entity_id','entity_name','reference_transaction_id','timeStamp','time_stamp','created_at','updated_at', 'balance_before', 'balance_after'];
  //
   	
}

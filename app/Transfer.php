<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
class Transfer extends Model
{
    //
    use PresentableTrait;

    protected $presenter = "App\Presenters\SitePresenter";
    protected $table='transfer';
    protected $fillable=['user_id','amount','coin_id','response','from_address','to_address','status','transaction_id','authorised_at','authorised_by','comment','fee','base_fee','fee_total'];
    protected $dates=['authorised_at'];

     public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
  
     public function currency()
    {
        return $this->belongsTo('App\Models\Currency','coin_id');
    }
}

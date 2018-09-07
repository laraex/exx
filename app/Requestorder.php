<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\TradeEvent;

class Requestorder extends Model
{
    protected $table="requests";
    public static function boot() {
    parent::boot();

       static::created(function($model) {
          // event(new TradeEvent());
           //event(new TradeEvent());
       });

       
   }
    public function fromcurrency() {
        return $this->belongsTo('App\Models\Currency','fromcurrency_id','id');
    }


     public function tocurrency() {
        return $this->belongsTo('App\Models\Currency','tocurrency_id','id');
    }
}

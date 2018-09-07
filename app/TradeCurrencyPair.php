<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use App\Traits\Common;
class TradeCurrencyPair extends Model
{
     //
    use SoftDeletes;
     use Common;
    use PresentableTrait;
    protected $presenter = "App\Presenters\SitePresenter";
    protected $table='trade_currency_pair';
    protected $dates=['deleted_at'];  

    protected $fillable = [
        'from_currency_id', 'to_currency_id','status','min_value','max_value','exchange_rate_variant','buy_fee','buy_base_fee','sell_fee','sell_base_fee','reserve_amount','fromcurrencyname','tocurrencyname'
        ];
    
    protected $appends=['currencypair','exchangerate','currentprice','daybefore','total_transaction'];
    protected $with=['fromcurrency','tocurrency'];

     public function fromcurrency() {
        return $this->belongsTo('App\Models\Currency','from_currency_id','id');
    }


     public function tocurrency() {
        return $this->belongsTo('App\Models\Currency','to_currency_id','id');
    }

    public function getExchangeRateAttribute()
    {
              return $this->getexchangerate(1, $this->fromcurrency->name, $this->tocurrency->name,'buy');

    }
    public function getCurrencyPairAttribute()
    {
              return $this->fromcurrency->name."-".$this->tocurrency->name;

    }
    public function getFromCurrencynameAttribute()
    {
              return $this->fromcurrency->displayname;

    }
    public function getToCurrencynameAttribute()
    {
              return $this->tocurrency->displayname;
    }

    public function getCurrentPriceAttribute()
    {

      //dd($this->fromcurrency->id. $this->tocurrency->id);
              return $this->getOrders(1,$this->fromcurrency->id, $this->tocurrency->id);
    }

    public function getDayBeforeAttribute()
    {
              return $this->getOrders(2, $this->fromcurrency->id, $this->tocurrency->id);
    }
      public function getTotalTransactionAttribute()
    {
              return $this->getOrders(3, $this->fromcurrency->id, $this->tocurrency->id);
    }


}

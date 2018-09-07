<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class CurrencyPair extends Model
{
    //
    use SoftDeletes;
    use PresentableTrait;
    protected $presenter = "App\Presenters\SitePresenter";
    protected $table = 'currency_pair';
    protected $dates = ['deleted_at'];   
    protected $fillable = [
        'from_currency_id',
        'to_currency_id',
        'status',
        'min_amount',
        'max_amount',
        'exchange_rate_variant',
        'fee',
        'base_fee',
        'reserve_amount',
        'type'
        ];

    protected $with=['fromcurrency','tocurrency'];

     public function fromcurrency() {
        return $this->belongsTo('App\Models\Currency','from_currency_id','id');
    }


     public function tocurrency() {
        return $this->belongsTo('App\Models\Currency','to_currency_id','id');
    }
}

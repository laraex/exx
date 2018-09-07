<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class Exchange extends Model
{
    use PresentableTrait, SoftDeletes;

    protected $presenter = "App\Presenters\SitePresenter";

    protected $dates = ['deleted_at'];
    
    public function user() {
        return $this->belongsTo('App\User');
    }

    // public function transaction() {
    //     return $this->belongsTo('App\Models\Transaction');
    // }

    public function exchange_from_account() {
        return $this->belongsTo('App\Models\Usercurrencyaccount', 'from_currency_account', 'id');
    }

    public function exchange_to_account() {
        return $this->belongsTo('App\Models\Usercurrencyaccount', 'to_currency_account', 'id');
    }
    
    public function transaction() 
    {
        return $this->belongsTo('App\Models\Transaction');
    }
    
}

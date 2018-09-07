<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fundtransfer extends Model
{
    use PresentableTrait, SoftDeletes;

    protected $presenter = "App\Presenters\SitePresenter";

    protected $table = "fundtransfers";

    protected $dates = ['deleted_at'];
    
   

    public function user() 
    {
        return $this->belongsTo('App\User');
    }

    public function transaction() 
    {
        return $this->belongsTo('App\Models\Transaction');
    }

    public function fundtransfer_from_id() 
    {
        return $this->belongsTo('App\Models\Usercurrencyaccount', 'from_account_id', 'id');
    }

    public function fundtransfer_to_id() 
    {
        return $this->belongsTo('App\Models\Usercurrencyaccount', 'to_account_id', 'id');
    }

    public function currency()
    {
        return $this->hasManyThrough('App\Models\Currency','App\Models\Usercurrencyaccount','id','id','to_account_id','currency_id');
    }

    // public function from_user() 
    // {
    //     return $this->hasManyThrough('App\User','App\Models\Usercurrencyaccount','id','id','from_account_id','user_id');
    // }
}

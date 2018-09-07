<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class Withdraw extends Model
{
    use PresentableTrait, SoftDeletes;

    protected $presenter = "App\Presenters\SitePresenter";

    protected $fillable = [
        'transaction_id', 'payaccount_id', 'status','amount','type','user_id','completed_on','comments_on_complete' ,'rejected_on','comments_on_rejected', 'cancelled_on',
    ];

    protected $dates = ['completed_on', 'rejected_on', 'deleted_at'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function transaction() {
        return $this->belongsTo('App\Models\Transaction');
    }

    public function userpayaccounts() 
    {
        return $this->belongsTo('App\Models\Userpayaccounts', 'payaccount_id', 'id');
    }
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency','currency_id');
    }
    
}

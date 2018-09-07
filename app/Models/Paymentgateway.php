<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Auth;
use App\Presenters\SitePresenter;
use Laracasts\Presenter\PresentableTrait;

class Paymentgateway extends Model
{
    use CrudTrait,PresentableTrait;
    protected $presenter = "App\Presenters\SitePresenter";

	protected $fillable = [
		'gatewayname', 
		'displayname', 
		'active',  
		'withdraw',
		'withdraw_commission', 
		'exchange', 'params', 
		'instructions',
		'crypto_withdraw_fee',
		'crypto_withdraw_base_fee',
	];

	 protected $with =['currency'];

    //protected $table = 'paymentgateways';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    //protected $fillable = ['gatewayname', 'displayname', 'active',  'withdraw', 'withdraw_commission', 'exchange', 'params', 'instructions'];
    // protected $hidden = [];
    // protected $dates = [];

    
    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| ACCESORS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
	public function  userpayaccounts()
	{
 		return $this->hasMany('App\Models\Userpayaccounts','paymentgateways_id','id')->where([['userpayaccounts.user_id',Auth::id()],['userpayaccounts.active',1]]);
 	}

	public function currency() 
	{
    	return $this->belongsTo('App\Models\Currency','currency_id','id');
    }

    public function  payaccount()
	{
 		return $this->hasMany('App\Models\Userpayaccounts','paymentgateways_id','id');
 	}

	public function  userpayaccount()
	{
 		return $this->hasMany('App\Models\Userpayaccounts','paymentgateways_id','id')->where([['userpayaccounts.user_id',\Session::get('user_id')],['userpayaccounts.active',1]]);	
	}

}

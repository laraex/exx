<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class Deposit extends Model {
	//
	use PresentableTrait, SoftDeletes;

	protected $presenter = "App\Presenters\SitePresenter";
	protected $table = "deposits";
	protected $fillable = ['user_id', 'currency_id', 'amount', 'status', 'request', 'response', 'comment', 'authorised_by', 'transaction_id', 'paymentgateway_id'];
	protected $date = ['authorised_at'];
	public function user() {

		return $this->belongsTo('App\User', 'user_id');
	}
	public function currency() {

		return $this->belongsTo('App\Models\Currency', 'currency_id');
	}
}

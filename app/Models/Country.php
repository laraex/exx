<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Backpack\CRUD\CrudTrait;

class Country extends Model
{
	use PresentableTrait,CrudTrait;

    protected $presenter = "App\Presenters\SitePresenter";
	protected $fillable = ['name', 'status'];
    public function userprofile() {
        return $this->belongsTo('App\Models\Userprofile', 'country', 'id');
    }
}

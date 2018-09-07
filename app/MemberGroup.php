<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberGroup extends Model
{
    use SoftDeletes;
	use PresentableTrait;

    protected $dates = ['deleted_at'];  

    protected $presenter = "App\Presenters\SitePresenter";

    protected $table = 'membergroup';
    protected $fillable = [
    	'usergroup_name',
    	'rules',
    ];

    public function membergrouplink()
    {
    	return $this->hasMany('App\MemberGroupUserLink','membergroup_id','id');
    }
}

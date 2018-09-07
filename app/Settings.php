<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Settings extends Model
{
	use CrudTrait;
	
	protected $table = 'settings';
    protected $fillable = [
        'key','name','description','value', 'field','active',
    ];
}

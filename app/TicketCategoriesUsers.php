<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class TicketCategoriesUsers extends Model
{
	use CrudTrait;

	protected $fillable = ['category_id', 'user_id'];
	
    public function categoryuser()
    {
        return $this->belongsTo('App\Users', 'user_id');
    }

    public function categorylist()
    {
        return $this->belongsTo('App\TicketCategories', 'id');
    }   

}

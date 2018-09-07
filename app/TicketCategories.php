<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class TicketCategories extends Model
{
    use CrudTrait;

    protected $fillable = ['name', 'color'];
    
    public function category()
    {
        return $this->hasMany('App\Ticket', 'category_id', 'id');
    }

    public function categorylist()
    {
        return $this->hasMany('App\TicketCategoriesUsers', 'category_id', 'id');
    }

    public function agentcategory()
    {
        return $this->belongsToMany('App\User');
    }

}

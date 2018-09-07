<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketCategories extends Model
{
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

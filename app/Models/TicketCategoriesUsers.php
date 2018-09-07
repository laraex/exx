<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketCategoriesUsers extends Model
{

    public function categoryuser()
    {
        return $this->belongsTo('App\Users', 'user_id');
    }

    public function categorylist()
    {
        return $this->belongsTo('App\TicketCategories', 'id');
    }   

}

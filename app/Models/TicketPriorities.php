<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketPriorities extends Model
{
    public function priority()
    {
        return $this->hasMany('App\Ticket', 'priority_id', 'id');
    }
}

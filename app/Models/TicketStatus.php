<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
    public function status()
    {
        return $this->hasMany('App\Ticket', 'status_id', 'id');
    }
}

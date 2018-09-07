<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAttachment extends Model
{
    public function attachments()
    {
        return $this->belongsTo('App\Ticket');
    }
}

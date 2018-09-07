<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $appends = array('user', 'category', 'priority', 'status', 'agent');

    protected $fillable = [
        'subject', 'content', 'status_id', 'priority_id', 'user_id', 'agent_id', 'category_id'
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function agent()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\TicketCategories');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\TicketStatus');
    }

    public function priority()
    {
        return $this->belongsTo('App\Models\TicketPriorities');
    }

    public function attachments()
    {
        return $this->hasMany('App\Models\TicketAttachment', 'ticket_id', 'id');
    }

    public function getContentAttribute($content)
    {
        return \Purify::clean($content);
    }
}

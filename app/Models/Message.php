<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class Message extends Model
{
    use PresentableTrait;

    protected $presenter = "App\Presenters\SitePresenter";

    protected $table = "messages";

    protected $fillable = [
        'message', 'is_seen', 'deleted_from_sender', 'user_id', 'conversation_id'
    ]; 

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function conversation() {
        return $this->belongsTo('App\Models\Conversation');
    }

    public function getMessageAttribute($message)
    {
        return \Purify::clean($message);
    }

}
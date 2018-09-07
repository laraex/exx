<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendMail extends Model
{
    //

    protected $table='send_mail';
    protected $fillable=['user_id','subject','message'];

    public function user() {
        return $this->belongsTo('App\User');
    }
}

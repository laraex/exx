<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
   	protected $fillable = ['fullname', 'email', 'contactno', 'skype_gtalk', 'queries'];

   	public function getQueriesAttribute($queries)
    {
        return \Purify::clean($queries);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'name', 'app_name', 'flag', 'abbr', 'script', 'native', 'active', 'default'
    ]; 
   
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class News extends Model
{
    use CrudTrait;


     protected $fillable = ['title', 'story', 'active','language'];
   

    public function getStoryAttribute($story)
    {
        return \Purify::clean($story);
    }

}

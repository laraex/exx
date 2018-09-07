<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * Authentication
 */
class Authentication extends Model
{
    protected $table = 'authentication';
    protected $fillable = ['user_id','token','status','ip_address','expires_on'];
    protected $dates = ['expires_on'];
}

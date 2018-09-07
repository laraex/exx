<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accountingcode extends Model
{

    protected $fillable = [
        'accounting_code', 'active',
    ];

    public function transaction() 
    {
    	return $this->hasMany('App\Models\Transaction');
    }
    
}

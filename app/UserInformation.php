<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;    
class UserInformation extends Model
{
    //
    use SoftDeletes;
    protected $table='user_information';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id', 'status','title','name','state','district','street','source','net_amount','industry','country','city','number','zip','investment','q1','q2','q3','q4','q5'
        ];


    public function user() {
        return $this->belongsTo('App\User');
    }
     public function empcountry()
    {
        return $this->belongsTo('App\Models\Country', 'country', 'id');
    }

}

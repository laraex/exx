<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Traits\LogActivity;
use App\Language;
use Cookie;
use Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use LogActivity;

     public function __construct()
    {
        $languages = Language::where('active', 1)->get();    
        if(!is_null(Cookie::get('locale')))
        {
            Session::put('languageslist', $languages);
        }
        Session::put('languageslist', $languages);        
    }   
}

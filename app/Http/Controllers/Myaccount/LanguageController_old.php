<?php

namespace App\Http\Controllers\Myaccount;

use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Cookie;
use App;
use Config;

class LanguageController_old extends Controller
{
    
    public function index($locale) 
    {
        // dd($locale);
        $languages = Language::where('active', 1)->get();
      
         $abbr = array();
          foreach ($languages as $language)
          {
                $abbr[] = $language['abbr'];
          }
          if (in_array($locale, $abbr)) {
            Session::put('locale', $locale);
          }
          else
         {
            Session::put('locale', Config::get('app.locale'));
         }
         //dd($locale);
         App::setLocale('ur');
          // dd(Session::get('locale'));
         return redirect()->back();
    	
    }
}

<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Models\Userprofile;
use App\Models\Country;
use Carbon\Carbon;

class UserProfileController extends Controller
{
    public function view()
    {  

        $myprofile = Userprofile::where('user_id', Auth::guard('api')->id())->with('user')->first();

       // dd($userprofile);
        
           
            $profile['name'] = $myprofile->user->name;
           if( $myprofile->email_verified )
           {
                $emailVerification = trans('myprofile.verified');
           }
           else
           {
                $emailVerification = trans('myprofile.unverified');
           }
            $profile['email'] = $myprofile->user->email .' '. $emailVerification;
            $profile['firstname'] = $myprofile->firstname;
            $profile['lastname'] = $myprofile->lastname;
            if ($myprofile->Country) 
            {
                $profile['country'] = $myprofile->Country->name;
            }

           if( $myprofile->mobile_verified )
           {
                $mobileVerification = trans('myprofile.verified');
           }
           else
           {
                $mobileVerification = trans('myprofile.unverified');
           }
           if ($myprofile->mobile) 
           {
                $profile['mobile'] = $myprofile->mobile .' '. $mobileVerification;
            }           

           
           return [
            'data' => $profile,
            ];
    }   
}

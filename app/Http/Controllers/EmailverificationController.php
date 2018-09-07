<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Userprofile;
use Validator;
use App\Language;
use Session;

class EmailverificationController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $languages = Language::where('active', 1)->get();
        // Session::put('languageslist', $languages);
    }

    /**
     * Check for user Activation Code
     *
     * @param string $token
     * 
     * @return User
     */

    public function emailverification($token)
    {
        $check = Userprofile::where('email_verification_code', $token)->first();
        if (!is_null($check)) {
            $userprofile = Userprofile::find($check->id);
            if ($userprofile->email_verified == 1) {
                if (!is_null(Auth::id())) {
                    return redirect()->to('myaccount/home')->with('failmessage', trans('forms.user_activate'));
                }

                return redirect()->to('login')->with('failmessage', trans('forms.user_activate'));
            }

            $userprofile->email_verified = 1;
           // $userprofile->email_verification_code = '';
            $userprofile->save();

            // DB::table('userprofiles')->where('email_verification_code', $token)->delete();

            if (!is_null(Auth::id())) {
                    return redirect()->to('myaccount/home')->with('successmessage', trans('forms.user_email_verification_success'));
            }

            return redirect()->to('login')->with('successmessage', trans('forms.user_email_verification_success'));
        }

        if (!is_null(Auth::id())) {
                  return redirect()->to('myaccount/home')->with('failmessage', trans('forms.token_invalid'));
        }
        return redirect()->to('login')->with('failmessage', trans('forms.token_invalid'));
    }
}

<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use session;
use App\User;
use Illuminate\Support\Facades\Auth;
use Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChangePassword;
use App\Http\Requests\ChangePasswordRequest;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin1']);
    }

    public function index()
    {
        return view('admin.changepassword');
    }

    public function updatepassword(ChangePasswordRequest $request)
    {
        //dd('updatepassword');
        $user = User::find(Auth::id());
        $hashedPassword = $user->password;
        if (Hash::check($request->oldpassword, $hashedPassword)) {       
            $user->password = Hash::make($request->newpassword);
            $user->save();
            Mail::to($user->email)->queue(new ChangePassword($user)); 

            $this->doActivityLog(
                $user,
                $user,
                ['ip' => request()->ip()],
                'change password',
                'Changed Profile Password.'                        
            );
            $successmessage = $request->session()->flash('success', trans('myaccount.change_password_message'));
        } 
        else
        {
            $errormessage = $request->session()->flash('errormessage', trans('forms.password_wrong_msg'));              
        }   
        return Redirect::back();
    }

}

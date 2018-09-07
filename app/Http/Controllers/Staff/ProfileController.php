<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ChangePasswordRequest;

use Illuminate\Support\Facades\Mail;
use App\Mail\ChangePassword;

use App\User;
use App\Userprofile;
use Hash;
use Validator;

use App\Http\Controllers\Controller;
use Illuminate\Bus\Queueable;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }     

    public function view()
    {
        
           //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request)
    {        
            //
    }

    public function updateUserprofile(request $request) {

       //
    }

    public function changepassword() {
        //dd("JJ");
        return view('staff.changepassword');
    }

    public function update_change_password(ChangePasswordRequest $request) {
        $user = User::find(Auth::id());
        $hashedPassword = $user->password;
        //dd($hashedPassword);
        if (Hash::check($request->oldpassword, $hashedPassword)) {
            //Change the password          
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
            $successmessage = $request->session()->flash('successmessage', trans('forms.password_success_msg'));            
        } 
        else
        {
            $errormessage = $request->session()->flash('errormessage', trans('forms.password_wrong_msg'));             
        }       
        return back(); 
         
    }
}

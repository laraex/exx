<?php

namespace App\Traits;
use Config;
use App\Authentication;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTP;

trait AuthenticationProcess
{
   
    public  function createAuthentication($user,$request)
    {
       // dd('create');
        $token = $this->getToken();
        $dt = Carbon::now();
        $expiry = $dt->addMinutes(5);

        $create = [
            'user_id'=>$user->id,
            'token'=>$token,
            'status'=>0,
            'ip_address'=>$request->ip(),
            'expires_on'=>$expiry
        ];
        $otp = Authentication::create($create);

        $user = User::find($user->id);
        $email = $user->email;
                                
        Mail::to($email)->send(new OTP($otp));  
        \Session::put('success_message','OTP Send Successfully.');
                
        return true;     
    }
    public function getToken()
    {
        $OtpModeStatus = (bool) getenv('OTP_MODE');
        
        if($OtpModeStatus){
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            $result = '';
            for ($i = 0; $i < 10; $i++) {
                $result .= $characters[mt_rand(0, 61)];
            }
            } else {
                $result = "Gego98765";
            }
            return $result;
    }
  
    public  function checkAuthentication()
    {
        //dd('checkauth');
        if(getenv('OTP')==1)
        {
               $authentication = Authentication::where([['user_id',Auth::id()]])->orderBy('id','DESC')->get();
               //dd($authentication);
               return $authentication[0]->status;  
        }  
        else
       {
           return 1;
       }
    }

    
    public function updateotp($request)
    {
        $authentication= Authentication::where([['user_id',Auth::id()],
            ['status',0]])->orderBy('id','DESC')->get();
        
        $update = [
            'status' => 1,
        ];

        Authentication::where('id',$authentication[0]->id)->update($update);
    }
   
}
<?php

namespace App\Http\Controllers\Myaccount;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\TransactionPasswordRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionPassword;
use App\Mail\ChangePassword;
use App\User;
use App\Models\Userprofile;
use App\Models\Country;
use Hash;
use Validator;
use File;
use Carbon\Carbon;
// use Nexmo\Laravel\Facade\Nexmo;
use Config;
use Illuminate\Bus\Queueable;
use Session;
use App\Mail\ResetTransactionPassword;
use App\Mail\AdminNotifyKycVerify;
use App\Http\Requests\EditProfile2FARequest;
use Cache;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogActivity;

class UserprofileController extends Controller
{   
    use LogActivity;
    public function __construct()
    {
        $this->middleware(['auth', 'member']);
    }
    /**
     * Display a listing of the resource.
     *
     * return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Config::get('settings.twofactor_auth_status') == '1')
        {
            return view('home.profile_validate2fa');
        }
        else
        {
            return redirect(url('/myaccount/profile'));
        }
    }

    public function validate2fa(EditProfile2FARequest $request)
    {
        $user = User::where('id', Auth::id())->first();
        //get user id and create cache key
        $userId = $user->id;
        $key    = $userId . ':' . $request->totp;

        //use cache to store token to blacklist
        Cache::add($key, true, 4);

        return redirect(url('/myaccount/profile'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $country = Country::where('status','active')->get(); 
        $userprofile = Userprofile::where('user_id', Auth::id())->with('user')->first();      

        //dd($userprofile);
        return view('home.myprofile', [
            'country' => $country,
            'userprofile' => $userprofile
            ]);
    }     

    public function view()
    {      
        $userprofile = Userprofile::where('user_id', Auth::id())->with('user','usercountry','nationality')->first();
        //dd($userprofile);
        return view('home.viewprofile', [
                'myprofile' => $userprofile,
            ]);
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
        $userprofile = Userprofile::where('user_id', Auth::id() )->with('user')->first();
        //dd($userprofile);
        // if (Config::get('settings.nexmo_status') == '1' && is_null($userprofile->mobile_verification_code))
        // {
        //     $code = rand(11111, 99999);
        //     try
        //     {
        //         $request->merge(['mobileotp' => $code]);
        //         Nexmo::message()->send([
        //         'to' => $request->mobile,
        //         'from' => Config::get('settings.NEXMO_SMS_FROM_NUMBER'),
        //         'text' => 'Use this verification code '.$code
        //         ]);
                $userprofile = $this->updateUserprofile($request);    
        //     }
        //     catch(\Exception $e)
        //     {
        //         \Session::put('mobilecodeerror', $e->getMessage());  
        //         return back();
        //     }   
        // }
        // else
        // {
        //     $userprofile = $this->updateUserprofile($request);
        // }       

        if ($userprofile)
        { 
            Mail::to($userprofile->user->email)->queue(new AdminNotifyKycVerify($userprofile));
            $request->session()->flash('successmessage', trans('forms.profile_update_success_message'));
        }        
        else
        {   
            $request->session()->flash('errormessage', trans('forms.profile_update_failure_message'));
        }         
        return Redirect::to( url('/myaccount/home'));   
    }

    public function updateUserprofile(request $request) 
    {
       // $destinationPath = public_path("uploads/");
        $file = $request->kyc_doc;
        
        if (!is_null($request->file('kyc_doc')))
        {
            if ($request->file('kyc_doc')->isValid())
            { 
                $user = User::findOrFail(Auth::user()->id);
                $fileNewName = 'kyc/'.$user->name.'_'.time();
                $imgObject = Storage::put($fileNewName, $request->file('kyc_doc'), 'public');
                $userprofile = Userprofile::where('user_id', $user->id)->first();
                $kyc_doc = Storage::url($imgObject);
                $destinationPath = $imgObject;             
            } 
        }
        $userprofile = Userprofile::where('user_id', Auth::id() )->with('user')->first();
        $userprofile->firstname = $request->firstname;
        $userprofile->lastname = $request->lastname;
        // if (is_null($userprofile->mobile) || Config::get('settings.nexmo_status') == '0')
        // {
            $userprofile->mobile = $request->mobile;
        // }
        $userprofile->country = $request->country;
        $userprofile->address1 = $request->address1;
        $userprofile->address2 = $request->address2;
        $userprofile->state = $request->state;
        $userprofile->city = $request->city;
        $userprofile->ssn = $request->ssn;
        // if (!is_null($request->file('kyc_doc')) || $userprofile->kyc_verified == 2)
        // {
        if (!is_null($request->file('kyc_doc')))
        {
            if ($request->file('kyc_doc')->isValid())
            { 
                $userprofile->kyc_doc = $kyc_doc;
            }
        }
        // }
        // if (is_null($userprofile->kyc_doc) || $userprofile->kyc_verified == 2)
        // {
            $userprofile->kyc_verified = 0;
        // } 
        if (Config::get('settings.nexmo_status') == '1')
        {       
            if (is_null($userprofile->mobile_verification_code))
            {    

                $userprofile->mobile_verification_code = $request->mobileotp;      
            }
        }

        $userprofile->save();
           
        // if ($userprofile->save())
        // {
        //     \Session::forget('mobilecodeerror');     
        // }

        $message="Profile Updated";

        $user = User::find(Auth::id());
        $this->doActivityLog(
            $user,
            $user,
            ['ip' => request()->ip()],
            LOGNAME_UPDATEPROFILE,
            $message
        );  
             
        return $userprofile;                  
    }

    public function change_password() 
    {
        return view('home.changepassword');
    }

    public function update_change_password(ChangePasswordRequest $request) 
    {
        // dd($request);
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

    public function transaction_password() 
    {        
        $userprofile = Userprofile::where('user_id', Auth::id())->get(['transaction_password'])->toArray();
        $transactionpassword = $userprofile[0]['transaction_password'];
        
        return view('home.transactionpassword',[
                'transactionpassword' => $transactionpassword
            ]);
    }

    public function update_transaction_password(TransactionPasswordRequest $request) 
    {
        //dd($request);
        $user = User::find(Auth::id());
        $userprofile = Userprofile::where('user_id', Auth::id())->first();
        $hashedPassword = $userprofile->transaction_password;
        
        if (Hash::check($request->old_trans_password, $hashedPassword) || $hashedPassword == '') 
        {       
            $userprofile->transaction_password = Hash::make($request->new_trans_password);
            $userprofile->save();

            Mail::to($user->email)->queue(new TransactionPassword($user)); 
            
            $this->doActivityLog(
                        $userprofile,
                        $user,
                        ['ip' => request()->ip()],
                        'transaction password',
                        'Changed Transaction Password.'                        
                    );                
           $request->session()->flash('successmessage', trans('forms.transaction_password_success_msg'));
        }
        else
        {             
            $request->session()->flash('errormessage', trans('forms.transaction_password_error_msg'));
        }      
        return back();
    }

    public function change_transaction_password()
    {       
        $reset_transaction_password = str_random(8);
        $hashed_random_password = Hash::make($reset_transaction_password);
        //$user = User::find(Auth::id());
        $user = User::where('id', Auth::id())->with('userprofile')->first();
        $userprofile = Userprofile::where('user_id', Auth::id())->first();
        $userprofile->transaction_password = $hashed_random_password;
        $userprofile->save();
        
        Mail::to($user->email)->queue(new ResetTransactionPassword($reset_transaction_password,$user));

        if( count(Mail::failures()) > 0 ) 
        {
           session()->flash('errormessage', trans('forms.reset_transaction_password_error_msg'));
        } 
        else 
        {
            session()->flash('successmessage', trans('forms.reset_transaction_password_success_msg'));
        }        
        return back();     
    }   

    public function changeavatar() 
    {
        
        return view('home.avatar');
    } 

    public function saveavatar(Request $request) 
    {
        Validator::extend('file_extension', function ($attribute, $value, $parameters, $validator) 
        {
            $extension = $value->getClientOriginalExtension();
            return $extension != '' && in_array($extension, $parameters);              
        }, "File type must be jpg,png,jpeg");

        $rules = [
            'profileimage'=>'required|max:10000|mimes:png,jpg,jpeg|file_extension:jpg,jpeg,png,gif'
          ];

        $message = [
            'profileimage.required' => 'Profile image is required',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }

        // $destinationPath = public_path("/uploads/avatars/");
        // $file = $request->profileimage;
       
            if ($request->file('profileimage')->isValid())
            {   
                $user = User::findOrFail(Auth::user()->id);
                $fileNewName = 'avatars/'.$user->name.'_'.time();
                $imgObject = Storage::put($fileNewName, $request->file('profileimage'), 'public');

                $userprofile = Userprofile::where('user_id', $user->id)->first();
                $userprofile->profile_avatar = Storage::url($imgObject);
                $userprofile->save();

                session(['profileimage' => $userprofile->profile_avatar]);
                $message = trans('forms.avatar_success_message');            
            }
            else
            {
                $message = trans('forms.avatar_fail_message');
            }

            $message = 'Avatar Updated';
            $this->doActivityLog(
                    $user,
                    $user,
                    ['ip' => request()->ip()],
                    LOGNAME_UPDATEAVATAR,
                    $message
                );

        return Redirect::to('myaccount/changeavatar')->with('status', $message);
    } 

    public function mobileverification($code)
    {
         $check = Userprofile::where('mobile_verification_code', $code)->first();
          if (!is_null($check))
            {
                $userprofile = Userprofile::find($check->id);
                if ($userprofile->mobile_verified == 1)
                {                          
                    return Redirect::to( url('/myaccount/home'))->with('status', trans('forms.mobile_code_message'));   
                }
            }
        return view('home.mobile',[

                'verificationcode' => $code
            ]);
    }

    public function verificationprocess(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'mobilecode'      => 'required',
            ]);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }

        $check = Userprofile::where('mobile_verification_code', $request->mobilecode)->first();
        //dd($userprofile);
        if (!is_null($check))
        {
            $userprofile = Userprofile::find($check->id);
            if ($userprofile->mobile_verified == 1)
            {
                $request->session()->flash('status', trans('forms.mobile_code_message'));         
                return Redirect::to( url('/myaccount/home'));   
            }

            if ($request->mobilecode == $request->verificationcode)
            {
                $userprofile->mobile_verified = 1;
                $userprofile->save();

                $request->session()->flash('successmessage', trans('forms.mobile_code_success_message'));                 

                 return Redirect::to( url('/myaccount/home')); 
            }
            else
            {
                $request->session()->flash('failmessage', trans('forms.mobile_code_error_message'));  
                return back();  
            }     
        }
        else
        {
            $request->session()->flash('failmessage', trans('forms.mobile_code_error_message'));  
            return back();  
        }       
    }

    public function getmobilecode(Request $request)
    {   
        $country = Country::where('id', $request->countryid)->first();  
        // dd($country);
        return $country->tel_prefix;

    }
}

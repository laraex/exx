<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Traits\RegistersNewUser;
use App\Traits\PlacementProcessor;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Mail\RegisterNewUser;
use App\Mail\AdminNotifyNewUser;
use App\Models\Referralgroup;
use Illuminate\Support\Facades\Input;
use App\Traits\Common;
use App\Models\Blockedusername;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Traits\TransactionProcess;
use App\Models\Nationality;
use App\Models\Userprofile;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, RegistersNewUser, PlacementProcessor,TransactionProcess;
   

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/myaccount/home';
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest');
        $this->setSponsorCookie();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function showRegistrationForm()
    {
        $country = Country::where('status','active')->get();
       $nationality = Nationality::where('status','active')->get();

        return view('auth.register',[
            'country'=>$country,
            'nationality'=>$nationality
            ]);
      
    }

    protected function validator(array $data)
    {

        $rules = [

            'name' => 'required|regex:/^[a-zA-Z0-9]+$/u|min:6|max:12|checkblockedusername',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
          //  'account_type'=>'required',
           // 'sponsor'=>'checksponsor',
            'termsandcondn'=>'required',
            'country'=>'required',
            'contactno'=>'required|numeric',
            'address1'=>'required',
           // 'address2'=>'required',
            'city'=>'required',
            'area'=>'required',
            'postcode'=>'required|regex:/^[a-zA-Z0-9]+$/u',
            'day'=>'required',
            'month'=>'required',
            'year'=>'required',
            'gender'=>'required',
            'nationality'=>'required',
            'identity'=>'required',
            'identityno'=>'required',
            'occupation'=>'required',
        ];
      

        //  Validator::extend('checksponsor', function ($attribute, $value, $parameters, $validator) {
        //          $checktxnhashkey = User::where('name', Input::get('sponsor'))->exists();  
                
        //            if (!$checktxnhashkey)
        //            {
        //                 return FALSE;
        //            }
        //            return TRUE;            
        // }, trans('auth.checksponsor'));

        Validator::extend('checkblockedusername', function ($attribute, $value, $parameters, $validator) {
                 $checkblockedusername = Blockedusername::where('username', Input::get('name'))->exists();  
                
                   if ($checkblockedusername)
                   {
                        return FALSE;
                   }
                   return TRUE;            
        }, trans('forms.checkblockedusername'));


        if (\Config::get('settings.register_captcha_active') == '1') 
        {
            $rules['g-recaptcha-response'] = 'required';
        }  

         $message['g-recaptcha-response.required'] = trans('auth.captcha_req');  
         $message['termsandcondn.required'] = trans('auth.termsandcondn_req'); 
         $message['country.required'] = trans('auth.country_req');
         return Validator::make($data, $rules, $message);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if(\Config::get('settings.force_register_down') == 0)
        {
            $defaultReferralGroup = Referralgroup::where('is_default', '1')->first()->id;
           // $sponsor_id = $this->getSponsorId($data['sponsor']);

            $user =  User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
               // 'account_type'=>$data['account_type'],
                'referralgroup_id' => $defaultReferralGroup,
                'sponsor_id' =>'6',
            ]);

            if ($user)
            {
                $userprofile = $this->createuserprofile($user); 
               // $placement = $this->processPlacement($user);
                $dateofbirth=$data['year']."-".$data['month']."-".$data['day'];
                 $user_profile = Userprofile::where('user_id', $user->id )->first();
                $user_profile->country =  $data['country'];
                $user_profile->mobile =  $data['contactno'];
                $user_profile->address1 =  $data['address1'];
                
                $user_profile->city =  $data['city'];
                $user_profile->state =  $data['area'];
                $user_profile->zipcode =  $data['postcode'];
                $user_profile->dateofbirth =  $dateofbirth;
                $user_profile->gender =  $data['gender'];
                $user_profile->nationality_id =  $data['nationality'];

                if($data['address2']!='')
                {
                         $user_profile->address2 =  $data['address2'];

                }

                if($data['identity']=='passport_no')
                {
                         $user_profile->passport_no =  $data['identityno'];

                }
                elseif($data['identity']=='id_card_no')
                {
                         $user_profile->id_card_no =  $data['identityno'];

                }
                if($data['identity']=='driving_license_no')
                {
                         $user_profile->driving_license_no =  $data['identityno'];

                }
                    
                $user_profile->occupation =  $data['occupation'];
                $user_profile->save();
     
                $admin = User::find(1);
                Mail::to($user->email)->queue(new RegisterNewUser($user));
                Mail::to($admin->email)->queue(new AdminNotifyNewUser($user));
                Mail::to($user->email)->queue(new EmailVerification($userprofile));
                
               $this->doActivityLog(
                    $user,
                    $user,
                    ['ip' => request()->ip()],
                    'register',
                    'User Registered'
                );

            }

            return $user;
      }
     else
     {
        abort(403);
     }
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all()))); 

         if (\Config::get('settings.force_email_verification_login_status')==1)
         {     
                    \Session::put('successmessage',trans('forms.register_success'));    

                    return  redirect()->intended($this->redirectPath());
          }
          else
          {

                $this->guard()->login($user);

                return $this->registered($request, $user)
                                ?: redirect($this->redirectPath());
          }


    }
}

<?php

namespace App\Http\Requests;

use App\Models\Userpayaccounts;
use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Traits\UserInfo;
use App\Models\Withdraw;
use App\Models\Userprofile;
use App\Models\Paymentgateway;
use App\Models\Currency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Hash;
use Crypt;
use Google2FA;
use Cache;
use App\Currencies;

class WithdrawRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    use UserInfo;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {             
        

        $paymentdetails  = Paymentgateway::where('id',Input::get('paymentgateway'))->get(['currency_id'])->toArray();

        $currency = Currency::where('id', $paymentdetails[0]['currency_id'])->get(['withdraw_min_amount','withdraw_max_amount'])->toArray();
        
        $min_max_validation = 'between:'.$currency[0]['withdraw_min_amount'].','.$currency[0]['withdraw_max_amount']; 

        Validator::extend('checkbalance', function ($attribute, $value, $parameters, $validator) {

                // dd($userbalance);
                $user = User::where('id', Auth::id())->with('userprofile')->first();
                $paymentdetails  = Paymentgateway::where('id',Input::get('paymentgateway'))->get(['currency_id'])->toArray();
        
                $userbalance = $this->getUserCurrencyBalance($user, $paymentdetails[0]['currency_id']);
               if ($value > $userbalance)
               {
                    return FALSE;
               }
               return TRUE;            
        });

        Validator::extend('checkdailywithdrawlimit', function ($attribute, $value, $parameters, $validator) 
        {
            $withdrawcount = Withdraw::where('user_id', Auth::id())
                              ->whereRaw('Date(created_at) = CURDATE()')
                              ->where('autowithdraw', '0')->where('status', '!=', 'request')
                              ->get()->count();
            //dd(\Config::get('settings.daily_withdraw_limit')); 
               if ($withdrawcount >= \Config::get('settings.daily_withdraw_limit'))
               {
                    return FALSE;
               }
               return TRUE;            
        });    

        Validator::extend('checkmonthlywithdrawlimit', function ($attribute, $value, $parameters, $validator) 
        {
            $currentMonth = date('m');            
            $withdrawcount = Withdraw::where('user_id', Auth::id())
                              ->whereRaw('MONTH(created_at) = ?',[$currentMonth])
                              ->where('autowithdraw', '0')->where('status', '!=', 'request')
                              ->get()->count();
           //dd(\Config::get('settings.monthly_withdraw_limit')); 

             if ($withdrawcount >=100)
             // if ($withdrawcount >= \Config::get('settings.monthly_withdraw_limit'))
              {
                  return FALSE;
              }
              return TRUE;            
        }); 

        Validator::extend('checkpayaccount', function ($attribute, $value, $parameters, $validator) 
        {         
            $result  = Userpayaccounts::where([                                           
                                    ['user_id', '=', Auth::id()],
                                    ['paymentgateways_id', '=', Input::get('paymentgateway')]
                                    ])->exists();
                   if (!$result)
                   {
                        return FALSE;
                   }
                   return TRUE;            
        }); 

        Validator::extend('checkvalidpassword', function ($attribute, $value, $parameters, $validator) {

           $userprofile = Userprofile::where('user_id', Auth::id())->pluck('transaction_password');
           //dd($userprofile[0]);

           if (!Hash::check(Input::get('trans_password'), $userprofile[0]))  
           {
                return FALSE;
           } 
           return TRUE;
        }); 

        Validator::extend('valid_token', function ($attribute, $value, $parameters, $validator) {
                $user = User::where('id', Auth::id())->first();      
                $secret = Crypt::decrypt($user->google2fa_secret);
                return Google2FA::verifyKey($secret, $value);
            },
            'Not a valid token'
        ); 

        Validator::extend('used_token', function ($attribute, $value, $parameters, $validator) {
                $user = User::where('id', Auth::id())->first();
                $key = $user->id . ':' . $value;
                //dd($key);
                return !Cache::has($key);
            },
            'Cannot reuse token'      
        );                      
               
        $rules = [
            'amount' => 'required|numeric|'.$min_max_validation.'|checkbalance|checkmonthlywithdrawlimit|checkpayaccount',
            'trans_password' => 'required|checkvalidpassword',
        ];

        //   $rules = [
        //     'amount' => 'required|numeric|'.$min_max_validation.'|checkbalance|checkmonthlywithdrawlimit|checkdailywithdrawlimit|checkpayaccount',
        //     'transaction_password' => 'required|checkvalidpassword',
        // ];

        // if(\Config::get('settings.twofactor_auth_status') == '1')
        // {
        //     $rules['totp'] = 'bail|required|digits:6|valid_token|used_token';                        
        // }  
        
        return $rules;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'amount.required' => trans('forms.amountrequired'),
            'amount.checkbalance' => trans('forms.errorbalance'),
            'amount.between' => trans('forms.withdraw_amount_between'),
            'amount.checkmonthlywithdrawlimit' => trans('forms.monthly_withdraw_limit'),
            'amount.checkdailywithdrawlimit' => trans('forms.daily_withdraw_limit'),
            'amount.checkpayaccount' => trans('forms.checkpayaccount'),
            'trans_password.checkvalidpassword' => trans('forms.checkvalidpassword'),
        ];
    }

}

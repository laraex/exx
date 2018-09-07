<?php

namespace App\Http\Requests;

use App\Userpayaccounts;
use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Traits\UserInfo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Userprofile;
use Hash;
use Crypt;
use Google2FA;
use Cache;

class FundTransferRequest extends FormRequest
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
        $min_max_validation = 'between:'.Config::get('settings.fundtransfer_min_amount').','.Config::get('settings.fundtransfer_max_amount');       

        Validator::extend('checkbalance', function ($attribute, $value, $parameters, $validator) 
        {
            $user = User::where('id', Auth::id())->first();

            $userbalance = $this->getUserCurrencyBalance($user,\Session::get('currencyid'));
                 
            if ($value > $userbalance)
            {
                return FALSE;
            }
            return TRUE;            
        });  

        Validator::extend('checkusername', function ($attribute, $value, $parameters, $validator) 
        {
            if (Input::get('sendto') == 'No Result Found')
            {
                return FALSE;
            } 
            return TRUE;               
        }); 

        Validator::extend('checkselftransaction', function ($attribute, $value, $parameters, $validator) 
        {
            $transferuser = User::where('name', Input::get('sendto'))->first();
            $loginuser = User::where('id', Auth::id())->first();

            if ($loginuser->id == $transferuser->id)
            {
                return FALSE;
            }   
            return TRUE;               
        }); 

        Validator::extend('checkvalidpassword', function ($attribute, $value, $parameters, $validator) 
        {
            $userprofile = Userprofile::where('user_id', Auth::id())->pluck('transaction_password');
            //dd($userprofile[0]);

            if (!Hash::check(Input::get('transaction_password'), $userprofile[0]))  
            {
                return FALSE;
            } 
            return TRUE;
        });  

        Validator::extend('valid_token', function ($attribute, $value, $parameters, $validator) {
                $user = User::where('id', Auth::id())->first(); 
               // dd($user->google2fa_secret);     
                $secret = Crypt::decrypt($user->google2fa_secret);
               // dd($secret);
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
            'amount' => 'required|numeric|'.$min_max_validation.'|checkbalance',
            'sendto' => 'required|checkusername|checkselftransaction',
            'transaction_password' => 'required|checkvalidpassword',
        ];  
        
        if(\Config::get('settings.twofactor_auth_status') == '1')
        {
            $rules['totp'] = 'bail|required|digits:6|valid_token|used_token';                        
        }         

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
            'amount.between' => trans('forms.fund_amount_between'),
            'sendto.required' => trans('forms.sendtorequired'),
            'sendto.checkusername' => trans('forms.checkusername'),
            'sendto.checkselftransaction' => trans('forms.checkselftransaction'),
            'transaction_password.checkvalidpassword' => trans('forms.checkvalidpassword'),
        ];
    }

}

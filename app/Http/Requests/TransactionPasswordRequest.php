<?php

namespace App\Http\Requests;
use App\Models\Userprofile;
use Lang;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Crypt;
use Google2FA;
use Cache;
use App\User;
use Hash;

class TransactionPasswordRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {    

        Validator::extend('checkpassword', function ($attribute, $value, $parameters, $validator) {

             $userprofile = Userprofile::where('user_id', Auth::id())->first();
             $oldPassword=$userprofile->transaction_password;
                if (Hash::check(Input::get('old_trans_password'), $oldPassword))    
                   {
                        return TRUE;
                   }

                   
                   return FALSE;  
                        
             } );                 
        $rules = [
             
            'new_trans_password' => 'required|min:6', 
            'confirm_trans_password' => 'required|min:6|same:new_trans_password'              
        ];

        $userprofile = Userprofile::where('user_id', Auth::id())->get(['transaction_password'])->toArray();
        $transactionpassword = $userprofile[0]['transaction_password'];

        if ( $transactionpassword)
        {
            $rules['old_trans_password'] = 'required|min:6|checkpassword';                  
        } 

        if($transactionpassword && \Config::get('settings.twofactor_auth_status') == '1')
        {
            $rules['totp'] = 'bail|required|digits:6|valid_token|used_token';                  
        }  

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
                return !Cache::has($key);
            },
            'Cannot reuse token'      
        );  

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
            'old_trans_password.required' => trans('forms.old_transaction_password_req'), 
            'new_trans_password.required' => trans('forms.new_transaction_password_req'), 
            'confirm_trans_password.required' => trans('forms.confirm_transaction_password_req'),
            'old_trans_password.min' => trans('forms.old_transaction_password_min'),
            'new_trans_password.min' => trans('forms.new_trans_password_min'),
            'confirm_trans_password.min' => trans('forms.confirm_trans_password_min'),
            'confirm_trans_password.same' => trans('forms.confirm_trans_password_same'),
            'old_trans_password.checkpassword' => trans('forms.old_trans_password'),
        ];
    }

}

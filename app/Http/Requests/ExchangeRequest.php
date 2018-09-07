<?php

namespace App\Http\Requests;

use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Traits\UserInfo;
use App\Models\Paymentgateway;
use App\Models\Userprofile;
use Hash;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class ExchangeRequest extends FormRequest
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
        // dd(Input::get('fromcurrency'));
        Validator::extend('checkbalance', function ($attribute, $value, $parameters, $validator) {

                $user = User::where('id', Auth::id())->with('userprofile')->first();               

                // dd($paymentdetails[0]['currency_id']);

                $userbalance = $this->getUserCurrencyBalance($user, Input::get('fromcurrency'));
                // dd($userbalance);
                  
                   if (Input::get('fromamount') > $userbalance)
                   {
                        return FALSE;
                   }
                   return TRUE;            
        }); 

         Validator::extend('checkvalidpassword', function ($attribute, $value, $parameters, $validator) {

           $userprofile = Userprofile::where('user_id', Auth::id())->pluck('transaction_password');
           //dd($userprofile[0]);

           if (!Hash::check(Input::get('transaction_password'), $userprofile[0]))  
           {
                return FALSE;
           } 
           return TRUE;
        });              

      
        $rules = [

            'fromamount' => 'checkbalance',
            'transaction_password' => 'checkvalidpassword',
            
        ];        

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
            'fromamount.checkbalance' => trans('forms.errorbalance'),
            'transaction_password.checkvalidpassword' => trans('forms.checkvalidpassword'),
            
        ];
    }

}

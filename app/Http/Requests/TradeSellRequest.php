<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Lang;
use App\Traits\CoinProcess;
use App\Models\Currency;
use App\User;
use App\Models\Userprofile;
use App\Classes\block_io\BlockIo;
use Exception;
use App\Coinorder;
use App\Settings;
use App\Models\Userpayaccounts;
use App\Traits\UserInfo;
use Hash;
use App\TradeCurrencyPair;

class TradeSellRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    use UserInfo;

    public $currencydetails;
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

      

      Validator::extend('checkamount', function ($attribute, $value, $parameters, $validator) 
      {
        if (Input::get('sell_amount')<=0)
        {
          return FALSE;
        }
          return TRUE;  
      });

      Validator::extend('checkbalance', function ($attribute, $value, $parameters, $validator) {

                $user = User::where('id', Auth::id())->with('userprofile')->first();               

            $currency = Currency::where('name',Input::get('fromcur'))->first();

         
             //   $userbalance=$this->getcurrencyBalance($currency->name,$currency->id,Auth::id(),'balance');
              $userbalance = $this->getUserCurrencyBalance($user,$currency->id);
                   $orderamount=Input::get('sell_volume');

                  // $balance='2000';
                  // dd($orderamount);
                  // \Session::get('order_amount')

                   if ($orderamount > $userbalance)
                   {
                        return FALSE;
                   }
                   return TRUE;            
        });
       /*  Validator::extend('checkaddress', function ($attribute, $value, $parameters, $validator) {

             $currencys = Currency::where('name',Input::get('fromcur'))->first();
             
            $useraddress=$this->getcurrencyBalance($currencys->name,$currencys->id,Auth::id(),'address');
                if ($useraddress!='')    
                   {
                        return TRUE;
                   }
                   return FALSE;  
                        
             });*/

       Validator::extend('checkminmax', function ($attribute, $value, $parameters, $validator) {
          

             $currencypair = TradeCurrencyPair::where('id',Input::get('currency_pair'))->first();

                if ($currencypair->min_value<=Input::get('sell_volume') && $currencypair->max_value>=Input::get('sell_volume'))    
                   {
                        return TRUE;
                   }
                   return FALSE;  
                        
        });

     

          // Validator::extend('checkpassword', function ($attribute, $value, $parameters, $validator) {

          //    $userprofile = Userprofile::where('user_id', Auth::id())->first();
          //    $oldPassword=$userprofile->transaction_password;
          //       if (Hash::check(Input::get('transaction_password'), $oldPassword))    
          //          {
          //               return TRUE;
          //          }

                   
          //          return FALSE;  
                        
          //    } ); 

       $rules['sell_amount']='required|numeric';
       $rules['sell_volume']='required|numeric|checkbalance|checkminmax';
      // $rules['buy_payment_thro']='required';
      // $rules['transaction_password']='required|checkpassword';
  
      return  $rules;
    }

    public function messages()
    {

      $currencypair = TradeCurrencyPair::where('id',Input::get('currency_pair'))->first();

      $minmax=trans('forms.min_max_error', ['min' =>$currencypair->min_value,'max'=>$currencypair->max_value]);

 

      $messages= [
             'sell_amount.checkamount'=>trans('forms.amount_error')];
         //$messages['amount.checklimit']=trans('forms.limit_balance');
         $messages['sell_volume.checkbalance']=trans('forms.errorbalance');
        
         $messages['sell_volume.checkminmax']=$minmax;
         //$messages['transaction_password.checkpassword']=trans('forms.password_wrong_msg');
          return $messages;
    }

}
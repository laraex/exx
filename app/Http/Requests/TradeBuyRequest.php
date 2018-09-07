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
use App\Models\Usercurrencyaccount;


class TradeBuyRequest extends FormRequest
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

   

      //$this->pair_details = TradeCurrencyPair::where([['id',Input::get('pair')],['status','active']])->first(); 


      Validator::extend('checkamount', function ($attribute, $value, $parameters, $validator) 
      {
        if (Input::get('buy_amount')<=0)
        {
          return FALSE;
        }
          return TRUE;  
      });

      Validator::extend('checkbalance', function ($attribute, $value, $parameters, $validator) {

                $user = User::where('id', Auth::id())->with('userprofile')->first();   

                 $userbalance=0;            

                // dd($paymentdetails[0]['currency_id']);

            $currency = Currency::where('name',Input::get('tocur'))->first();

            //  $userbalance=$this->getcurrencyBalance($currency->name,$currency->id,Auth::id(),'balance');
                 $userbalance = $this->getUserCurrencyBalance($user,$currency->id);
                //$userbalance=5000;

                   $orderamount=Input::get('buy_amount')*Input::get('buy_volume');
                   
                  // dd($orderamount);
                  // \Session::get('order_amount')

                   if ($orderamount > $userbalance)
                   {
                        return FALSE;
                   }
                   return TRUE;            
        });

          /*Validator::extend('checkaddress', function ($attribute, $value, $parameters, $validator) {

             $currencys = Currency::where('name',Input::get('fromcur'))->first();
             
            $useraddress=$this->getcurrencyBalance($currencys->name,$currencys->id,Auth::id(),'address');
                if ($useraddress!='')    
                   {
                        return TRUE;
                   }
                   return FALSE;  
                        
             }); 
*/
        Validator::extend('checkminmax', function ($attribute, $value, $parameters, $validator) {
          

             $currencypair = TradeCurrencyPair::where('id',Input::get('currency_pair'))->first();


            // dd($currencypair);
            //$useraddress=$this->getcurrencyBalance($currencys->name,$currencys->id,Auth::id(),'address');

             //dd($currencypair->min_value." ".$currencypair->max_value);

                if ($currencypair->min_value<=Input::get('buy_volume') && $currencypair->max_value>=Input::get('buy_volume'))    
                   {
                        return TRUE;
                   }
                   return FALSE;  
                        
        }); 


      //$rules['buy_amount']='required|numeric|checkbalance';

      $rules['buy_amount']='required|numeric|checkbalance';
      // $rules['buy_amount']='required|numeric|checkbalance';
       $rules['buy_volume']='required|numeric|checkminmax';
      // $rules['buy_payment_thro']='required';
      // $rules['transaction_password']='required|checkpassword';
  
      return  $rules;
    }
    public function messages()
    {

      $currencypair = TradeCurrencyPair::where('id',Input::get('currency_pair'))->first();

      $minmax=trans('forms.min_max_error', ['min' =>$currencypair->min_value,'max'=>$currencypair->max_value]);


      $messages= [
             'buy_amount.checkamount'=>trans('forms.amount_error')
           ];
         //$messages['amount.checklimit']=trans('forms.limit_balance');
         $messages['buy_amount.checkbalance']=trans('forms.errorbalance');

       
         
         $messages['buy_volume.checkminmax']=$minmax;


         //$messages['transaction_password.checkpassword']=trans('forms.password_wrong_msg');
          return $messages;

    }

}
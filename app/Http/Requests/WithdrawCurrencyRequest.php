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

class WithdrawCurrencyRequest extends FormRequest
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
        if (Input::get('amount')<=0)
        {
          return FALSE;
        }
          return TRUE;  
      });

      Validator::extend('checkbalance', function ($attribute, $value, $parameters, $validator) {



                $user = User::where('id', Auth::id())->with('userprofile')->first();

               // Input::get('currency')               

                // dd($paymentdetails[0]['currency_id']);

                 //$currency = Currency::where('name',Input::get('fromcur'))->first();

            //$userbalance = $this->getUserCurrencyBalance($user,  $currency->id);

                

      if(Input::get('currency')=="BTC")
      {
    //BTC
        $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
        $balance=0;
        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
        if(count($user_accounts)>0)
        {
            if($user_accounts->btc_address!='')
              {
                   $balance=$this->getWalletBalance($user_accounts->btc_address);
              }
        }

        //dd($balance);

      }
    if(Input::get('currency')=="LTC")
     {
      //LTC
        $pg_ltc = $this->getPgDetailsByGatewayName('ltc_blockio');
        $balance_ltc=0;
        $user_accounts_ltc=Userpayaccounts::getAccountDetails(Auth::id(),$pg_ltc->id)->first();
         if(count($user_accounts_ltc)>0)
         {
            if($user_accounts_ltc->ltc_address!='')
              {
                   $balance=$this->getLTCWalletBalance($user_accounts_ltc->ltc_address);
              }
         }
       }

       // if(Input::get('stocurid')=="8")
       // {
       //  //DOGE
       //  $pg_doge = $this->getPgDetailsByGatewayName('dogecoin_blockio');
       //  $balance_doge=0;
       //  $user_accounts_doge=Userpayaccounts::getAccountDetails(Auth::id(),$pg_doge->id)->first();
       //   if(count($user_accounts_doge)>0)
       //   {
       //      if($user_accounts_doge->doge_address!='')
       //        {
       //             $balance=$this->getDOGEWalletBalance($user_accounts_doge->doge_address);
       //        }
       //    }
       // }
                 //dd($userbalance);

                  // $orderamount=Input::get('sell_amount')*Input::get('sell_volume');
            
                   $orderamount=Input::get('amount');

                  // $balance='2000';
                  // dd($orderamount);
                  // \Session::get('order_amount')

                   if ($orderamount > $balance)
                   {
                        return FALSE;
                   }
                   return TRUE;            
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

       $rules['amount']='required|numeric|checkbalance';

       $rules['address']='required';
      // $rules['buy_payment_thro']='required';
      // $rules['transaction_password']='required|checkpassword';
  
      return  $rules;
    }

    public function messages()
    {

      $messages= [
             'amount.checkamount'=>trans('forms.amount_error')];
         //$messages['amount.checklimit']=trans('forms.limit_balance');
         $messages['amount.checkbalance']=trans('forms.errorbalance');
         //$messages['transaction_password.checkpassword']=trans('forms.password_wrong_msg');
          return $messages;
    }

}
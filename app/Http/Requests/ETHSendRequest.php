<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Lang;
use App\Traits\CoinProcess;
use App\User;
use App\Traits\Common;
use App\Models\Userpayaccounts;
use Exception;
use App\Http\Controllers\CryptoPayment\CryptoPaymentBase;
use App\Models\Userprofile;
use Hash;
use Cache;
use Crypt;
use Google2FA;
use App\Traits\UserInfo;
class ETHSendRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    use UserInfo;

 
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
      Validator::extend('checkaddress', function ($attribute, $value, $parameters, $validator)
      {            
        $pg = $this->getPgDetailsByGatewayName('eth');
        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->count();
        if($user_accounts==0)
        {
          return FALSE;
        }   
          return TRUE;  
      });

      Validator::extend('checkamount', function ($attribute, $value, $parameters, $validator) 
      {
        if (Input::get('amount')<=0)
        {
          return FALSE;
        }
          return TRUE;  
      });

       Validator::extend('checkuserbalance', function ($attribute, $value, $parameters, $validator) 
      {
        $pg = $this->getPgDetailsByGatewayName('eth');
        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first(); 
        $balance=0;
        $user = User::where('id', Auth::id())->first(); 
         $balance = $this->getUserCurrencyBalance($user,$pg->currency_id);
        if(count($user_accounts)>0)
        {
            if($user_accounts->eth_address!='')
              { 
                 $user = User::where('id', Auth::id())->first(); 
                  $balance = $this->getUserCurrencyBalance($user,$pg->currency_id);
                  // $balance=$this->getWalletBalance($user_accounts->btc_address);
                 
              }
        }
        \Session::put('etherror','');

        $amount=sprintf("%.8f",Input::get('amount'));
        $total=0;         
        
        //$to_btc_address= $params['btc_address'];   
         $to_eth_address= Input::get('address');   

        
        try
        {
         
             // $fee= CryptoPaymentBase::crypto_calculateBTCAdminFee($amount);
               $fee=$pg->crypto_withdraw_fee;
               $base_fee=$pg->crypto_withdraw_base_fee;

               $fee_total=($amount*($fee/100))+$base_fee;

               $total=$fee_total+$amount;
            if ($balance<$total)
            {
              return FALSE;
            }
            else
            {  
              return TRUE; 
            }     
        }
        catch (Exception $e)
        {
          $etherror=$e->getMessage();

            \Session::put('etherror',$etherror);
          return FALSE;
        }
      });

      //sowmi
      Validator::extend('checkvalidpassword', function ($attribute, $value, $parameters, $validator) {

           $userprofile = Userprofile::where('user_id', Auth::id())->first();
         

           if (!Hash::check(Input::get('transaction_password'), $userprofile->transaction_password))  
           {
                return FALSE;
           } 
           return TRUE;
        }); 

      Validator::extend('checktwofa', function ($attribute, $value, $parameters, $validator) 
      {
        $user = User::where('id',Auth::id())->first();
        //dd($user);
        $status = $user->google2fa_secret_status;
//dd($status);
        if($status == 0)
        {
          return FALSE;
        }
          return TRUE;  
      });
      Validator::extend('valid_token', function ($attribute, $value, $parameters, $validator) 
      {
        $user = User::where('id', Auth::id())->first(); 
        
        if($user->google2fa_secret_status == '1') 
        {    
          $secret = Crypt::decrypt($user->google2fa_secret);
            // dd($secret);
          return Google2FA::verifyKey($secret, $value);
        }
      },'Not a valid token'); 

      Validator::extend('used_token', function ($attribute, $value, $parameters, $validator) 
      {
        $user = User::where('id', Auth::id())->first();
        $key = $user->id . ':' . $value;
          //dd($key);
        return !Cache::has($key);
      },'Cannot reuse token');     

      $rules=[
        'amount'=>'sometimes|numeric|checkamount|checkuserbalance|required',
        'address'=>'required',
        'transaction_password' => 'required|checkvalidpassword',
       // 'twofa' => 'required|digits:6|checktwofa|valid_token|used_token', 
      ];
     
    return  $rules;
    }

    public function messages()
    {
      $messages= [
        'amount.checkamount'=>trans('forms.amount_error'),
        'amount.checkaddress'=>trans('forms.eth_address_error'),
        'transaction_password.checkvalidpassword'=>trans('forms.checkvalidpassword'),
        //'twofa.checktwofa'=>trans('forms.checktwofa'),         
      ];

      if(\Session::get('etherror')!='')
      {
          $messages['amount.checkuserbalance']=\Session::get('etherror');
       
      }
      else
      {
        $messages['amount.checkuserbalance']=trans('forms.errorbalance');
      }
        
      return $messages;
    }

}
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
use App\Classes\block_io\BlockIo;
use Exception;
use App\Http\Controllers\CryptoPayment\CryptoPaymentBase;
use App\Traits\UserInfo;
class BitcoincashSendRequest extends FormRequest
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
        $pg = $this->getPgDetailsByGatewayName('bch');
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
        $pg = $this->getPgDetailsByGatewayName('bch');
        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first(); 
        $balance=0;
        if(count($user_accounts)>0)
        {
            if($user_accounts->bch_address!='')
              {
                  $user = User::where('id', Auth::id())->first(); 
                  $balance = $this->getUserCurrencyBalance($user,$pg->currency_id);
              }
        }
        \Session::put('bcherror','');
        $amount=sprintf("%.8f",Input::get('amount'));
        $total=0;         
 
         $to_bch_address= Input::get('address');  

        try
        {
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
          $bitcoinerror=$e->getMessage();
          \Session::put('bitcoinerror',$bitcoinerror);
          return FALSE;
        } 

      });
 
      $rules=[
        'amount'=>'sometimes|numeric|checkamount|checkuserbalance|required',
        'address'=>'required',
      ];
        return  $rules;
    }
    public function messages()
    {
      $messages= [
        'amount.checkamount'=>trans('forms.amount_error'), 
        'amount.checkaddress'=>trans('forms.bch_address_error'),          
        ];

        if(\Session::get('bcherror')!='')
        {
            $messages['amount.checkuserbalance']=\Session::get('bcherror');
         
        }
        else
        {
          $messages['amount.checkuserbalance']=trans('forms.errorbalance');
        }

        return $messages;
    }
}
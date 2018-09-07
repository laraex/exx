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
//use App\Classes\block_io\BlockIo;
use Exception;
use App\Coinorder;
use App\Settings;
use App\Models\Userpayaccounts;
use App\Traits\UserInfo;
use App\Http\Controllers\CryptoPayment\CryptoPaymentBase;
class BuyCoinRequest extends FormRequest
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
      $coin_currency_id=\Session::get('coin_currency_id');
      $currencydetails = Currency::where('id',$coin_currency_id)->first();
      $this->currencydetails=$currencydetails ;

      Validator::extend('checkamount', function ($attribute, $value, $parameters, $validator) 
      {
        if (Input::get('amount')<=0)
        {
          return FALSE;
        }
          return TRUE;  
      });

      Validator::extend('checkbalance_btc', function ($attribute, $value, $parameters, $validator) 
      {
        $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
        \Session::put('bitcoinerror','');

        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();

        if(count($user_accounts)==0)
        {
          return FALSE;
        }
        else
        {
          $balance=0;
          $amount=sprintf("%.8f",Input::get('amount'));
          $total=0; 
      
          $balance = $this->getBTCWalletAdminBalance(); 
          
          try
          {
           

             $fee= CryptoPaymentBase::crypto_calculateBTCFee($amount,$user_accounts->btc_address);
             $total=$fee+$balance;
            

            if($balance>0)
            {
              if ($amount>$total)
              {
                return FALSE;
              }
              else
              {  
                return TRUE; 
              }
            }
            else
            {
              return FALSE;
            } 
          }
          catch (Exception $e)
          {
            $bitcoinerror=$e->getMessage();

            \Session::put('bitcoinerror',$bitcoinerror);
             return FALSE;
          }          
        }           
      });
     
      Validator::extend('checkbalance_ltc', function ($attribute, $value, $parameters, $validator) 
      {
        $pg = $this->getPgDetailsByGatewayName('ltc_blockio');

        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();

        if(count($user_accounts)==0)
        {
          return FALSE;
        }


      else
        {

            $balance=0;
       
        \Session::put('ltcerror','');

        $amount=sprintf("%.8f",Input::get('amount'));
            $total=0;         
                   
                     
                      $balance=$this->getLTCWalletAdminBalance(); 
                     
                      try{
                             $fee= CryptoPaymentBase::crypto_calculateLTCFee($amount,$user_accounts->ltc_address);
                               $total=$fee+$balance;

                    if($balance>0)
                      {
                         if ($amount>$total)
                         {


                              return FALSE;
                         }
                         else
                         {  
                           return TRUE; 

                         }
                       }
                       else
                       {

                            return FALSE;
                       }
                       
                      }
                      catch (Exception $e)
                      {

                        $ltcerror=$e->getMessage();

                        \Session::put('ltcerror',$ltcerror);
                         return FALSE;

                      }
                    }
             
                        
             } );
     Validator::extend('checkbalance_doge', function ($attribute, $value, $parameters, $validator) {
     
        $pg = $this->getPgDetailsByGatewayName('dogecoin_blockio');

        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();

        if(count($user_accounts)==0)
        {
          return FALSE;
        }


      else
        {

            $balance=0;
       
        \Session::put('dogeerror','');

        $amount=sprintf("%.8f",Input::get('amount'));
            $total=0;         
                   
                      $params = json_decode($pg->params, true);   
                      $api_key= $params['api_key'];
                      $pin= $params['pin'];   
                      $to_doge_address= $params['doge_address'];   
                      $balance=$this->getDOGEWalletBalance($to_doge_address); 
                      $version = $params['version']; // API version
                      $block_io = new BlockIo( $api_key, $pin, $version);
                      try{

                      $network_fee=$block_io->get_network_fee_estimate(array('amounts' => $amount, 'to_addresses' => $user_accounts->doge_address));
              
                      $total=$balance+($network_fee->data->estimated_network_fee);

                    if($balance>0)
                      {
                         if ($amount>$total)
                         {


                              return FALSE;
                         }
                         else
                         {  
                           return TRUE; 

                         }
                       }
                       else
                       {

                            return FALSE;
                       }
                       
                      }
                      catch (Exception $e)
                      {

                        $dogeerror=$e->getMessage();

                        \Session::put('dogeerror',$dogeerror);
                         return FALSE;

                      }
                    }
             
                        
             } );

     Validator::extend('checkbalance_eth', function ($attribute, $value, $parameters, $validator) 
      {

        $pg = $this->getPgDetailsByGatewayName('eth');
        \Session::put('etherror','');

        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();

        if(count($user_accounts)==0)
        {
          return FALSE;
        }
        else
        {
          $balance=0;
          $amount=sprintf("%.8f",Input::get('amount'));
          $total=0; 
      
          $balance = $this->getETHWalletAdminBalance(); 
                
          try
          {
           
           
             $fee= CryptoPaymentBase::crypto_calculateETHFee();
             $total=$fee+$balance;
            

            if($balance>0)
            {
              if ($amount>$total)
              {
                return FALSE;
              }
              else
              {  
                return TRUE; 
              }
            }
            else
            {
              return FALSE;
            } 
          }
          catch (Exception $e)
          {
            $bitcoinerror=$e->getMessage();

            \Session::put('etherror',$etherror);
             return FALSE;
          }          
        }           
      });
      Validator::extend('checkbalance_bch', function ($attribute, $value, $parameters, $validator) 
      {
        $pg = $this->getPgDetailsByGatewayName('bch');
        \Session::put('bitcoincasherror','');

        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();

        if(count($user_accounts)==0)
        {
          return FALSE;
        }
        else
        {
          $balance=0;
          $amount=sprintf("%.8f",Input::get('amount'));
          $total=0; 
      
          $balance = $this->getBCHWalletAdminBalance(); 
          
          try
          {
           

             $fee= CryptoPaymentBase::crypto_calculateBCHFee($amount,$user_accounts->bch_address);
             $total=$fee+$balance;
            

            if($balance>0)
            {
              if ($amount>$total)
              {
                return FALSE;
              }
              else
              {  
                return TRUE; 
              }
            }
            else
            {
              return FALSE;
            } 
          }
          catch (Exception $e)
          {
            $bitcoincasherror=$e->getMessage();

            \Session::put('bitcoincasherror',$bitcoincasherror);
             return FALSE;
          }          
        }           
      });

       Validator::extend('checklimit', function ($attribute, $value, $parameters, $validator) {

      if($this->currencydetails->name=='BTC')
      {
          $details=Settings::where('key','BTC-reserve-amount-buy')->first();
      }
      if($this->currencydetails->name=='LTC')
      {
          $details=Settings::where('key','LTC-reserve-amount-buy')->first();
      }
      if($this->currencydetails->name=='DOGE')
      {
          $details=Settings::where('key','DOGE-reserve-amount-buy')->first();
      }
      if($this->currencydetails->name=='ETH')
      {
          $details=Settings::where('key','ETH-reserve-amount-buy')->first();
      }
      if($this->currencydetails->name=='BCH')
      {
          $details=Settings::where('key','BCH-reserve-amount-buy')->first();
      }
        $total_amount=0;
        $final_total=0;
        if(count($details)>0)
        {

          $date=$details->updated_at;
        $total_amount=Coinorder::where([['created_at','>=',$date],['type','buy'],['request_coin_id',$this->currencydetails->id]])->whereIn('status',['pending','approve'])->sum('amount');
        /* if($this->currencydetails->name=='BTC')
         {
            $total_amount=Coinorder::where([['created_at','>=',$date],['type','buy'],['request_coin_id',$this->currencydetails->id]])->whereIn('status',['pending','approve'])->sum('amount');
          }
       
         if($this->currencydetails->name=='LTC')
            {
                $total_amount=Coinorder::where([['created_at','>=',$date],['type','buy'],['request_coin_id',$this->currencydetails->id]])->whereIn('status',['pending','approve'])->sum('amount');
            }
            if($this->currencydetails->name=='DOGE')
            {
                $total_amount=Coinorder::where([['created_at','>=',$date],['type','buy'],['request_coin_id',$this->currencydetails->id]])->whereIn('status',['pending','approve'])->sum('amount');
            }
             if($this->currencydetails->name=='ETH')
            {
                $total_amount=Coinorder::where([['created_at','>=',$date],['type','buy'],['request_coin_id',$this->currencydetails->id]])->whereIn('status',['pending','approve'])->sum('amount');
            }*/

          $user_limit=$details->value;

          $final_total=$total_amount+(double)Input::get('amount');

          if($user_limit>0)
          {

                 if ($user_limit<$final_total)
                   {
                        return FALSE;
                   }

                   
                   return TRUE;  
          }
           else
           {
                return TRUE;//For no limit

           }
         }

          return FALSE;
                        
             } );


      Validator::extend('checkbalance', function ($attribute, $value, $parameters, $validator) {

                $user = User::where('id', Auth::id())->with('userprofile')->first();               

                // dd($paymentdetails[0]['currency_id']);

                $userbalance = $this->getUserCurrencyBalance($user, Input::get('from_currency'));
                // dd($userbalance);
                  
                   if (\Session::get('order_amount') > $userbalance)
                   {
                        return FALSE;
                   }
                   return TRUE;            
        }); 


       $rules['amount']='required|numeric|checkamount|checklimit|checkbalance';

      

       if($this->currencydetails->name=='BTC')
         {
                 $rules['amount'].='|checkbalance_btc';
         }
       
       if($this->currencydetails->name=='LTC')
          {
               $rules['amount'].='|checkbalance_ltc';
          }
           if($this->currencydetails->name=='DOGE')
          {
               $rules['amount'].='|checkbalance_doge';
          }
           if($this->currencydetails->name=='ETH')
          {
               $rules['amount'].='|checkbalance_eth';
          }

          if($this->currencydetails->name=='BCH')
          {
               $rules['amount'].='|checkbalance_bch';
          }

      return  $rules;
    }

    public function messages()
    {

       //
       $messages= [
             'amount.checkamount'=>trans('forms.amount_error'),
                    
            
        ];
         $messages['amount.checkbalance_btc']=trans('forms.admin_errorbalance');
          $messages['amount.checkbalance_ltc']=trans('forms.admin_errorbalance');
          $messages['amount.checkbalance_doge']=trans('forms.admin_errorbalance');
          $messages['amount.checkbalance_eth']=trans('forms.admin_errorbalance');
          $messages['amount.checkbalance_bch']=trans('forms.admin_errorbalance');

      if(\Session::get('bitcoinerror')!='')
        {
            $messages['amount.checkbalance_btc']=\Session::get('bitcoinerror');
         
        }
       
        if(\Session::get('ltcerror')!='')
        {
            $messages['amount.checkbalance_ltc']=\Session::get('ltcerror');
         
        }
        if(\Session::get('dogeerror')!='')
        {
            $messages['amount.checkbalance_doge']=\Session::get('dogeerror');
         
        }
            if(\Session::get('etherror')!='')
        {
            $messages['amount.checkbalance_eth']=\Session::get('etherror');
         
        }
       if(\Session::get('bitcoioncasherror')!='')
        {
            $messages['amount.checkbalance_bch']=\Session::get('bitcoincasherror');
         
        }
         $messages['amount.checklimit']=trans('forms.limit_balance');
         $messages['amount.checkbalance']=trans('forms.errorbalance');


          return $messages;
    }

}
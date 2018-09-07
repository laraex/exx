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
use App\CurrencyPair;

class ExternalExchangeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    use CoinProcess;
    public $pair_details;

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
      $id = \Session::get('exchange_pair_id');
      $pair_details = CurrencyPair::find($id);
        //dd($pair_details);
        if(count($pair_details)>0) 
        {
          $this->pair_details = $pair_details;
        }

      Validator::extend('checkamount', function ($attribute, $value, $parameters, $validator) 
      {
        if (Input::get('amount')<=0)
       {
          return FALSE;
       }
          return TRUE;             
    });
    
    Validator::extend('checkuserbtcbalance', function ($attribute, $value, $parameters, $validator) 
    {
      $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');

      $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
   
      $balance=0;
      if(count($user_accounts)>0)
      {
          if($user_accounts->btc_address!='')
            {
                 $balance=$this->getWalletBalance($user_accounts->btc_address);
            }
      }
      \Session::put('bitcoinerror','');

      $amount=sprintf("%.8f",Input::get('amount'));
          $total=0;         
               
      $params = json_decode($pg->params, true);
      $api_key= $params['api_key'];
      $pin= $params['pin'];   
      $to_btc_address= $params['btc_address'];   

      $version = $params['version']; // API version
      $block_io = new BlockIo( $api_key, $pin, $version);
      try{

      $network_fee=$block_io->get_network_fee_estimate(array('amounts' => $amount, 'to_addresses' => $to_btc_address));

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

        $bitcoinerror=$e->getMessage();

        \Session::put('bitcoinerror',$bitcoinerror);
         return FALSE;
      }                
    });

    Validator::extend('checkuserltcbalance', function ($attribute, $value, $parameters, $validator) 
    {
      $pg = $this->getPgDetailsByGatewayName('ltc_blockio');

      $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
   
      $balance=0;

      if(count($user_accounts)>0)
      {
        if($user_accounts->ltc_address!='')
        {
          $balance = $this->getLTCWalletBalance($user_accounts->ltc_address);
        }
      }
      \Session::put('litecoinerror','');

      $amount=sprintf("%.8f",Input::get('amount'));
          $total=0;         
               
      $params = json_decode($pg->params, true);
      $api_key= $params['api_key'];
      $pin= $params['pin'];   
      $to_ltc_address= $params['ltc_address'];   

      $version = $params['version']; // API version
      $block_io = new BlockIo( $api_key, $pin, $version);
      try{

      $network_fee=$block_io->get_network_fee_estimate(array('amounts' => $amount, 'to_addresses' => $to_ltc_address));

      $total = $balance+($network_fee->data->estimated_network_fee);

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

      \Session::put('litecoinerror',$bitcoinerror);
       return FALSE;
      }
    });

    Validator::extend('checkuserdogebalance', function ($attribute, $value, $parameters, $validator) 
    {
      $pg = $this->getPgDetailsByGatewayName('dogecoin_blockio');

      $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
   
      $balance=0;
      if(count($user_accounts)>0)
      {
        if($user_accounts->doge_address!='')
        {
          $balance=$this->getDOGEWalletBalance($user_accounts->doge_address);
        }
      }
      \Session::put('dogecoinerror','');

      $amount=sprintf("%.8f",Input::get('amount'));
      $total=0;         
                 
      $params = json_decode($pg->params, true);
      $api_key= $params['api_key'];
      $pin= $params['pin'];   
      $to_doge_address= $params['doge_address'];   

      $version = $params['version']; // API version
      $block_io = new BlockIo( $api_key, $pin, $version);
      try
      {
        $network_fee=$block_io->get_network_fee_estimate(array('amounts' => $amount, 'to_addresses' => $to_doge_address));

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
        $dogecoinerror=$e->getMessage();

        \Session::put('dogecoinerror',$dogecoinerror);
         return FALSE;
      }
    });

    Validator::extend('checkfromaddress', function ($attribute, $value, $parameters, $validator) 
    {
        //dd('df');
        $id=\Session::get('exchange_pair_id');
        $pair_details = CurrencyPair::find($id);
        //dd($pair_details);
        // \Session::put('btc_addresserror','');
        // \Session::put('ltc_addresserror','');
        // \Session::put('doge_addresserror','');

        $pg_btc = $this->getPgDetailsByGatewayName('bitcoin_blockio');
        $pg_ltc = $this->getPgDetailsByGatewayName('ltc_blockio');
        $pg_doge = $this->getPgDetailsByGatewayName('dogecoin_blockio');

        if($pair_details->fromcurrency->name == 'BTC')
        {
          //dd('dlkfj');
          $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(),$pg_btc->id)->count();
          //\Session::put('btc_addresserror',trans('forms.btc_address_error'));
        }
        
        else if($pair_details->fromcurrency->name == 'LTC')
        {
         //dd('skdfjd');
          $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(),$pg_ltc->id)->count();
          //\Session::put('ltc_addresserror',trans('forms.ltc_address_error'));
        }

        else if($pair_details->fromcurrency->name == 'DOGE')
        {
          //dd('djfkjg');
          $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(),$pg_doge->id)->count();
          //\Session::put('doge_addresserror',trans('forms.doge_address_error'));
        }

          if($user_accounts==0)
          {
            //dd('dlkjf');
            return FALSE;
          }   
            return TRUE;
    });

    Validator::extend('checkaddress', function ($attribute, $value, $parameters, $validator) 
    {
      //dd('djf');
        $id=\Session::get('exchange_pair_id');
        $pair_details = CurrencyPair::find($id);
        //dd($pair_details);
        // \Session::put('btcaddress_error','');
        // \Session::put('ltcaddress_error','');
        // \Session::put('dogeaddress_error','');

        $pg_btc = $this->getPgDetailsByGatewayName('bitcoin_blockio');
        $pg_ltc = $this->getPgDetailsByGatewayName('ltc_blockio');
        $pg_doge = $this->getPgDetailsByGatewayName('dogecoin_blockio');
//dd($pg_doge);
//dd($pair_details->tocurrency->name);
        if($pair_details->fromcurrency->name == 'BTC')
        {
          //dd('btc');
          $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(),$pg_btc->id)->count();
          //\Session::put('btcaddress_error',trans('forms.btc_address_error'));
        }
        
        else if($pair_details->fromcurrency->name == 'LTC')
        {
        // dd('ltc');
          $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(),$pg_ltc->id)->count();
          //\Session::put('ltcaddress_error',trans('forms.ltc_address_error'));
        }

        else if($pair_details->fromcurrency->name == 'DOGE')
        {
          //dd('doge');
          $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(),$pg_doge->id)->count();
          //dd($user_accounts);
          //\Session::put('dogeaddress_error',trans('forms.doge_address_error'));
        }

        else if($pair_details->tocurrency->name == 'BTC')
        {
          //dd('btc');
          $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(),$pg_btc->id)->count();
          //\Session::put('btcaddress_error',trans('forms.btc_address_error'));
        }
        
        else if($pair_details->tocurrency->name == 'LTC')
        {
         //dd('ltc');
          $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(),$pg_ltc->id)->count();
          //\Session::put('ltcaddress_error',trans('forms.ltc_address_error'));
        }

        else if($pair_details->tocurrency->name == 'DOGE')
        {
         // dd('doge');
          $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(),$pg_doge->id)->count();
          //dd($user_accounts);
          //\Session::put('dogeaddress_error',trans('forms.doge_address_error'));
        }

          if($user_accounts == 0)
          {
            //dd('dlkjf');
            return FALSE;
          }   
            return TRUE;
      });

    Validator::extend('checkadminbalance', function ($attribute, $value, $parameters, $validator) 
    {
      //dd('dskf');
      $amount = sprintf("%.8f",\Session::get('external_exchange_final_amount'));
// dd($amount);
      $id=\Session::get('exchange_pair_id');
      $pair_details = CurrencyPair::find($id);
//dd($pair_details);
      $pg_btc = $this->getPgDetailsByGatewayName('bitcoin_blockio');
      $pg_ltc = $this->getPgDetailsByGatewayName('ltc_blockio');
      $pg_doge = $this->getPgDetailsByGatewayName('dogecoin_blockio');

      $to_address='';
      $balance = 0;

      if($pair_details->tocurrency->name=='BTC')
      {
        $params = json_decode($pg_btc->params, true);
        $api_key= $params['api_key'];
        $pin = $params['pin'];   
        $from_address = $params['btc_address'];
        $version = $params['version'];   
        $balance = $this->getWalletBalance($from_address);
        //dd($balance);
        $block_io = new BlockIo( $api_key, $pin, $version);

        $userbtc_accounts = Userpayaccounts::getAccountDetails(Auth::id(),$pg_btc->id)->first();

          if(count($userbtc_accounts)>0)
          {
            $to_address = $userbtc_accounts->btc_address;
          }
        }

        else if($pair_details->tocurrency->name=='LTC')
        {
          $params = json_decode($pg_ltc->params, true);
          $api_key = $params['api_key'];
          $pin = $params['pin'];   
          $from_address = $params['ltc_address'];  
          $version = $params['version']; 
          $balance = $this->getLTCWalletBalance($from_address);
          //dd($balance);
          $block_io = new BlockIo( $api_key, $pin, $version);

          $userltc_accounts = Userpayaccounts::getAccountDetails(Auth::id(),$pg_ltc->id)->first();
 
            if(count($userltc_accounts)>0)
            {
              $to_address = $userltc_accounts->ltc_address;
            }
          }
        
        else if($pair_details->tocurrency->name=='DOGE')
        {
          $params = json_decode($pg_doge->params, true);   
          $api_key = $params['api_key'];
          $pin = $params['pin'];   
          $from_address = $params['doge_address'];
          $version = $params['version'];   
          $balance = $this->getDOGEWalletBalance($from_address); 
          //dd($balance);
          $block_io = new BlockIo( $api_key, $pin, $version);

          $userdoge_accounts = Userpayaccounts::getAccountDetails(Auth::id(),$pg_doge->id)->first();

            if(count($userdoge_accounts)>0)
            {
              $to_address = $userdoge_accounts->doge_address;
            }
        }     
        try
        {
          $network_fee = $block_io->get_network_fee_estimate(array('amounts' => $amount, 'to_addresses' => $to_address));
          
          $total = $balance+($network_fee->data->estimated_network_fee);
// echo "$balance <br>$amount <br> $total";exit();
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
          $coinerror=$e->getMessage();
//dd($coinerror);
          \Session::put('dogecoinerror',$coinerror);
           return FALSE;
        }
      });


    $id=\Session::get('exchange_pair_id');
    $pair_details = CurrencyPair::find($id);

    $rules=[
    'amount'=>'sometimes|required|numeric|checkfromaddress|checkamount',
     ];

    if(count($pair_details)>0)
    {
      if(($pair_details->min_amount>=0)&&($pair_details->max_amount>=0))
      {
        $rules['amount']='sometimes|numeric|checkfromaddress|checkamount|min:'.$pair_details->min_amount.'|max:'.$pair_details->max_amount;
        if ($pair_details->type == 'fiat') 
        {
          if($pair_details->fromcurrency->name=='BTC')
          {
            $rules['amount'].='|checkuserbtcbalance';
          }
          
          if($pair_details->fromcurrency->name=='LTC')
          {
            $rules['amount'].='|checkuserltcbalance';
          }

          if($pair_details->fromcurrency->name=='LTC')
          {
            $rules['amount'].='|checkuserdogebalance';
          }
        }

        $rules['amount'].='|required';

        $rules['exchange_amount']='required';
        if ($pair_details->type == 'crypto') 
        {
          $rules['exchange_amount']='required|checkaddress|checkadminbalance';
        }
      }
    }
    //dd($rules);
    return  $rules;
  }

  public function messages()
  {
    $messages = [
      'amount.checkamount'=>trans('forms.amount_error'),
      'exchange_amount.checkadminbalance' => trans('forms.admin_errorbalance'),   

    ];

    if(\Session::get('bitcoinerror')!='')
    {
        $messages['amount.checkuserbtcbalance'] = \Session::get('bitcoinerror');
     
    }
    if(\Session::get('litecoinerror')!='')
    {
        $messages['amount.checkuserltcbalance'] = \Session::get('litecoinerror');
     
    }

    if(\Session::get('dogecoinerror')!='')
    {
        $messages['amount.checkuserltcbalance'] = \Session::get('dogecoinerror');
     
    }


//sowmi
      if($this->pair_details->fromcurrency->name=='BTC')
      {
        $messages['amount.checkfromaddress']=trans('forms.btc_address_error');
      }

      if($this->pair_details->fromcurrency->name=='LTC')
      {
        $messages['amount.checkfromaddress']=trans('forms.ltc_address_error');
      }

      if($this->pair_details->fromcurrency->name=='DOGE')
      {
        $messages['amount.checkfromaddress']=trans('forms.doge_address_error');
      }

      if($this->pair_details->tocurrency->name=='BTC')
      {
        //echo \Session::get('btcaddress_error');
        $messages['exchange_amount.checkaddress'] = trans('forms.btc_address_error');
      }

      if($this->pair_details->tocurrency->name == 'LTC')
      {
        //echo \Session::get('ltcaddress_error');
        $messages['exchange_amount.checkaddress'] = trans('forms.ltc_address_error');
      }

     if($this->pair_details->tocurrency->name == 'DOGE')
      {
        //echo \Session::get('dogeaddress_error');
        $messages['exchange_amount.checkaddress'] = trans('forms.doge_address_error');
      }



    else
    {
      $messages['amount.checkuserbtcbalance'] = trans('forms.errorbalance');
      $messages['amount.checkuserltcbalance'] = trans('forms.errorbalance');
      $messages['amount.checkuserdogebalance'] = trans('forms.errorbalance');
    }
      return $messages;
  }

}
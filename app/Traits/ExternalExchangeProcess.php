<?php

namespace App\Traits;
use App\ExternalExchange;
use App\CurrencyPair;
use App\Traits\Common;
use App\Classes\block_io\BlockIo;
use App\Models\Userpayaccounts;
use Exception;
use App\Traits\TransactionProcess;

trait ExternalExchangeProcess 
{
  //use TransactionProcess;
  public function createExchange($request,$user_id)
  {
    $amount = sprintf("%.8f", $request->external_exchange_amount);
    try
    {
      $coin=$this->getCurrencyNameByID($request->from_currency_id);
//dd($coin);
      if($coin=='BTC')
      {
        //dd('dfg');
        $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
        $user_accounts = Userpayaccounts::getAccountDetails($user_id,$pg->id)->first();
        $btc_address = $user_accounts->btc_address;

        $params = json_decode($pg->params, true);
        $api_key= $params['api_key'];
        $pin= $params['pin'];   
        $to_btc_address= $params['btc_address'];   

        $version = $params['version']; // API version
        $block_io = new BlockIo( $api_key, $pin, $version);

        $response = $block_io->withdraw_from_addresses(array('amounts' => $amount, 'from_addresses' =>$btc_address,'to_addresses' =>$to_btc_address));
        //dd($response);
      }

        if($coin=='LTC')
        {
          $pg = $this->getPgDetailsByGatewayName('ltc_blockio');
          $user_accounts = Userpayaccounts::getAccountDetails($user_id,$pg->id)->first();
          $ltc_address = $user_accounts->ltc_address;
     
          $params = json_decode($pg->params, true);
          $api_key= $params['api_key'];
          $pin= $params['pin'];   
          $to_ltc_address= $params['ltc_address'];   

          $version = $params['version']; // API version
          $block_io = new BlockIo( $api_key, $pin, $version);

          $response = $block_io->withdraw_from_addresses(array('amounts' => $amount, 'from_addresses' =>$ltc_address,'to_addresses' =>$to_ltc_address));
        }

        if($coin=='DOGE')
        {
          $pg = $this->getPgDetailsByGatewayName('dogecoin_blockio');
          $user_accounts=Userpayaccounts::getAccountDetails($user_id,$pg->id)->first();
          $doge_address=$user_accounts->doge_address;
     
          $params = json_decode($pg->params, true);
          $api_key= $params['api_key'];
          $pin= $params['pin'];   
          $to_doge_address= $params['doge_address'];   

          $version = $params['version']; // API version
          $block_io = new BlockIo( $api_key, $pin, $version);

          $response = $block_io->withdraw_from_addresses(array('amounts' => $amount, 'from_addresses' =>$doge_address,'to_addresses' =>$to_doge_address));
        }


        $create = [                                                           
          'user_id'=>$user_id,
          'from_currency_id'=>$request->from_currency_id,
          'to_currency_id'=>$request->to_currency_id,
          'amount'=>$request->external_exchange_amount,                                  
          'total_exchange_amount'=>$request->external_exchange_final_amount,
          'exchange_rate_variant'=>$request->exchange_rate_variant,           
          'fee'=>$request->fee,                                   
          'base_fee'=>$request->base_fee,                                   
          'fee_total'=>$request->fee_total,                                   
          'transaction_id'=>$request->transaction_id,
          'response'=>json_encode($response), 
          'exchangerate_per'=>$request->exchangerate_per,                      
          'exchangerate_variant'=>$request->exchangerate_variant, 
          'type' =>  $request->type,             
        ];
// dd($create);
        $exchange = ExternalExchange::create($create);
//dd($exchange);
        if ($exchange->type == 'fiat') 
        { 
          $comment = "External Exchange";       
          $accounting_code = 'external-exchange-credit';
          $accounting_code = $this->getAccountingCode($accounting_code);
          $account_id = $this->getAccountID($user_id,$request->to_currency_id);
          $transaction = $this->makeTransaction($account_id,$request->external_exchange_final_amount,"credit","1","externalexchange",$accounting_code,$comment,'','',$exchange->id,get_class($exchange));
        }
          
        if ($exchange->type == 'crypto') 
        {
          $currencypair_id = CurrencyPair::where([['from_currency_id',$request->from_currency_id],['to_currency_id',$request->to_currency_id]])->first();

          $to_response = $this->createCryptoSendCoinTransaction($request->external_exchange_final_amount,$user_id,$currencypair_id->id);

          $update = [
            'to_response' => json_encode($to_response), 
          ];

          ExternalExchange::where('id',$exchange->id)->update($update);
        }

        $this->createAdminFee($exchange);

        \Session::put('successmessage','Coin Exchange Successfully');
          
        return $exchange;
      }
      catch (Exception $e) 
      { 
        //dd($e->getMessage());
           // if an exception happened in the try block above 
         \Session::put('failmessage',$e->getMessage());
      }
      return true;
    }
    
    public function sessionToExchangeRequest()
    {
      $array = [
        "external_exchange_amount"=>\Session::get('external_exchange_amount'),
        "external_exchange_final_amount"=>\Session::get('external_exchange_final_amount'),
        "exchange_rate_variant"=>\Session::get('external_exchange_details')->exchange_rate_variant,
        "fee"=>\Session::get('external_exchange_details')->fee,
        "base_fee"=>\Session::get('external_exchange_details')->base_fee,
        "from_currency_id"=>\Session::get('external_exchange_details')->from_currency_id,
        "to_currency_id"=>\Session::get('external_exchange_details')->to_currency_id,
        "transaction_id"=>\Session::get('transaction_id'),
        "fee_total"=>\Session::get('external_exchange_fee_total'),
        "exchangerate_per"=>\Session::get('exchangerate_per'),
        "exchangerate_variant"=>\Session::get('exchangerate_variant'),
        "type"=>\Session::get('external_exchange_details')->type,
      ];

      \Session::forget('external_exchange_amount'); 
      \Session::forget('external_exchange_final_amount'); 
      
      return $array;
    }

    public  function getWallet($user_id)
    {
      $pg_btc = $this->getPgDetailsByGatewayName('bitcoin_blockio');
      $balance_btc=0;
      $user_accounts_btc=Userpayaccounts::getAccountDetails($user_id,$pg_btc->id)->first();
      if(count($user_accounts_btc)>0)
      {
          if($user_accounts_btc->btc_address!='')
            {
                 $balance_btc=$this->getWalletBalance($user_accounts_btc->btc_address);
            }
      }
     
      //LTC
      $pg_ltc = $this->getPgDetailsByGatewayName('ltc_blockio');
      $balance_ltc=0;
      $user_accounts_ltc=Userpayaccounts::getAccountDetails($user_id,$pg_ltc->id)->first();
      if(count($user_accounts_ltc)>0)
      {
          if($user_accounts_ltc->ltc_address!='')
            {
                 $balance_ltc=$this->getLTCWalletBalance($user_accounts_ltc->ltc_address);
            }
      }
      $btc = $this->getCurrencyDetailsByName('BTC');
      $ltc = $this->getCurrencyDetailsByName('LTC');

      $array=array();

      $array = [   
        'balance_btc' => $balance_btc , 
        'balance_ltc' => $balance_ltc,
        'btc_image' => url($btc->image),
        'ltc_image'=>url($ltc->image),
        'btc_token'=>$btc->token,
        'ltc_token'=>$ltc->token,
      ];

      return $array;
    }

    public function createAdminFee($exchange)
    {
      $request_json = array('request_amount' => $exchange->amount, 'receive_amount' => $exchange->total_exchange_amount,'transaction_number' => $exchange->transaction_id,'userid'=>$exchange->user_id);
      $accounting_code='external-exchange-fee';

      $accounting_code=$this->getAccountingCode($accounting_code);
      //dd($accounting_code);
      $account_id=$this->getAccountID(ADMIN_ID,$exchange->to_currency_id);
      $fee=$exchange->fee_total;
      $comment="External Exchange Currency";

      if($fee>0)
      {
        $transaction=$this->makeTransaction($account_id,$fee,"credit","1","externalexchangefee",$accounting_code,$comment,$request_json,'',$exchange->id,get_class($exchange));
        return $transaction;
      }   
    }

    public function createCryptoAdminFee($exchange)
    {
      $request_json = array('request_amount' => $exchange->amount, 'receive_amount' => $exchange->total_exchange_amount,'transaction_number' => $exchange->transaction_id,'userid'=>$exchange->user_id);

      $accounting_code = 'crypto-exchange-fee';

      $accounting_code = $this->getAccountingCode($accounting_code);

      $account_id = $this->getAccountID(ADMIN_ID,$exchange->to_currency_id);
      $fee = $exchange->fee_total;
      $comment = trans('comment.crypto_exchange_currency');

      if($fee>0)
      {
        $transaction = $this->makeTransaction($account_id,$fee,"credit","1","cryptoexchangefee",$accounting_code,$comment,$request_json,'',$exchange->id,get_class($exchange));
//dd($transaction);
      return $transaction;
      }   
    }
//sowmi
    public function createCryptoSendCoinTransaction($amount,$user_id,$currencypair_id)
    {
      $amount=sprintf("%.8f",$amount);

      $pair_details = CurrencyPair::find($currencypair_id);

      $pg_btc = $this->getPgDetailsByGatewayName('bitcoin_blockio');
      $pg_ltc = $this->getPgDetailsByGatewayName('ltc_blockio');
      $pg_doge = $this->getPgDetailsByGatewayName('dogecoin_blockio');

      $to_address = '';
      $balance = 0;

      if($pair_details->tocurrency->name == 'BTC')
      {
          $params = json_decode($pg_btc->params, true);
          $api_key= $params['api_key'];
          $pin = $params['pin'];   
          $from_address = $params['btc_address'];
          $version = $params['version'];   
          $balance = $this->getWalletBalance($from_address);
          $block_io = new BlockIo( $api_key, $pin, $version);

          $userbtc_accounts = Userpayaccounts::getAccountDetails($user_id,$pg_btc->id)->first();
 
            if(count($userbtc_accounts)>0)
            {
              $to_address = $userbtc_accounts->btc_address;
            }
        }

      else if($pair_details->tocurrency->name == 'LTC')
      {
        $params = json_decode($pg_ltc->params, true);
        $api_key = $params['api_key'];
        $pin = $params['pin'];   
        $from_address = $params['ltc_address'];  
        $version = $params['version']; 
        $balance = $this->getLTCWalletBalance($from_address);
        $block_io = new BlockIo( $api_key, $pin, $version);

        $userltc_accounts = Userpayaccounts::getAccountDetails($user_id,$pg_ltc->id)->first();
 
          if(count($userltc_accounts)>0)
          {
            $to_address = $userltc_accounts->ltc_address;
          }
        }
          
      else if($pair_details->tocurrency->name == 'DOGE')
      {
        $params = json_decode($pg_doge->params, true);   
        $api_key = $params['api_key'];
        $pin = $params['pin'];   
        $from_address = $params['doge_address'];
        $version = $params['version'];   
        $balance = $this->getDOGEWalletBalance($from_address); 
         $block_io = new BlockIo( $api_key, $pin, $version);

        $userdoge_accounts = Userpayaccounts::getAccountDetails($user_id,$pg_doge->id)->first();

          if(count($userdoge_accounts)>0)
          {
            $to_address = $userdoge_accounts->doge_address;
          }
      }

      try
      {
       $response = $block_io->withdraw_from_addresses(array('amounts' => $amount, 'from_addresses' =>$from_address,'to_addresses' =>$to_address));
       //dd($response);
      }
      catch (Exception $e)
      {
         //dd($e->getMessage());
               // if an exception happened in the try block above 
           //  \Session::put('failmessage',$e->getMessage());

      }
      return $response;
    }
 }
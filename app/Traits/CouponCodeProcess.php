<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Traits\Common;
use App\Traits\TransactionProcess;
use App\CouponCode;
use App\Classes\block_io\BlockIo;
use Exception;
use App\Models\CouponCodeTransaction;
use App\Models\Userpayaccounts;

trait CouponCodeProcess 
{
  use Common,TransactionProcess;

  public function ApplyCouponCode($couponcode,$user_id,$amount)
  {
    $create = [
      "user_id" => $user_id,
      "couponcode_id" => $couponcode->id,
      "currency_id" => $couponcode->currency_id,
    ];

    $couponcode_store = CouponCodeTransaction::create($create);

    $currencyname = $this->getCurrencyNameByID($couponcode->currency_id);

    if ($currencyname == 'BTC') 
    {
      //dd('sdkjf');
      $response = $this->bitcoin_transfer($amount,$user_id);

      $update = [
        "response" => json_encode($response),
      ];

      $coupon = CouponCodeTransaction::where('id',$couponcode_store->id)->update($update);
      //dd($coupon);
    }

    else if ($currencyname == 'LTC') 
    {
      $response = $this->litecoin_transfer($amount,$user_id);

      $update = [
        "response" => json_encode($response),
      ];

      CouponCodeTransaction::where('id',$couponcode_store->id)->update($update);
    }

    else if ($currencyname == 'DOGE') 
    {
      $response = $this->dogecoin_transfer($amount,$user_id);

      $update = [
        "response" => json_encode($response),
      ];

      CouponCodeTransaction::where('id',$couponcode_store->id)->update($update);
    }

    else
    {
      $this->CreateCouponCodeCreditTransaction($couponcode,$user_id,$amount);
    }
  }

  public function CreateCouponCodeCreditTransaction($couponcode,$user_id,$amount)
  {
    $accounting_code = 'PrimaryCoin-admin-user-credit-couponcode';
    $creditamount = $amount;
    $accounting_code = $this->getAccountingCode($accounting_code);
    $account_id = $this->getAccountID($user_id,$couponcode->currency_id);
    $comment = "Apply Coupon Code";
    $transaction = $this->makeTransaction($account_id,$creditamount,"credit","1","couponcode",$accounting_code,$comment,'','',$couponcode->id,get_class($couponcode));
    //dd($transaction);
    return $transaction;
    }

    public function bitcoin_transfer($amount,$user_id)
    {
      //dd('dfjg');
      $response='';
      $amount = sprintf("%.8f", $amount);
//dd($amount);
      try
      {     
        $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
        $user_accounts = Userpayaccounts::getAccountDetails($user_id,$pg->id)->first();
        $user_btc_address=$user_accounts->btc_address;  

        $params = json_decode($pg->params, true);
        $api_key= $params['api_key'];
        $pin = $params['pin'];   
        $btc_address = $params['btc_address']; 
// dd($btc_address);
        $from_address='';
        $to_address='';

        $to_address = $user_btc_address;
        $from_address = $btc_address;
        //dd($from_address);
        $version = $params['version']; // API version
        $block_io = new BlockIo( $api_key, $pin, $version);

        $response=$block_io->withdraw_from_addresses(array('amounts' => $amount, 'from_addresses' =>$from_address,'to_addresses' =>$to_address));
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


    public function litecoin_transfer($amount,$user_id)
    {
      $response='';
      $amount=sprintf("%.8f", $amount);
      //dd($amount);
      try
      {
        $pg = $this->getPgDetailsByGatewayName('ltc_blockio');
        $user_accounts = Userpayaccounts::getAccountDetails($user_id,$pg->id)->first();
        $user_ltc_address=$user_accounts->ltc_address;  

        $params = json_decode($pg->params, true);
        $api_key= $params['api_key'];
        $pin= $params['pin'];   
        $ltc_address= $params['ltc_address']; 

        $from_address='';
        $to_address='';

        $to_address = $user_ltc_address;
        $from_address = $ltc_address;
        
        $version = $params['version']; // API version
        $block_io = new BlockIo( $api_key, $pin, $version);

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

    public function dogecoin_transfer($amount,$user_id)
    {
      $response='';
      $amount=sprintf("%.8f", $amount);
      //dd($amount);
      try
      {     
        $pg = $this->getPgDetailsByGatewayName('dogecoin_blockio');
        $user_accounts = Userpayaccounts::getAccountDetails($user_id,$pg->id)->first();
        $user_doge_address = $user_accounts->doge_address;  

        $params = json_decode($pg->params, true);
        $api_key = $params['api_key'];
        $pin = $params['pin'];   
        $doge_address = $params['doge_address']; 

        $from_address='';
        $to_address='';

        $to_address=$user_doge_address;
        $from_address=$doge_address;
        
        $version = $params['version']; // API version
        $block_io = new BlockIo( $api_key, $pin, $version);

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
    public function getCouponAmount($couponcode)
    {
        $totalamt=0;
       if($couponcode->coupon_type == 'flat')
        {
            $totalamt = $couponcode->amount;
        }

        if($couponcode->coupon_type == 'percentage')
        {
            $percentage = $couponcode->amount;

            $totalamt = $percentage/100;
        }
        return $totalamt;
    }

 }
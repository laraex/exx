<?php

namespace App\Traits;
use App\User;
use Exception;
use App\Http\Controllers\CryptoPayment\CryptoPaymentBase;
use App\Models\Userpayaccounts;
use App\Models\Transaction;
trait TradeBuyProcess
{

public function createTradeBuyDebit($trade)
   {
        try
        {  
   
          

           $request_json = array('volume'=>$trade->quantity,'amount'=>$trade->amount, 'buy_amount'=>$trade->amount*$trade->quantity, 'fee' =>$trade->fee,'fee_total'=>$trade->fee_total,'net_amount'=>$trade->total_amount,'order_id'=>$trade->id,'userid'=>$trade->user_id,'from_currency'=>$trade->fromcurrency->name,'to_currency'=>$trade->tocurrency->name);
              
          

            $accounting_code = "trade-buy-debit"; 

           
            $accounting_code=$this->getAccountingCode($accounting_code);


            $comment = "Buy " . $trade->fromcurrency->name . "Debit Wallet";

            $array=array();
            $balance_before=Transaction::BalanceBefore($trade->user_id,$trade->to_coin_id)->latest()->first();

            $balance_before= $balance_before->balance_after;
            $balance_after= $balance_before-$trade->total_amount;
       
            $transaction=$this->createTransaction($trade->user_id,$trade->to_coin_id,$trade->total_amount,"debit","approve","buytrade",$accounting_code,$comment,json_encode($request_json),'',$trade->id,get_class($trade),$balance_before,$balance_after,"NULL","NULL", $array);
      
            
        
          return true;
         }
        catch(Exception $e)
        {
             throw new Exception($e->getMessage());

        }
  
}


  //ImpBlockchain 
   /*public function createTradeBuyDebit($trade)
   {


        try
        {
            $response=[];

        if($trade->tocurrency->type=="fiat") {
   
           // $total=$trade->amount*$trade->volume;
           // $fee_total=($trade->fee/100)*$total;

           $request_json = array('volume'=>$trade->volume,'amount'=>$trade->amount, 'buy_amount'=>$trade->amount*$trade->volume, 'fee' =>$trade->fee,'fee_total'=>$trade->fee_total,'net_amount'=>$trade->total_amount,'order_id'=>$trade->id,'userid'=>$trade->user_id,'from_currency'=>$trade->fromcurrency->name,'to_currency'=>$trade->tocurrency->name);
              
           $account_id=$this->getAccountID($trade->user_id,$trade->to_coin_id);

            $accounting_code = "trade-buy-debit"; 

           
            $accounting_code=$this->getAccountingCode($accounting_code);


            $comment = "Buy " . $trade->fromcurrency->name . "Debit Wallet";

            $transaction = $this->makeTransaction($account_id, $trade->total_amount, "debit", "1", "buytrade", $accounting_code, $comment, $request_json,'', $trade->id, get_class($trade));
       }

       if($trade->tocurrency->type=="crypto"){


            $comment = "Trade Buy";
            $comment_to = "Trade Buy";
            $send_array['amount'] = $trade->total_amount;
             $send_array['comment'] = $comment;
             $send_array['comment_to'] =  $comment_to;
 
         $user_accounts = Userpayaccounts::where('user_id', $trade->user_id)->where('currency_id', $trade->tocurrency->id)->first();

               // dd($user_accounts);

        if ($trade->tocurrency->name == 'BTC') {

      
            $send_array['from_address'] = $user_accounts->btc_address;
            $send_array['fromaccount'] =  $user_accounts->btc_label;

            $response = CryptoPaymentBase::crypto_sendBTCToAdmin($send_array);

          
        } else if ($trade->tocurrency->name == 'LTC') {
        
            
            $send_array['from_address'] = $user_accounts->ltc_address;
              $send_array['fromaccount'] =  $user_accounts->ltc_label;
            $response = CryptoPaymentBase::crypto_sendLTCToAdmin($send_array);

          
        } else if ($trade->tocurrency->name == 'ETH') {
             
            $send_array['from_address'] = $user_accounts->eth_address;
        
            $send_array['passphrase'] = $user_accounts->eth_passphrase;
            $response = CryptoPaymentBase::crypto_sendETHToAdmin($send_array);

         
          
        } else if ($trade->tocurrency->name == 'BCH') {
           //Bitcoind   
         
    
            $send_array['from_address'] = $user_accounts->bch_address;
            $send_array['fromaccount'] = $user_accounts->bch_label;
            $response = CryptoPaymentBase::crypto_sendBCHToAdmin($send_array);
            
         
          }
          if(count($response)>0)
          {
            $this->updateResponse($response, $trade->id);
          }
            
        }
          return true;
    }
        catch(Exception $e)
        {
           // dd($e->getMessage());
            return false;

        }
  
}*/
}
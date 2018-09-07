<?php

namespace App\Traits;


use Carbon\Carbon;
use App\Coinorder;
use App\Traits\Common;
use App\Traits\TransactionProcess;
use App\Classes\block_io\BlockIo;
use Exception;
use App\Models\Userpayaccounts;
use App\Http\Controllers\CryptoPayment\CryptoPaymentBase;


trait CoinBuyProcess {
    
    public function approveBuyCoin($request,$id,$via)
    {
             $order = Coinorder::where([['id', $id],['status','pending']])->first();  
             $currency_name=$this->getCurrencyname($order->request_coin_id);
             $type=$order->type;

             if(count($order)>0)
             {
                    $update=[
                                'receive_amount'=>$order->order_amount,                                
                                'status'=>'approve',
                                'approve_at'=>carbon::now(),
                                'comments_approve'=>$request->comment,
                                'process_via'=>$via
                                     
                            ];
                  

                    Coinorder::where('id',$id)->update($update);

                   $coinorder = Coinorder::where('id', $id)->first();  
                   
            }


           
      

    

            // $accounting_code_commission=$currency_name.'-'.$to_currency_name.'-commission-'.$type;  
             $accounting_code_commission=$currency_name.'-commission-'.$type;  

             $this->CreateBuyCoinDebitWallet($coinorder,$type,$currency_name);
             $this->CreateBuyCoinAdminCommission($coinorder,$accounting_code_commission,$currency_name);

             $this->CreateOrderTransaction($coinorder,'buy',$currency_name);


             $this->CreateCoinSendTransaction($coinorder,$currency_name);

        return true;

    }

    public function CreateBuyCoinDebitWallet($coinorder,$type,$currency_name)
    {
        

       
        $accounting_code=$currency_name.'-'.$type.'-debit-wallet';
         

        $request_json = array('request_amount' => $coinorder->amount, 'receive_amount' => $coinorder->order_amount,'transaction_number' => $coinorder->transaction_id,'order_id'=>$coinorder->id,'userid'=>$coinorder->from_user_id);
       
         $accounting_code=$this->getAccountingCode($accounting_code);

         $account_id=$this->getAccountID($coinorder->from_user_id,$coinorder->from_currency);
       
         
       
        $comment="Buy Coin Debit Wallet";

    

        $transaction=$this->makeTransaction($account_id,$coinorder->order_amount,"debit","1","buycoin",$accounting_code,$comment,$request_json,'',$coinorder->id,get_class($coinorder));

         return $transaction;
     
   
        return true;
    }

    public function CreateBuyCoinAdminCommission($coinorder,$accounting_code,$currency_name)
    {
        

        $admincommission=$coinorder->order_amount-$coinorder->to_amount;
        if($coinorder->commission>0)
        {


        $request_json = array('request_amount' => $coinorder->amount, 'receive_amount' => $coinorder->order_amount,'transaction_number' => $coinorder->transaction_id,'order_id'=>$coinorder->id,'userid'=>$coinorder->from_user_id);
       
        $accounting_code=$this->getAccountingCode($accounting_code);

         $account_id=$this->getAccountID(ADMIN_ID,$coinorder->from_currency);
         $admincommission=$coinorder->order_amount-$coinorder->to_amount;

         
        $response_json = array('receive_amount' => $coinorder->receive_amount);
        $comment="Buy Coin";
 

        if($admincommission>0)
        {


        $transaction=$this->makeTransaction($account_id,$admincommission,"credit","1","buycoin",$accounting_code,$comment,$request_json,$response_json,$coinorder->id,get_class($coinorder));

         return $transaction;
        }   
        }  
        return true;
    }
    
      
      public function CreateCoinSendTransaction($coinorder,$currency_name)
     {

            $amount=sprintf("%.8f", $coinorder->amount);
        $response=[];
        try
        {
          
        
              //Bitcoind   
               
              $comment="Buy Coin";
              $comment_to="Buy Coin";         
              $send_array['amount']=$amount;   
              $send_array['comment']=$comment;
              $send_array['comment_to']=$comment_to;       
        
          
            if($currency_name=='BTC')
            {
                $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
                $user_accounts=Userpayaccounts::getAccountDetails($coinorder->from_user_id,$pg->id)->first();
                $user_address=$user_accounts->btc_address;
                $send_array['to_address']=$user_address;
                $response= CryptoPaymentBase::crypto_sendBTCToUserFromAdmin($send_array);  
          
            }

            if($currency_name=='LTC')
            {   
              
                $pg = $this->getPgDetailsByGatewayName('ltc_blockio');         
                $user_accounts=Userpayaccounts::getAccountDetails($coinorder->from_user_id,$pg->id)->first();
                $user_address=$user_accounts->ltc_address;
                $send_array['to_address']=$user_address;
                $response= CryptoPaymentBase::crypto_sendLTCToUserFromAdmin($send_array);    
           
            }

            if($currency_name=='DOGE')
            {  
             $user_accounts=Userpayaccounts::getAccountDetails($coinorder->from_user_id,$pg->id)->first(); 
             $pg = $this->getPgDetailsByGatewayName('dogecoin_blockio');      

             $params = json_decode($pg->params, true);
              $api_key= $params['api_key'];
             $pin= $params['pin'];   
                  $user_address=$user_accounts->doge_address;
                $to_address= $params['doge_address'];
                 $version = $params['version']; // API version
             $block_io = new BlockIo( $api_key, $pin, $version);

             $response=$block_io->withdraw_from_addresses(array('amounts' => $amount, 'from_addresses' =>$to_address,'to_addresses' =>$user_address));
                
             }
            
          
            if($currency_name=='ETH')
            {   
                $pg = $this->getPgDetailsByGatewayName('eth');         
                $user_accounts=Userpayaccounts::getAccountDetails($coinorder->from_user_id,$pg->id)->first();
                $user_address=$user_accounts->eth_address;
                $send_array['to']=$user_address;
                $response= CryptoPaymentBase::crypto_sendETHToUserFromAdmin($send_array);    
           
            } 

            if($currency_name=='BCH')
            {

                $pg = $this->getPgDetailsByGatewayName('bch');
                $user_accounts=Userpayaccounts::getAccountDetails($coinorder->from_user_id,$pg->id)->first();
                $user_address=$user_accounts->bch_address;
                $send_array['to_address']=$user_address;
                $response= CryptoPaymentBase::crypto_sendBCHToUserFromAdmin($send_array);    
            }        
             
            
             if(count($response)>0)
             {
                    $update=[
                        'response'=>json_encode($response),                             
                    ];
                          
                    Coinorder::where('id',$coinorder->id)->update($update);

                    \Session::put('successmessage','Coin Bought Successfully');
             }
             else
             {
                 \Session::put('failmessage','Try after sometime');
             }
          }
          catch (Exception $e) 
          { 
           // dd($e->getMessage());
            // if an exception happened in the try block above 
            \Session::put('failmessage',$e->getMessage());
          }
          
          return true;
     }
   
 }
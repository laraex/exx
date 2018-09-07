<?php

namespace App\Traits;

use App\TokenOrders;
use App\Traits\TransactionProcess;
use Carbon\Carbon;


trait ERC20TokenBuyProcess
{

    public function makeTokenOrder($from_user_id,$to_user_id,$type,$status,$request,$mode)
    {

        $create=[
            'from_user_id'=>$from_user_id,
            'to_user_id'=>$to_user_id,
            'type'=>$type,
            'status'=>$status,
            "token_amount"=>$request->token_amount,
            "total_amount"=>$request->total_amount,
            "transaction_id"=>$request->transaction_id,
            "request_token_id"=>$request->request_token_id,
            "from_currency"=>$request->from_currency,
            "from_address"=>$request->from_address,
            "to_address"=>$request->to_address,
            "token_equivalent"=>$request->token_equivalent,
            "mode"=>$mode,
            "eth_hash_id"=>$request->txn_hash_id,
            "exchangerate"=>json_encode($request->exchangerate),
          
            ];

        $order=TokenOrders::create($create); 
     
         return  $order; 

    }
    public function CreateBuyTokenTxn($order)
    {
       
        $accounting_code='erc20token-buy-credit'; 

        $request_json = array('request_amount' => $order->token_amount, 'transaction_number' => $order->transaction_id,'order_id'=>$order->id,'userid'=>$order->from_user_id);
       
        $accounting_code=$this->getAccountingCode($accounting_code);

        $account_id=$this->getAccountID($order->from_user_id,$order->request_token_id);
       
        $comment="Buy ERC 20 Token";
    
        $transaction= $this->makeTransaction($account_id,$order->token_amount,'credit','1','buyerc20token',$accounting_code,$comment,$request_json,'',$order->id,get_class($order));
        
         return $transaction;
     
    }
      public function cancelToken($id,$request,$via)
    {
            $order = TokenOrders::where([['id', $id],['status','pending']])->first(); 
             if(count($order)>0)
             {
                    $update=[                                                           
                                'status'=>'cancel',
                                'cancel_at'=>carbon::now(),
                                'comments_cancel'=>$request->comment,
                                'process_via'=>$via                                    
                            ];

                    TokenOrders::where('id',$id)->update($update);

                                   
              }         
        return true;
    }
    public function approveToken($id,$request,$via)
    {
             $order = TokenOrders::where([['id', $id],['status','pending']])->first();  
           
             

             if(count($order)>0)
             {
                    $update=[
                                                              
                                'status'=>'approve',
                                'approve_at'=>carbon::now(),
                                'comments_approve'=>$request->comment,
                                'process_via'=>$via
                                     
                            ];
                            

                    TokenOrders::where('id',$id)->update($update);

                   $order = TokenOrders::where('id', $id)->first();  
                     
            }
         

             $this->CreateBuyTokenTxn($order);

        return true;

    }
 }


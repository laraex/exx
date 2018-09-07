<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Coinorder;
use App\Settings;
use App\Traits\Common;
use App\Traits\TransactionProcess;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Traits\CommissionProcess;
use Illuminate\Support\Facades\Mail;
//use App\Mail\AdminNotifyBuyCoin;
use App\Traits\LogActivity;

trait CoinOrderProcess {

   public function makeOrder($from_user_id,$to_user_id,$type,$status,$request)
   {
            
                $currency_name=$this->getCurrencyname($request->coin_currency_id);
               

                $from_currency_name=$this->getCurrencyname($request->from_currency);
                $to_currency_name=$this->getCurrencyname($request->coin_currency_id);

                $commission=$this->CalculateAdminCommission('',$from_currency_name,$to_currency_name,$type);

                 $create=[
                            'from_user_id'=>$from_user_id,
                            'to_user_id'=>$to_user_id,
                            'type'=>$type,
                            'amount'=>$request->request_amount,
                            'order_amount'=>$request->order_amount,
                            'transaction_id'=> $request->transaction_id,
                            'request_coin_id'=>$request->coin_currency_id,
                           // 'to_coin_id'=>$request->to_coin_currency_id,
                            'from_currency'=>$request->from_currency,
                            'status'=>$status,
                            'commission'=>$commission,
                            'to_amount'=>$request->request_to_amount,
                           // 'payment_gateway_id'=>$request->payment_gateway_id,
                            
                        ];
                  

                       

                 

                  $user = User::where('id', Auth::id())->with('userprofile')->first();

                  if($to_currency_name=='BTC')
                  {                  
                      $btc_address=$user->userprofile->btc_address;

                      $request_btc=array();

                      $request_btc=[
                      'btc_address'=>$btc_address,
                      'btc_amount'=>$request->request_amount,

                      ];
                      $request_btc=json_encode($request_btc);
                  
                      $create['request']=$request_btc;                
                  }

                   if($to_currency_name=='LTC')
                  {                   
                      $ltc_address=$user->userprofile->ltc_address;

                      $request_ltc=array();

                      $request_ltc=[
                      'ltc_address'=>$ltc_address,
                      'ltc_amount'=>$request->request_amount,

                      ];
                      $request_ltc=json_encode($request_ltc);
                  
                      $create['request']=$request_ltc;                
                  }
                   if($to_currency_name=='ETH')
                  {                    
                      $eth_address=$user->userprofile->eth_address;

                      $request_eth=array();

                      $request_eth=[
                      'eth_address'=>$eth_address,
                      'eth_amount'=>$request->request_amount,

                      ];
                      $request_eth=json_encode($request_eth);
                  
                      $create['request']=$request_eth;                
                  }

                        $coinorder=Coinorder::create($create);

                      //  $admin = User::find(1);
                      //  Mail::to($admin->email)->queue(new AdminNotifyBuyCoin($coinorder)); 
                    $currency_details=$this->getCurrencyDetails($request->coin_currency_id);
                        $message="Buy ".$coinorder->amount." " .$currency_details->token." through ".$from_currency_name;
                    $this->doActivityLog(
                    $user,
                    $user,
                    ['ip' => request()->ip()],
                    LOGNAME_BUYCOIN,
                    $message
                );

                        return $coinorder;
   }

    
      public function getOrderTransactionNumber($id)
    {
        $coinorder = Coinorder::where('id', $id)->first(); 
        return $coinorder['transaction_id'];
    }
       
   public function CreateOrderTransaction($coinorder,$type,$currencyname)
   {
                 $transaction_id=$this->getTransactionID();

                 $create=[
                            'from_user_id'=>$coinorder->from_user_id,
                            'to_user_id'=>$coinorder->to_user_id,
                            'type'=>'order',
                            'amount'=>$coinorder->amount,
                            'order_amount'=>$coinorder->order_amount,
                            'transaction_id'=> $transaction_id,
                            'request_coin_id'=>$coinorder->request_coin_id,
                           // 'to_coin_id'=>$coinorder->to_coin_id,
                            'from_currency'=>$coinorder->from_currency,
                            'status'=>$coinorder->status,                            
                            'primarycoin'=>$coinorder->primarycoin,
                            'commission'=>$coinorder->commission,
                            'to_amount'=>$coinorder->to_amount,
                           // 'payment_gateway_id'=>$coinorder->payment_gateway_id,
                            'coin_orders_ref_id'=>$coinorder->id,
                            'receive_amount'=>$coinorder->receive_amount,                                
                            'status'=>$coinorder->status,
                            'approve_at'=>carbon::now(),
                            'comments_approve'=>$coinorder->comments_approve,
                            'process_via'=>$coinorder->process_via
                        ];
                    $coinorder= Coinorder::create($create);

                   
            return true;
   }
   
 }
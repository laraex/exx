<?php

namespace App\Traits;
use App\User;
use App\Models\Referralgroup;
use App\Traits\PlacementProcessor;
use App\UserInformation;
use App\Models\Currency;
use App\Models\Userprofile;
use Carbon\Carbon;
use App\Models\Usercurrencyaccount;
use App\Models\Transaction;
use App\Jobs\TradeOrdersJob;
use App\TradeOrders;
trait TradeTestUserProcess
{
   
   public function createTestUser($username,$sponsor_id)
   {


            $defaultReferralGroup = Referralgroup::where('is_default', '1')->first()->id;
            $user = new User;
            $user->name = $username;
            $user->email =$username."@mailinator.com";
            $user->password = bcrypt($username);
            $user->referralgroup_id = $defaultReferralGroup;
            $user->sponsor_id = $sponsor_id;
            $user->save();
            return $user;


   } 
   public function createTestUserProfile($user) 
    {  
        $userprofile = new Userprofile;
        $userprofile->user_id = $user->id;
        $userprofile->usergroup_id = 3;
        $userprofile->email_verified = 1;
        $userprofile->created_at = Carbon::now();
        $userprofile->updated_at = Carbon::now(); 
        $userprofile->save();
         
        return $userprofile;       
    }


    public function createTestUserInformation($user) 
    {   
        $userinformation = new UserInformation;
        $userinformation->user_id = $user->id;
        $userinformation->created_at = Carbon::now();
        $userinformation->updated_at = Carbon::now();        
        $userinformation->save();              
    }

    public function createTestUserCurrencyAccount($user,$amount) 
    {
        $currencies = Currency::where('status', '1')->get();

        foreach ($currencies as $currency)
        {
            $account_no = "U-".$currency->name."-".(10000 + $user->id );

            $usercurrencyaccount = new Usercurrencyaccount;
            $usercurrencyaccount->account_no = $account_no;
            $usercurrencyaccount->user_id = $user->id;
            $usercurrencyaccount->currency_id = $currency->id;
            $usercurrencyaccount->created_at = Carbon::now();
            $usercurrencyaccount->updated_at = Carbon::now(); 
            $usercurrencyaccount->save();

            $accounting_code=$this->getAccountingCode('deposit-via-banktransfer');
            $transaction=$this->createTestTransaction($usercurrencyaccount->id,$amount,"credit","1","deposit",$accounting_code,'Test Fund','','','','','active');
        }

    }
    public function createTestTransaction($account_id,$amount,$type,$status,$action,$accounting_code,$comment,$request_json,$response_json,$entity_id,$entity_name,$deposit_status)
    {


        $transaction = new Transaction;
        $transaction->account_id = $account_id;
        $transaction->amount = $amount;
        $transaction->type = $type;
        $transaction->deposit_status =$deposit_status;
        $transaction->status = $status;
        $transaction->action =$action;        
        $transaction->accounting_code_id = $accounting_code;
        $transaction->request = json_encode($request_json);
        $transaction->response = json_encode($response_json);
        $transaction->entity_id = $entity_id;
        $transaction->entity_name = $entity_name; 
        $transaction->save();
        return $transaction;
    }

    public function createTestTradeOrder($user_id,$request,$type)
    {

         $create=[
                            'user_id'=>$user_id,                                                     
                            'amount'=>$request->amount,                           
                            'quantity'=>$request->volume,
                            'from_coin_id'=>$request->from_coin_id,
                            'to_coin_id'=>$request->to_coin_id,
                            'status'=>'pending',
                            'type'=>$type,
                            'order_at'=>Carbon::now(),
                            'total_amount'=>$request->total_amount, 
                            'fee'=>$request->fee,                                   
                            'fee_total'=>$request->fee_total,                                   
       
                        ];
                    
                 
                       $trade=TradeOrders::create($create); 
                       $job = (new TradeOrdersJob($trade))->onQueue('order');
                       dispatch($job);  

                      $this->createTradeDebitTxn($trade);
                       return $trade;      
    }
    public function createTradeDebitTxn($trade)
    {

        if($trade->fromcurrency->type=='fiat')
        {

           $coin_id=$trade->from_coin_id;
        }
        if($trade->tocurrency->type=='fiat')
        {

            $coin_id=$trade->to_coin_id;
        }


         $account_id=$this->getAccountID($trade->user_id,$coin_id);

        

         $accounting_code=$this->getAccountingCode('trade-buy-debit');

          $comment="Buy Debit Wallet";

          $transaction=$this->createTestTransaction($account_id,$trade->total_amount,"debit","1","buytrade",$accounting_code,$comment,'','',$trade->id,get_class($trade),'');
    }

   
}
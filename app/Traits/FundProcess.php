<?php

namespace App\Traits;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Usercurrencyaccount;
use App\Models\Transaction;
use Illuminate\Support\Facades\Mail;
use App\Mail\FundAddedNewStatus;
use App\Mail\AdminNotifyNewFund;
use App\Models\Accountingcode;
use App\Helpers\SiteHelper;
use App\Models\Paymentgateway;
use App\Traits\LogActivity;
use App\Models\Userpayaccounts;

use Exception;


trait FundProcess {


    public function makeAddFund($request)
    {
        
        $result = array();
        $admin = User::find(1);
        $user = Auth::user();
        if(is_null(Auth::user()))
        {
            $user = User::where('id', $request->user_id)->first();
        }
        if ($request->user_id)
        {
            $user = User::where('id', $request->user_id)->first();
        }
       
        $transaction = $this->createNewTransaction($request);

        if ($request->paymentgateway == 1)
        {
            $depositupdate = $this->updateDepositBitcoinHashkey($deposit, $request->txnhashkey);
        }

        //  if ($request->paymentgateway == 7)
        // {
        //     $depositupdate = $this->updateDepositCoinpaymentTxid($deposit, $request->txn_id);
        // }
       
        if($transaction)
        {
            
            // if ($request->paymentgateway == 1 || $request->paymentgateway == 9 || $request->paymentgateway == 7)
            // {
                Mail::to($user->email)->queue(new FundAddedNewStatus($transaction,$user));
                Mail::to($admin->email)->queue(new AdminNotifyNewFund($transaction,$user)); 
            // }
            // elseif ($request->paymentgateway == 14)            
            // {
            //     Mail::to($user->email)->queue(new RegisterBonusDeposit($deposit));
            // }
            // else      
            // {
            //     Mail::to($user->email)->queue(new ActiveDepositSuccessfull($deposit));
            //     Mail::to($admin->email)->queue(new AdminNotifyActiveDeposit($deposit)); 
            // }
        }
        return $transaction;
    }

    public function createNewTransaction($request) {
            $payment_details=Paymentgateway::find($request->paymentgateway);

        // dd($request);

       /* if( $request->paymentgateway == 2 || $request->paymentgateway == 3 || $request->paymentgateway == 4 || $request->paymentgateway == 5 || $request->paymentgateway == 6)*/
       if(($payment_details->gatewayname=='bank-USD')||($payment_details->gatewayname=='bank-GBP')||($payment_details->gatewayname=='bank-EURO')||($payment_details->gatewayname=='bank-KRW'))

        {
            $accounting_code = Accountingcode::where([
                ['active', '=', "1"],
                ['accounting_code', '=', 'deposit-via-banktransfer']
            ])->get(['id'])->toArray();
            $accounting_code = $accounting_code[0]['id'];

            // dd($accounting_code);
            $userpay=Userpayaccounts::where('id',$request->payment)->first();
            //dd($userpay);

            $request_json = array('payment_id' => $request->paymentgateway,'frompayment_id'=>$request->payment,'bank_name'=>$userpay->param1 ,'account_no'=>$userpay->param3,'swift_code'=>$userpay->param2,'account_type'=>$userpay->param4,'bank_address'=>$userpay->param5);
            
             $response_json = array('transaction_number' => $request->transaction_id);

              
        }        
       
        
        //Bitcoin Direct Transfer
        if( $payment_details->gatewayname=='bitcoin')
        {
            //dd($request);
            $accounting_code = Accountingcode::where([
                ['active', '=', "1"],
                ['accounting_code', '=', 'deposit-via-bitcoin']
            ])->get(['id'])->toArray();
            $accounting_code = $accounting_code[0]['id'];

            //$url = 'https://testnet.blockexplorer.com/api/tx/'.$request->txnhashkey;
         
            $response_json = SiteHelper::getBitcoinWalletDetails($request->txnhashkey);
            
             $response_json = json_decode($response_json, true);
             //dd($response_json['vin'][0]['addr']);

             $received_amount = '';
             $received_address = '';
             foreach ($response_json['vout'] as $vout)
             {
                if ($vout['scriptPubKey']['addresses'][0] == $request->admin_address)
                {
                    $received_amount .= $vout['value'];
                    $received_address .= $vout['scriptPubKey']['addresses'][0];
                }                               
             }

              $request_json = array(
                                'payment_id' => $request->paymentgateway,
                                'btcamount' => $request->btcamount,
                                'admin_address' => $request->admin_address,
                                'received_amount' => $received_amount
                                );

                $response_json = array(
                                'hashid' => $response_json['txid'],
                                'confirmations' => $response_json['confirmations'],
                                'received_amount' => $received_amount,
                                'received_address' => $received_address,
                                'from_address' => $response_json['vin'][0]['addr'],
                                'time' => $response_json['time'],
                                'transaction_number' => $request->transaction_id
                                );

            //dd($response_json);           
        }       
     

        $account = Usercurrencyaccount::where([
                ['user_id', '=', Auth::id()],
                ['currency_id', '=', \Session::get('currency_id')]
            ])->get(['id'])->toArray();

        $usercurrencyaccount = $account[0]['id'];
        
        $user = User::where('id', Auth::id())->with('userprofile')->first();   

        $transaction = new Transaction;
        $transaction->account_id = $usercurrencyaccount;
        $transaction->amount = $request->amount;
        $transaction->type = "credit";
        $transaction->deposit_status ="new";
        $transaction->status = 0;
        $transaction->action ="deposit";
        if ($request->paymentgateway == '1')
        {
            $transaction->param = $request->txnhashkey;
        }
        $transaction->accounting_code_id = $accounting_code;
        $transaction->request = json_encode($request_json);
        $transaction->response = json_encode($response_json);
        $transaction->save(); 


        $payment_details = Paymentgateway::where(
                                            'id', '=', $request->paymentgateway
                                            )->with('currency')->first();
        $message="Fund Added-".$request->amount." ".$payment_details->currency->token; 
        $this->doActivityLog(
                    $user,
                    $user,
                    ['ip' => request()->ip()],
                    LOGNAME_ADDFUND,
                    $message
                );   


        return $transaction;      

    }
    public function approveFund($id,$request)
    {
       
        \DB::beginTransaction();
        try{


            $transaction = Transaction::where('id', $id)->with('usercurrencyaccount')->first();
  
         

            // dd($transaction);  
            $fund_amount=$transaction->amount;
            $comment="{{ trans('admin_fund.req_fund') }}".$fund_amount;

            $transaction->amount = $request->depositamount;          
            $transaction->status = 1;      
            $transaction->deposit_status = "active";
            $transaction->comment=$comment." . ".$request->comment;   
            $transaction->save();
          

            \DB::commit();
            return $transaction;
       }
       catch(Exception $e)
       {
        \DB::rollBack();
         //dd($e->getMessage());

       }
    }

 }
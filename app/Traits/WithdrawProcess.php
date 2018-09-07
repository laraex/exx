<?php

namespace App\Traits;

use App\Models\Paymentgateway;
use App\Models\Userpayaccounts;
use App\Models\Withdraw;
use App\Models\Accountingcode;
use App\Models\Transaction;
use App\User;
use App\Models\Usercurrencyaccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Traits\LogActivity;
use App\Models\Currency;


trait WithdrawProcess {

    use LogActivity;

    public function withdrawrequest($request)
    {
        $withdraw = $this->createNewWithdraw($request);        
        $transaction = $this->createNewWithdrawTransaction( $request, $withdraw);
        $updatewithdraw = $this->updateWithdrawTransaction( $transaction, $withdraw);
        return $withdraw;
	}  

    public function createNewWithdraw($request)
    {      
        //dd($request);

          $commissionvalue  = Paymentgateway::where('id', $request->paymentgateway)->get(['withdraw_commission'])->toArray();

          ///dd($commissionvalue);

        $admincommission = $commissionvalue[0]['withdraw_commission'];
        $admin_com_amount = ($request->amount * $admincommission) / 100 ;
         //dd($admincommission.$admin_com_amount);

        $payment=Paymentgateway::where('id', $request->paymentgateway)->first();

        $withdraw = new Withdraw;
        $withdraw->payaccount_id = $request->userpayaccountid;
        $withdraw->status = 'pending';
        $withdraw->amount = $request->amount;
        $withdraw->user_id = Auth::id();
        $withdraw->currency_id = $payment->currency_id;
        $withdraw->commission_per = $admincommission;
        $withdraw->commission_total =$admin_com_amount;
        $withdraw->save();

       \Session::put('currencyid',$payment->currency_id);
         //Activity Log
        $currency_details = Currency::where('id', '=', \Session::get('currencyid'))->first();
        $message="Withdraw - ".$request->amount." ".$currency_details->token; 
        $user = User::find(Auth::id());
            $this->doActivityLog(
                $user,
                $user,
                ['ip' => request()->ip()],
                LOGNAME_WITHDRAW,
                $message
            );  
        return $withdraw;
    }
    public function addAdminCommission($request, $id)
    {
      
        $request_json = array('userid' => $request->userid, 'amount' => $request->amount);

        $response_json = array('transaction_number' => uniqid(), 'comment' => 'Withdraw Admin Fee');   

        $commissionvalue  = Paymentgateway::where('id', $request->paymentgateway)->get(['withdraw_commission'])->toArray();
        $admincommission = $commissionvalue[0]['withdraw_commission'];
        $admin_com_amount = ($request->amount * $admincommission) / 100 ;
        $withdrawamount = $request->amount - $admin_com_amount;


        //dd($withdraw_amount);

        if ($admin_com_amount > 0)
        {
            $get_transaction_id = Withdraw::where('id', '=', $id)->with(['transaction'])->first();

            // $get_user_account_id = Transaction::where('id', '=', $get_transaction_id->transaction->id)->get(['account_id'])->toArray();

            // $user_account_id = $get_user_account_id[0]['account_id'];
            // dd($user_account_id);
           $payment=Paymentgateway::where('id', $request->paymentgateway)->first();

            // $currency_id = Usercurrencyaccount::where([
            //     ['id', '=', $user_account_id]
            // ])->get(['currency_id'])->toArray();
            // $currency_id = $currency_id[0]['currency_id'];

            // dd($currency_id);

            $account_id = Usercurrencyaccount::where([
                ['user_id', '=', 1],
                ['currency_id', '=', $payment->currency_id]
            ])->get(['id'])->toArray();
            $account_id = $account_id[0]['id'];
            // dd($account_id);

            $accountcodeResult  = Accountingcode::where([
                ['active', '=', "1"],
                ['accounting_code', '=', "withdraw-commission"],
                ])->get(['id'])->toArray();
            $accounting_code = $accountcodeResult[0]['id'];

            $transaction = new Transaction;
            $transaction->account_id = $account_id;
            $transaction->amount = $admin_com_amount;
            $transaction->user_id ='1';
             $transaction->currency_id =$payment->currency_id;
            $transaction->type = "credit";
            $transaction->status ="approve";
            $transaction->accounting_code_id = $accounting_code;
            $transaction->request = json_encode($request_json);
            $transaction->response = json_encode($response_json);
            $transaction->save();       
        }
       
        return $withdrawamount;
    }

    public function createNewWithdrawTransaction( $request, $withdraw)
    {
        $request_json = array('userpayaccountid' => $request->userpayaccountid);

         $accountcodeResult  = Accountingcode::where('active', "1"); 
         //dd($accountcodeResult);
         if ($request->paymentgateway == 1)
         {
            $accounting_code  = $accountcodeResult->where('accounting_code', 'withdraw-via-bitcoin')->get(['id'])->toArray();
         }       
         if($request->paymentgateway > 1)
         {
            $accounting_code  = $accountcodeResult->where('accounting_code', 'withdraw-via-bankwire')->get(['id'])->toArray();
         }        
         
     
        $accounting_code = $accounting_code[0]['id'];

        $user_id = Auth::id();

       // $payment=Paymentgateway::where('id', $request->paymentgateway)->first();

        $account_id = Usercurrencyaccount::where([
                ['user_id', '=', $user_id],
                 ['currency_id', '=', \Session::get('currencyid')]
            ])->get(['id'])->toArray();
            $account_id = $account_id[0]['id'];

            $array=array();
           $balance_before=Transaction::BalanceBefore($withdraw->user_id,$withdraw->currency_id)->latest()->first();
                    
            $balance_before=0;
            $balance_after=0;
           $transaction=$this->createTransaction($withdraw->user_id,$withdraw->currency_id,$request->amount,"debit","pending","withdraw",$accounting_code,"Withdraw",json_encode($request_json),'',$withdraw->id,get_class($withdraw),$balance_before,$balance_after,"NULL","NULL", $array);
 
        // $transaction = new Transaction;
        // $transaction->account_id = $account_id;
        // $transaction->amount = $request->amount;
        // $transaction->type = "debit";
        // $transaction->status ="1";
        // $transaction->action ="withdraw";
        // $transaction->accounting_code_id = $accounting_code;
        // $transaction->request = json_encode($request_json);
        // $transaction->save();
        return $transaction;

    }

    public function updateWithdrawTransaction($transaction, $withdraw)
    {
        $updatewithdraw = Withdraw::where('id', '=', $withdraw->id)->first();
        $updatewithdraw->transaction_id = $transaction->id;      
        $updatewithdraw->save();
        return $updatewithdraw;
    }

    public function updateCompleteStatus($request, $id)
    {       
       $completestatus = $this->approveCompleteStatus($request, $id);
       $transactionnumber = $this->updateTransactionNumber($request,$id);        
       return $completestatus;
   }

    public function approveCompleteStatus($request, $id)
    {
        $withdrawamount = $this->addAdminCommission($request, $id);
        $withdraw = Withdraw::where('id', '=', $id)->first(); 
        $withdraw->amount = $withdrawamount;  
        $withdraw->status = 'completed';
        if ($request->paymentgateway == 9)
        {
            $withdraw->param = $request->hashkey;
        }
        $withdraw->completed_on = Carbon::now();
        $withdraw->comments_on_complete = $request->comment;
        $withdraw->save();
        return $withdraw;
    }

    public function updateTransactionNumber($request,$id)
    {
         $response_json = array('transaction_number' => uniqid());

          $withdraw = Withdraw::where('id', '=', $id)->first(); 

          $withdraw_amounts=$withdraw->amount+$withdraw->commission_total;
    
         $array=array();
        $balance_before=Transaction::BalanceBefore($withdraw->user_id,$withdraw->currency_id)->latest()->first();

        $balance_before= $balance_before->balance_after;
        $balance_after= $balance_before-$withdraw_amounts;

         $update=['status'=>'approve',
                             'balance_before'=>$balance_before,
                             'balance_after'=>$balance_after,
                             'response'=>json_encode($response_json)
                          ];
                          $transaction=Transaction::where([['status','pending'],['id',$request->transactionid]])->update($update);

       
        // $transaction = Transaction::where('id', '=', $request->transactionid)->first();       
        // $transaction->response = json_encode($response_json);    
        // $transaction->save();
        return $transaction;
    }


    public function updateRejectStatus($request, $id)
    {
        $withdraw = Withdraw::where('id', $id)->first();
        if ($withdraw->status == 'pending')
        {
            $transactionnumber = $this->cancellationTransaction($request);
        }
        $rejectstatus = $this->changeRejectStatus($request, $id);       
        
        return $rejectstatus;
   }

   public function changeRejectStatus($request, $id)
    {
        $withdraw = Withdraw::where('id', '=', $id)->first();   
        $withdraw->status = 'rejected';
        $withdraw->rejected_on = Carbon::now();
        $withdraw->comments_on_rejected = $request->comment;
        $withdraw->save();
        return $withdraw;
    }
   
    public function cancellationTransaction( $request)
    {
        $request_json = array('amount' => $request->amount);

         $accountcodeResult  = Accountingcode::where([
            ['active', '=', "1"],
            ['accounting_code', '=', "withdraw-cancellation"]
            ])->get(['id'])->toArray(); 
        //dd($accountcodeResult);         
     
        $accounting_code = $accountcodeResult[0]['id'];

        $account_id = Transaction::where([
                ['id', '=', $request->transactionid]
            ])->get(['account_id'])->toArray();
            $account_id = $account_id[0]['account_id'];
 
        $transaction = new Transaction;
        $transaction->account_id = $account_id;
        $transaction->amount = $request->amount;
        $transaction->type = "credit";
        $transaction->deposit_status ="1";
        $transaction->status ="1";
        $transaction->action ="withdraw";
        $transaction->accounting_code_id = $accounting_code;
        $transaction->request = json_encode($request_json);
        $transaction->save();       
        return $transaction;
    }  

 }
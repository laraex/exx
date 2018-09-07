<?php

namespace App\Traits;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\FundAddedNewStatus;
use App\Mail\AdminNotifyNewFund;
use App\Traits\LogActivity;
use Exception;
use App\Deposit;
use App\Models\Userpayaccounts;
use Carbon\Carbon;
use App\Traits\TransactionProcess;
use App\Models\Transaction;
trait DepositProcess {


    public function makeDeposit($request)
    {
      
        $user = User::where('id', $request->user_id)->first();       
       
        $deposit = $this->createNewDeposit($request);

        if($deposit)
        {
          
              //  Mail::to($user->email)->queue(new FundAddedNewStatus($deposit,$user));
              //  Mail::to($admin->email)->queue(new AdminNotifyNewFund($deposit,$user)); 
            
        }
        return $deposit;
    }
    public function createNewDeposit($request)
    {

        try{

             $payment_details=$this->getPgDetailsById($request->paymentgateway);

        if(($payment_details->gatewayname=='bank-USD')||($payment_details->gatewayname=='bank-GBP')||($payment_details->gatewayname=='bank-EURO')||($payment_details->gatewayname=='bank-KRW'))
        {
            
           

            $userpay=Userpayaccounts::where('id',$request->payment)->first();
           

            $request_json['user'] = array('payment_id' => $request->paymentgateway,'frompayment_id'=>$request->payment,'bank_name'=>$userpay->param1 ,'account_no'=>$userpay->param3,'swift_code'=>$userpay->param2,'account_type'=>$userpay->param4,'bank_address'=>$userpay->param5);
            $request_json['admin'] =json_decode($payment_details->params);
            
            $response_json = array('transaction_number' => $request->transaction_id);

              
        }       
               $create=[
                    'user_id'=>$request->user_id,
                    'currency_id'=>$request->currency_id,                   
                    'amount'=>$request->amount,
                    'status'=>$request->status,
                    'transaction_id'=> $request->transaction_id,
                    'paymentgateway_id'=> $request->paymentgateway_id,
                    'request'=>json_encode($request_json),
                    'response'=>json_encode($response_json),
                                              
                ];
               $deposit= Deposit::create($create);
               return $deposit;
           }
           catch(Exception $e)
           {

           // dd($e->getMessage());
           }


    }
    public function sessionToDepositRequest()
    {

        $array=[
            "currency_id"=>\Session::get('currency_id'),           
            "amount"=>\Session::get('amount'),
            "transaction_id"=>\Session::get('transactionnumber'),          
            "paymentgateway_id"=>\Session::get('paymentgateway'),          
            ];

                      \Session::forget('amount'); 
    
      return $array;
    }
    public function rejectDeposit($id,$request)
    {

        try{

        $deposit = Deposit::where('id', $id)->first();
        if($deposit->status=='new')
        {
                $deposit->status ='cancel'; 
                $deposit->authorised_at =Carbon::now(); 
                $deposit->authorised_by =$request->authorised_by; 
                $deposit->save();
        }

        return true;   
       }
        catch(Exception $e)
        {
            //dd($e->getMessage());
        return false;
        }

    }
    public function approveDeposit($id,$request)
    {
       
        \DB::beginTransaction();
        try{

             $deposit = Deposit::where('id', $id)->first();
                if($deposit->status=='new')
                {
                    //dd($deposit);
                        $deposit->status ='approve'; 
                        $deposit->receive_amount =$request->depositamount; 
                        $deposit->authorised_at =Carbon::now(); 
                        $deposit->authorised_by =$request->authorised_by; 
                        $deposit->comment =$request->comment; 
                        $deposit->save();



                        $payment_details=$this->getPgDetailsById($deposit->paymentgateway_id);

                       // dd($payment_details);

                        $accounting_code='deposit-'.$payment_details->gatewayname;

                         //dd($accounting_code);
                            
                        $accounting_code=$this->getAccountingCode($accounting_code);

                        //dd($accounting_code);
                                
                        $array=array();
                        $balance_before=Transaction::BalanceBefore($deposit->user_id,$deposit->currency_id)->latest()->first();
                 // dd($deposit);
                    
                        $balance_before= $balance_before->balance_after;
                        $balance_after= $balance_before+$request->depositamount;
                      
                        $transaction=$this->createTransaction($deposit->user_id,$deposit->currency_id,$request->depositamount,"credit","approve","deposit",$accounting_code,$request->comment,$deposit->request,$deposit->response,$deposit->id,get_class($deposit),$balance_before,$balance_after,"NULL","NULL", $array);

                        
                }

            \DB::commit();
            return $transaction;
       }
       catch(Exception $e)
       {
        \DB::rollBack();
        // dd($e->getMessage());

       }
    }

 

 }
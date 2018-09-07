<?php

namespace App\Traits;

use App\Models\Userpayaccounts;
use App\Models\Fundtransfer;
use App\Models\Accountingcode;
use App\Models\Transaction;
use App\User;
use App\Models\Usercurrencyaccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Config;
use App\Traits\LogActivity;
use App\Models\Currency;


trait FundTransferProcess {

    use LogActivity;

    public function sendFundTransfer($request)
    {
        $fundtransfer = $this->addFundToUser($request);        
        $transaction = $this->createFundTransferCreditTransaction( $request, $fundtransfer);
        $updatewithdraw = $this->updateCreditTransaction( $transaction, $fundtransfer);

        $transaction = $this->createFundTransferDebitTransaction( $request, $fundtransfer);
        $updatewithdraw = $this->updateDebitTransaction( $transaction, $fundtransfer);
        return $fundtransfer;
	}  

    public function addFundToUser($request)
    {
        //dd($request);
        $fromaccount_id = Usercurrencyaccount::where([
                ['user_id', '=', Auth::id()],
                ['currency_id', '=', \Session::get('currencyid')]
            ])->get(['id'])->toArray();
        $from_account_id = $fromaccount_id[0]['id'];

        $touser = User::where('name', $request->sendto)->first();
        //dd($touser);
        $toaccount_id = Usercurrencyaccount::where([
                ['user_id', '=', $touser->id],
                 ['currency_id', '=', \Session::get('currencyid')]
            ])->get(['id'])->toArray();
        $to_account_id = $toaccount_id[0]['id'];

         $user = User::where('id', Auth::id())->with('userprofile')->first();
//dd(uniqid());
        $fundtransfer = new Fundtransfer;
        $fundtransfer->amount = $request->amount;
        $fundtransfer->from_account_id = $from_account_id;
        $fundtransfer->to_account_id = $to_account_id;
        $fundtransfer->comments = 'Fund transfer to '.$request->sendto;
        $fundtransfer->transaction_id =  uniqid();

        $fundtransfer->save();

        //Activity Log
        $touser = User::find($touser->id);
        $currency_details = Currency::where(
                                            'id', '=', \Session::get('currencyid')
                                            )->first();

       
        $message=$request->amount." ".$currency_details->token." Transfer to ".$touser->name; 

                   $user = User::find(Auth::id());
                        $this->doActivityLog(
                            $user,
                            $user,
                            ['ip' => request()->ip()],
                            LOGNAME_FUNDTRANSFER,
                            $message
                        );   


        return $fundtransfer;
    }   

    public function createFundTransferCreditTransaction( $request, $fundtransfer)
    {
        $fundtransferamount = $this->addAdminCommission($request);
        $request_json = array('amount' => $request->amount);
        

        $accountcodeResult  = Accountingcode::where('active', "1"); 
        $accounting_code  = $accountcodeResult->where('accounting_code', 'fund-transfer')->get(['id'])->toArray();     
        $accounting_code = $accounting_code[0]['id'];

        $touser = User::where('name', $request->sendto)->first();

        $account_id = Usercurrencyaccount::where([
                ['user_id', '=', $touser->id],
                 ['currency_id', '=', \Session::get('currencyid')]
            ])->get(['id'])->toArray();
            $account_id = $account_id[0]['id'];

         $form_account_id = Usercurrencyaccount::where([
                ['user_id', '=', Auth::id()],
                 ['currency_id', '=', \Session::get('currencyid')]
            ])->get(['id'])->toArray();
        $form_account_id = $form_account_id[0]['id'];

        $response_json = array('receiveamount' => $fundtransfer->amount, 'from_account_id' => $form_account_id, 'to_account_id' => $account_id, 'transaction_number' => uniqid() );
 
        $transaction = new Transaction;
        $transaction->account_id = $account_id;
        $transaction->amount = $fundtransferamount;
        $transaction->type = "credit";
        $transaction->status ="1";
        $transaction->action ="transfer";
        $transaction->accounting_code_id = $accounting_code;
        $transaction->request = json_encode($request_json);
        $transaction->response = json_encode($response_json);
        $transaction->save();       
        return $transaction;
    }

     public function addAdminCommission($request)
    {
        //dd('test');
        $request_json = array('userid' => Auth::id(), 'amount' => $request->amount);   
        $response_json = array('transaction_number' => uniqid(), 'comment' => 'Fund Transfer Admin Fee');   

        $admin_com_amount = ($request->amount * Config::get('settings.fundtransfer_commission')) / 100 ; 
        $fund_transfer_remaining_amount = $request->amount - $admin_com_amount;
        //dd($withdraw_amount);
        $account_id = Usercurrencyaccount::where([
                ['user_id', '=', 1],
                ['currency_id', '=', \Session::get('currencyid')]
            ])->get(['id'])->toArray();
        $account_id = $account_id[0]['id'];

        $accountcodeResult  = Accountingcode::where([
            ['active', '=', "1"],
            ['accounting_code', '=', "fund-transfer-commission"],
            ])->get(['id'])->toArray();
        $accounting_code = $accountcodeResult[0]['id'];

        // dd(\Config::get('settings.fundtransfer_commission'));

        if (\Config::get('settings.fundtransfer_commission') > 0)
        {

            $transaction = new Transaction;
            $transaction->account_id = $account_id;
            $transaction->amount = $admin_com_amount;
            $transaction->type = "credit";
            $transaction->status ="1";
            $transaction->accounting_code_id = $accounting_code;
            $transaction->request = json_encode($request_json);
            $transaction->response = json_encode($response_json);
            $transaction->save();       
            return $fund_transfer_remaining_amount;
        }
    }

    public function updateCreditTransaction($transaction, $fundtransfer)
    {
        $updatewithdraw = Fundtransfer::where('id', '=', $fundtransfer->id)->first();
        $updatewithdraw->credit_transaction_id = $transaction->id;      
        $updatewithdraw->save();
        return $updatewithdraw;
    }  

    public function createFundTransferDebitTransaction( $request, $fundtransfer)
    {
        $request_json = array('amount' => $request->amount);
        $response_json = array('receiveamount' => $fundtransfer->amount);

        $accountcodeResult  = Accountingcode::where('active', "1"); 
        $accounting_code  = $accountcodeResult->where('accounting_code', 'fund-transfer')->get(['id'])->toArray();     
        $accounting_code = $accounting_code[0]['id'];

        $touser = User::where('name', $request->sendto)->first();

        $account_id = Usercurrencyaccount::where([
                ['user_id', '=', Auth::id()],
                 ['currency_id', '=', \Session::get('currencyid')]
            ])->get(['id'])->toArray();
            $account_id = $account_id[0]['id'];
 
        $transaction = new Transaction;
        $transaction->account_id = $account_id;
        $transaction->amount = $request->amount;
        $transaction->type = "debit";
        $transaction->status ="1";
        $transaction->accounting_code_id = $accounting_code;
        $transaction->request = json_encode($request_json);
        $transaction->response = json_encode($response_json);
        $transaction->save();       
        return $transaction;
    }

    public function updateDebitTransaction($transaction, $fundtransfer)
    {
        $updatewithdraw = Fundtransfer::where('id', '=', $fundtransfer->id)->first();
        $updatewithdraw->debit_transaction_id = $transaction->id;      
        $updatewithdraw->save();
        return $updatewithdraw;
    }    

 }
<?php

namespace App\Traits;

use App\Models\Exchange;
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
use App\Traits\Common;


trait ExchangeProcess {

    use LogActivity;

    public function exchangeprocess($request)
    {
        $createExchange = $this->createExchange($request);        
        $createExchangeTransaction = $this->createExchangeTransaction( $request, $createExchange);
        $updateTransactiontoExchange = $this->updateTransactiontoExchange( $createExchangeTransaction, $createExchange);

        $createDebitExchangeTransaction = $this->createDebitExchangeTransaction( $request, $createExchange);
        
        return $createExchange;
	}  

    public function createExchange($request)
    {
        //dd($request);
        $fromaccount_id = Usercurrencyaccount::where([
                ['user_id', '=', Auth::id()],
                ['currency_id', '=', $request->fromcurrency]
            ])->get(['id'])->toArray();
        $from_account_id = $fromaccount_id[0]['id'];

        // dd($from_account_id);
        $toaccount_id = Usercurrencyaccount::where([
                ['user_id', '=', Auth::id()],
                 ['currency_id', '=', $request->tocurrency]
            ])->get(['id'])->toArray();
        $to_account_id = $toaccount_id[0]['id'];

        $user = User::where('id', Auth::id())->with('userprofile')->first();

        // dd($to_account_id);

        $exchange = new Exchange;
        $exchange->user_id = Auth::id();
        $exchange->from_amount = $request->fromamount;
        $exchange->from_currency_account = $from_account_id;
        $exchange->to_amount = $request->toamount;
        $exchange->to_currency_account = $to_account_id;
        $exchange->save();

        $fromcurrencydetails = $this->getCurrencyDetails($request->fromcurrency);
        $tocurrencydetails = $this->getCurrencyDetails($request->tocurrency);
        $message = 'Currency Exchanged From '.$request->fromamount.' '.$fromcurrencydetails->token .' To '.$request->toamount.' '. $tocurrencydetails->token; 
        $this->doActivityLog(
                    $user,
                    $user,
                    ['ip' => request()->ip()],
                    'exchange',
                    $message
                );
        return $exchange;
    }   

    public function createExchangeTransaction( $request, $fundtransfer)
    {
        $exchangeamount = $this->addAdminCommission($request);
        $request_json = array('fromamount' => $request->fromamount, 'toamount' => $request->toamount);
        

        $accountcodeResult  = Accountingcode::where('active', "1"); 
        $accounting_code  = $accountcodeResult->where('accounting_code', 'fund-exchange')->get(['id'])->toArray();     
        $accounting_code = $accounting_code[0]['id'];


        $account_id = Usercurrencyaccount::where([
                ['user_id', '=', Auth::id()],
                 ['currency_id', '=', $request->tocurrency]
            ])->get(['id'])->toArray();
        $account_id = $account_id[0]['id'];

         
        $response_json = array('toamount' => $request->toamount, 'transaction_number' => uniqid() );
 
        $transaction = new Transaction;
        $transaction->account_id = $account_id;
        $transaction->amount = $exchangeamount;
        $transaction->type = "credit";
        $transaction->status ="1";
        $transaction->action ="exchange";
        $transaction->accounting_code_id = $accounting_code;
        $transaction->request = json_encode($request_json);
        $transaction->response = json_encode($response_json);
        $transaction->save();       
        return $transaction;
    }

     public function addAdminCommission($request)
    {
        //dd('test');
        $request_json = array('userid' => Auth::id(), 'formamount' => $request->fromamount, 'toamount' => $request->toamount); 
        $response_json = array('transaction_number' => uniqid(), 'comment' => 'Exchange Admin Fee');      
        $admin_com_amount = ($request->toamount * Config::get('settings.exchange_commission')) / 100 ; 
        $fund_exchange_remaining_amount = $request->toamount - $admin_com_amount;
        //dd($withdraw_amount);
        $account_id = Usercurrencyaccount::where([
                ['user_id', '=', 1],
                ['currency_id', '=', $request->tocurrency]
            ])->get(['id'])->toArray();
        $account_id = $account_id[0]['id'];

        $accountcodeResult  = Accountingcode::where([
            ['active', '=', "1"],
            ['accounting_code', '=', "fund-exchange-commission"],
            ])->get(['id'])->toArray();
        $accounting_code = $accountcodeResult[0]['id'];

        $transaction = new Transaction;
        $transaction->account_id = $account_id;
        $transaction->amount = $admin_com_amount;
        $transaction->type = "credit";
        $transaction->status ="1";
        // $transaction->action ="exchange";
        $transaction->accounting_code_id = $accounting_code;
        $transaction->request = json_encode($request_json);
        $transaction->response = json_encode($response_json);
        $transaction->save();       
        return $fund_exchange_remaining_amount;
    }

    public function updateTransactiontoExchange($transaction, $exchange)
    {
        $updateexchange = Exchange::where('id', '=', $exchange->id)->first();
        $updateexchange->transaction_id = $transaction->id;      
        $updateexchange->save();
        return $updateexchange;
    }

    public function createDebitExchangeTransaction( $request, $fundtransfer)
    {
        $request_json = array('fromamount' => $request->fromamount, 'toamount' => $request->toamount);
        

        $accountcodeResult  = Accountingcode::where('active', "1"); 
        $accounting_code  = $accountcodeResult->where('accounting_code', 'fund-exchange')->get(['id'])->toArray();     
        $accounting_code = $accounting_code[0]['id'];


        $account_id = Usercurrencyaccount::where([
                ['user_id', '=', Auth::id()],
                 ['currency_id', '=', $request->fromcurrency]
            ])->get(['id'])->toArray();
        $account_id = $account_id[0]['id'];

         
        $response_json = array('toamount' => $request->toamount, 'transaction_number' => uniqid() );
 
        $transaction = new Transaction;
        $transaction->account_id = $account_id;
        $transaction->amount = $request->fromamount;
        $transaction->type = "debit";
        $transaction->status ="1";
        $transaction->action ="exchange";
        $transaction->accounting_code_id = $accounting_code;
        $transaction->request = json_encode($request_json);
        $transaction->response = json_encode($response_json);
        $transaction->save();       
        return $transaction;
    }    

 }
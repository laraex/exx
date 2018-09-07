<?php

namespace App\Http\Controllers\Api;

use App\Models\Exchange;
use App\Coinorder;
use App\Transfer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    public function fiatCurrencyTransaction()
    {
// dd('sdkjf');
        $transactions = Exchange::where('user_id', Auth::guard('api')->id())->with('exchange_from_account', 'exchange_to_account')->orderBy('id', 'DESC')->get();

        if (count($transactions) == 0)
        {
            $norecords = array('norecord' => 'No records found.');
            return [
            'data' => $norecords,
            ];
        }

        foreach ($transactions as $key => $transaction)
        {
            $data[$key]['fromAccount']  =  $transaction->exchange_from_account->account_no;
            $data[$key]['toAccount']  =  $transaction->exchange_to_account->account_no;
            $data[$key]['fromAmount']  =  $transaction->from_amount;
            $data[$key]['toAmount']  =  $transaction->to_amount;
            $data[$key]['date']  =  $transaction->created_at->format('d/m/Y H:i:s');
        }

        return [
            'data' => $data,
       ];
    
    }

    public function buyCoinTransaction()
    {
        $transactions = Coinorder::where([['from_user_id', Auth::guard('api')->id()],['type', 'buy']])->with('tocurrency', 'fromcurrency')->orderBy('id', 'DESC')->get();

        if (count($transactions) == 0)
        {
            $norecords = array('norecord' => 'No records found.');
            return [
            'data' => $norecords,
            ];
        }

        foreach ($transactions as $key => $transaction)
        {
            $response = json_decode($transaction['response'], true);

            $data[$key]['requestCoin']  =  number_format((float)$transaction->amount,8) .' '. $transaction->tocurrency->token;
            $data[$key]['fromWallet']  =  number_format((float)$transaction->order_amount,2) .' '. $transaction->fromcurrency->token;
            $data[$key]['date']  =  $transaction->created_at->format('d/m/Y H:i:s');
            if (!is_null($transaction['response']) && (count($response['data'])>0))
            {
                $data[$key]['transactionHashID']  = $response['data']['txid'];
            }
            else
            {
                $data[$key]['transactionHashID']  =  '';   
            }
                                  
        }

        return [
            'data' => $data,
       ];
    }

    public function sendCoinTransaction()
    {

       $transactions = Transfer::where('user_id', Auth::guard('api')->id())->with('currency')->orderBy('id', 'DESC')->get();

       if (count($transactions) == 0)
        {
            $norecords = array('norecord' => 'No records found.');
            return [
            'data' => $norecords,
            ];
        }

        foreach ($transactions as $key => $transaction)
        {
            $response = json_decode($transaction['response'], true);
            $data[$key]['amount']  =  number_format((float)$transaction->amount,5) .' '. $transaction->currency->token;
            $data[$key]['toAddress']  =  $transaction->to_address;
            $data[$key]['date']  =  $transaction->created_at->format('d/m/Y H:i:s');
            if (!is_null($transaction['response']) && (count($response['data'])>0))
            {
                $data[$key]['transactionHashID']  = $response['data']['txid'];
            }
            else
            {
                $data[$key]['transactionHashID']  =  '';   
            }
        }

        return [
            'data' => $data,
       ];
        
    }

    public function transactionDetails()
    {
        //fiatCurrencyTransactions

        $fiatCurrencyTransactions = Exchange::where('user_id', Auth::guard('api')->id())->with('exchange_from_account', 'exchange_to_account')->orderBy('id', 'DESC')->take(10)->get();

        if (count($fiatCurrencyTransactions) == 0)
        {
            $fiatTransaction = '';
        }

        if (count($fiatCurrencyTransactions) > 0)
        {

            foreach ($fiatCurrencyTransactions as $key => $fiat)
            {
                $fiatTransaction[$key]['fromAccount']  =  $fiat->exchange_from_account->account_no;
                $fiatTransaction[$key]['toAccount']  =  $fiat->exchange_to_account->account_no;
                $fiatTransaction[$key]['fromAmount']  =  $fiat->from_amount;
                $fiatTransaction[$key]['toAmount']  =  $fiat->to_amount;
                $fiatTransaction[$key]['date']  =  $fiat->created_at->format('d/m/Y H:i:s');
            }
        }

        // buyCoinTransaction

        $buyCoinTransactions = Coinorder::where([['from_user_id', Auth::guard('api')->id()],['type', 'buy']])->with('tocurrency', 'fromcurrency')->orderBy('id', 'DESC')->take(10)->get();

        if (count($buyCoinTransactions) == 0)
        {
             $buyCoinTransaction = '';
        }

        if (count($buyCoinTransactions) > 0)
        {
            foreach ($buyCoinTransactions as $key => $buyCoin)
            {
                $response = json_decode($buyCoin['response'], true);

                $buyCoinTransaction[$key]['requestCoin']  =  number_format((float)$buyCoin->amount,8) .' '. $buyCoin->tocurrency->token;
                $buyCoinTransaction[$key]['fromWallet']  =  number_format((float)$buyCoin->order_amount,2) .' '. $buyCoin->fromcurrency->token;
                $buyCoinTransaction[$key]['date']  =  $buyCoin->created_at->format('d/m/Y H:i:s');
                if (!is_null($buyCoin['response']) && (count($response['data'])>0))
                {
                    $buyCoinTransaction[$key]['transactionHashID']  = $response['data']['txid'];
                }
                else
                {
                    $buyCoinTransaction[$key]['transactionHashID']  =  '';   
                }
                                      
            }
        }

        //sendCoinTransactions

        $sendCoinTransactions = Transfer::where('user_id', Auth::guard('api')->id())->with('currency')->orderBy('id', 'DESC')->take(10)->get();

       if (count($sendCoinTransactions) == 0)
        {
            $sendCoinTransaction = '';
        }

        foreach ($sendCoinTransactions as $key => $sendCoin)
        {
            $response = json_decode($sendCoin['response'], true);
            $sendCoinTransaction[$key]['amount']  =  number_format((float)$sendCoin->amount,5) .' '. $sendCoin->currency->token;
            $sendCoinTransaction[$key]['toAddress']  =  $sendCoin->to_address;
            $sendCoinTransaction[$key]['date']  =  $sendCoin->created_at->format('d/m/Y H:i:s');
            if (!is_null($sendCoin['response']) && (count($response['data'])>0))
            {
                $sendCoinTransaction[$key]['transactionHashID']  = $response['data']['txid'];
            }
            else
            {
                $sendCoinTransaction[$key]['transactionHashID']  =  '';   
            }
        }


        return [
            'data' => ['fiatTransaction' => $fiatTransaction, 'buyCoinTransaction' => $buyCoinTransaction, 'sendCoinTransaction' => $sendCoinTransaction]
       ];
    } 
    
}

<?php

namespace App\Traits;

use App\Http\Controllers\CryptoPayment\CryptoPaymentBase;
use App\Models\Transaction;
use App\Transfer;
use Carbon\Carbon;
use Exception;
trait CryptoWithdrawProcess
{

    public function approveWithdraw($id, $request)
    {

        \DB::beginTransaction();
        try {

            $transfer = Transfer::where('id', $id)->first();
            if ($transfer->status == 'pending') {
                $transfer->status = 'approve';
                $transfer->authorised_at = Carbon::now();
                $transfer->authorised_by = $request->authorised_by;
                $transfer->comment = $request->comment;
                $transfer->save();

                $response = $this->cryptoCoinSend($transfer);

                // dd($response);

                if (count($response) > 0) {

                    $update = [

                        'response' => json_encode($response),
                        'status' => 'complete',
                    ];

                    Transfer::where('id', $transfer->id)->update($update);
                    \DB::commit();
                    return true;

                } else {
                    \DB::rollBack();
                    return false;
                }
            }

        } catch (Exception $e) {
            \DB::rollBack();
            //dd($e->getMessage());
            return false;
        }

    }
    public function cancelWithdraw($id, $request)
    {

        \DB::beginTransaction();
        try {

            $transfer = Transfer::where('id', $id)->first();
            if ($transfer->status == 'pending') {
                $transfer->status = 'cancel';

                $transfer->authorised_at = Carbon::now();
                $transfer->authorised_by = $request->authorised_by;
                $transfer->comment = $request->comment;
                $transfer->save();

                $accounting_code = 'crypto-withdraw-cancel-credit';

                $accounting_code = $this->getAccountingCode($accounting_code);

                $array = array();
                $balance_before = Transaction::BalanceBefore($transfer->user_id, $transfer->coin_id)->latest()->first();

                $balance_before = $balance_before->balance_after;
                $balance_after = $balance_before + $transfer->amount;

                $transaction = $this->createTransaction($transfer->user_id, $transfer->coin_id, $transfer->amount, "credit", "approve", "crypto-withdraw-cancel", $accounting_code, $request->comment, '', '', $transfer->id, get_class($transfer), $balance_before, $balance_after, "NULL", "NULL", $array);

            }

            \DB::commit();
            return $transaction;
        } catch (Exception $e) {
            \DB::rollBack();
            //  dd($e->getMessage());

        }
    }

    public function cryptoCoinSend($transfer)
    {
        //echo $transfer->currency->name;

        $response = [];
        try {

            $amount = sprintf("%.8f", $transfer->amount);
            if ($transfer->currency->name == 'BTC') {
                $from_address = env('WITHDRAW_BTC_ADDRESS');
                $fromaccount = CryptoPaymentBase::crypto_getaccount($from_address);

                $comment = "Send Coin";
                $comment_to = "Send Coin";
                $send_array['amount'] = $amount;
                $send_array['from_address'] = $from_address;
                $send_array['to_address'] = $transfer->to_address;
                $send_array['fromaccount'] = $fromaccount; //Bitcoind
                $send_array['comment'] = $comment;
                $send_array['comment_to'] = $comment_to;

                $response = CryptoPaymentBase::crypto_sendBTC($send_array);

            }
            if ($transfer->currency->name == 'LTC') {
                //dd("GG".$transfer);
                $from_address = env('WITHDRAW_LTC_ADDRESS');
                //dd($from_address);

                $fromaccount = CryptoPaymentBase::crypto_getLTCaccount($from_address);
                //dd($fromaccount);
                // 'dev.bcx.ba-64-user003-lLi1j52Yf5-2018-06-2714-20-37'

                $comment = "Send Coin";
                $comment_to = "Send Coin";
                $send_array['amount'] = $amount;
                $send_array['from_address'] = $from_address;
                $send_array['to_address'] = $transfer->to_address;
                $send_array['fromaccount'] = $fromaccount; //Litecoind
                $send_array['comment'] = $comment;
                $send_array['comment_to'] = $comment_to;
                //dd($send_array);
                $response = CryptoPaymentBase::crypto_sendLTC($send_array);
                // dd($response);

            }
            if ($transfer->currency->name == 'BCH') {
                $from_address = env('WITHDRAW_BCH_ADDRESS');
                $fromaccount = CryptoPaymentBase::crypto_getBCHaccount($from_address);

                $comment = "Send Coin";
                $comment_to = "Send Coin";
                $send_array['amount'] = $amount;
                $send_array['from_address'] = $from_address;
                $send_array['to_address'] = $transfer->to_address;
                $send_array['fromaccount'] = $fromaccount; //Bitcoind
                $send_array['comment'] = $comment;
                $send_array['comment_to'] = $comment_to;
                $response = CryptoPaymentBase::crypto_sendBCH($send_array);

            }
            if ($transfer->currency->name == 'ETH') {
                $from_address = env('WITHDRAW_ETH_ADDRESS');
                $eth_passphrase = env('WITHDRAW_ETH_PASS_PHRASE');
                $comment = "Send ETH";
                $comment_to = "Send ETH";
                $send_array['amount'] = $amount;
                $send_array['from_address'] = $from_address;
                $send_array['to_address'] = $transfer->to_address;
                $send_array['passphrase'] = $eth_passphrase;
                $response = CryptoPaymentBase::crypto_sendETH($send_array);
            }
            if ($transfer->currency->name == 'QTUM') {
                $from_address = env('WITHDRAW_QTUM_ADDRESS');
                $fromaccount = CryptoPaymentBase::crypto_getaccount($from_address);

                $comment = "Send Coin";
                $comment_to = "Send Coin";
                $send_array['amount'] = $amount;
                $send_array['from_address'] = $from_address;
                $send_array['to_address'] = $transfer->to_address;
                $send_array['fromaccount'] = $fromaccount; //Qtumd
                $send_array['comment'] = $comment;
                $send_array['comment_to'] = $comment_to;
                $response = CryptoPaymentBase::crypto_sendQTUM($send_array);

            }
            if ($transfer->currency->name == 'XRP') {
                $from_address = getenv('WITHDRAW_XRP_ADDRESS');
                $from_secret = getenv('WITHDRAW_XRP_SECRET');
                $client = new Client(getenv('XRP_URL'));

                $txParams = [
                    'TransactionType' => 'Payment',
                    'Account' => $from_address,
                    'Destination' => $transfer->to_address,
                    'Amount' => $transfer->amount * 1000000,
                    'Fee' => '12',
                ];

                $transaction = new \Gegosoft\Rippled\Api\Transaction($txParams, $client);

                $secret = $from_secret;
                $responses = $transaction->submit($secret, false);

                $response = $responses->getResult();

            }

            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            dd($e->getMessage());
        }

    }

}

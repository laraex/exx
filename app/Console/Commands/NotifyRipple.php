<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Models\Userpayaccounts;
use App\Traits\Common;
use App\Traits\TransactionProcess;
//use App\Traits\CashpointsProcess;
use Exception;
use Gegosoft\Rippled\Client;
use Illuminate\Console\Command;

class NotifyRipple extends Command
{
    use Common, TransactionProcess;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:walletnotifyripple';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ripple server wallet notify';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

//sowmi

    public function handle()
    {
        $array = [];
        $category1 = '';
        $account1 = '';
        $amount1 = '';

        $category2 = '';
        $account2 = '';
        $amount2 = '';
        $address2 = '';
        $pg = $this->getPgDetailsByGatewayName('xrp');

        $list = Userpayaccounts::where('paymentgateways_id', $pg->id)->orderby('id', 'ASC')->get();
        $client = new Client(getenv('XRP_URL'));

        foreach ($list as $key => $value) {
            $xrpaddress = $value->xrp_address;

            $request = $client->request('account_tx', [
                'account' => $xrpaddress, "binary" => false, "forward" => true, "ledger_index_max" => -1, "ledger_index_min" => -1, "limit" => 5,
            ]);

            // Now send the request to retrieve a response.
            $data = $request->send();
            $response = $data->getResult();

            if (count($response['transactions']) > 0) {
                foreach ($response['transactions'] as $key => $result) {
                    $txn_hash = $result['tx']['hash'];
                    if (!Transaction::where([['blockchain_transaction_id', $txn_hash], ['user_id', $value->user_id]])->exists()) {

                        $request = $client->request('tx', [
                            'transaction' => $result['tx']['hash'],
                        ]);

                        // Now send the request to retrieve a response.
                        $data_txn = $request->send();
                        $response_txn = $data_txn->getResult();

                        try {
                            $balance_before = 0;
                            $balance_after = 0;

                            if ($response_txn['Account'] == $xrpaddress) {
                                $type = 'debit';
                            } else {
                                $type = 'credit';
                            }
                            $amount1 = $response_txn['Amount'] * 0.0001 / 100;
                            $amount = $response_txn['Amount'];
                            $prev_details = Transaction::where([['status', 'approve'], ['currency_id', $value->currency_id], ['user_id', $value->user_id]])->latest()->first();
                            $balance_before = $prev_details->balance_after;

                            $txParams = [
                                'TransactionType' => 'Payment',
                                'Account' => $xrpaddress,
                                'Destination' => getenv('DEPOSIT_XRP_ADDRESS'),
                                'Amount' => $amount,
                                'Fee' => '12',
                            ];

                            $transaction = new \Gegosoft\Rippled\Api\Transaction($txParams, $client);

                            $secret = $value->xrp_secret;
                            $responses = $transaction->submit($secret, false);

                            $datares = $responses->getResult();
                            if ($datares['status'] == 'success') {
                                if ($response_txn['Account'] == $xrpaddress) {
                                    $type = 'debit';
                                    $balance_after = ($balance_before * 1000000) - $amount - $response_txn['Fee'];
                                } else {
                                    $balance_after = ($balance_before * 1000000) + $amount;
                                }
                            }
                            $balance_after = $balance_after * 0.0001 / 100;

                        } catch (Exception $e) {
                        }
                        if (getenv('DEPOSIT_XRP_ADDRESS') != $response_txn['Destination']) {
                            $transaction = $this->createTransaction($value->user_id, $value->currency_id, $amount1, $type, "approve", "cashpoint", "NULL", 'Notify', "NULL", "NULL", "NULL", "NULL", $balance_before, $balance_after, $txn_hash, json_encode($response_txn), $array);
                        }

                    }
                }
            }
        }

    }
}

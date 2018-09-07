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

class NotifyEth extends Command
{
    use Common, TransactionProcess;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:walletnotifyeth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ETH server wallet notify';

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

 public function handle()
    {
        $array = [];
         $response = [];
        $pg = $this->getPgDetailsByGatewayName('eth');

        $list = Userpayaccounts::where('paymentgateways_id', $pg->id)->orderby('id', 'ASC')->get();

        foreach ($list as $key => $value) {
            
        try{
            $from_address=$value->eth_address;
            $from_passphrase=$value->eth_passphrase;

             $balance_before = 0;
             $balance_after = 0;
           //Get Balance
           $balance = CryptoPaymentBase::crypto_getaccount($eth_address);
           if($balance>0){
           //Get Fee
           $fee=CryptoPaymentBase::crypto_calculateETHFee();

           $sendamount=$balance-$fee;
           $amount = sprintf("%.8f", $sendamount);

                $to_address = env('DEPOSIT_ETH_ADDRESS');
               $type='credit';
              //deposit address

                $comment = "Send ETH";
                $comment_to = "Send ETH";
                $send_array['amount'] = $amount;
                $send_array['from_address'] = $from_address;
                $send_array['to_address'] =$to_address;
                $send_array['passphrase'] =$from_passphrase;
                $response = CryptoPaymentBase::crypto_sendETH($send_array);

            $txn_hash=$response['txn_id'];

         $transaction = $this->createTransaction($value->user_id, $value->currency_id, $amount, $type, "pending", "cashpoint", "NULL", 'Notify', "NULL", "NULL", "NULL", "NULL", $balance_before, $balance_after, $txn_hash, json_encode($response), $array);
          }
        }
       catch (Exception $e) {
            dd($e->getMessage());
        }

        }

                 
    }
    
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\CoinTransactions;
use App\Traits\Common;
use App\Models\Userpayaccounts;
use Exception;

use Bitcoind;
use Litecoind;
use Bitcoincashd;

class TokenTransaction extends Command
{
    use Common;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:gettransactiontoken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Token Transaction Server';

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



        $pg = $this->getPgDetailsByGatewayName('eth');


        $list = Userpayaccounts::where('paymentgateways_id', $pg->id)->orderby('id', 'ASC')->get();

        foreach ($list as $key => $value) {
            $mode = env('ETH_MODE');
            $address = $value->eth_address;
            $apikey = getenv('ETH_ERC20_TOKEN_APIKEY');

            if ($mode == 'live') {
                $eth_mode = 'live';
                $url = 'http://api.etherscan.io/';
            } else {
                if (getenv('ETH_TEST_NETWORK') == 'rinkeby') {

                    $url = 'http://api-rinkeby.etherscan.io/';
                }
                if (getenv('ETH_TEST_NETWORK') == 'ropsten') {
                    $url = 'http://api-ropsten.etherscan.io/';
                }
                $eth_mode = 'test';

            }

            $url .= 'api?module=account&action=tokentx&address=' . $address . '&sort=asc&apikey=' . $apikey;

            $response = $this->getResponse($url);
            //dd($response);
            if (count($response) > 0) {
                foreach ($response['result'] as $txn => $res) {
                //dd($res['value']);
                    if (!CoinTransactions::where([['txid', $res['hash']], ['user_id', $value->user_id]])->exists()) {
                        $create = [
                            'user_id' => $value->user_id,
                            'paymentgateway_id' => $value->paymentgateways_id,
                            'txid' => $res['hash'],
                            'from_address' => $res['from'],
                            'to_address' => $res['to'],
                            'amount' => $res['value'],
                            'confirmations' => $res['confirmations'],
                            'network' => $eth_mode,
                            'token' => $res['tokenSymbol'],
                            'timeStamp' => $res['timeStamp'],
                            'time_stamp' => date('Y-m-d H:i:s', $res['timeStamp']),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];

                        $transaction = CoinTransactions::create($create);
                 // dd($transaction);
                    } else {
                   // break;
                    }
                }

            }
        }
    }
}



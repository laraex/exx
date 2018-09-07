<?php
namespace App\Console\Commands;

use App\CoinTransactions;
use App\Models\Userpayaccounts;
use App\Traits\Common;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class CoinTransaction extends Command
{
    use Common;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:gettransactions';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Coin Transaction';

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
        $coin = array('BTC', 'ETH', 'LTC', 'BCH', 'QTUM', 'RIPPLE');

        for ($i = 0; $i < count($coin); $i++) {
            if ($coin[$i] == 'BTC') {
                $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
            } elseif ($coin[$i] == 'LTC') {
                $pg = $this->getPgDetailsByGatewayName('ltc_blockio');
            } elseif ($coin[$i] == 'ETH') {

                $pg = $this->getPgDetailsByGatewayName('eth');

            } elseif ($coin[$i] == 'BCH') {
                $pg = $this->getPgDetailsByGatewayName('bch');
            }
            elseif ($coin[$i] == 'RIPPLE') {
              $pg = $this->getPgDetailsByGatewayName('xrp');
          }

            $list = Userpayaccounts::where('paymentgateways_id', $pg->id)->orderby('id', 'ASC')->get();

            //dd($list);

            foreach ($list as $key => $value) {
                //dd($value->user_id);
                //Start BTC
                if ($coin[$i] == 'BTC') {

                    $mode_btc = env('BTC_MODE');
                    $address = $value->btc_address;

                    $transaction_type = array('receive', 'spend');

                    //dd($address);

                    foreach ($transaction_type as $type) {
                        $url = '';
                        $from_address = '';
                        $to_address = '';
                        $amount = 0;
                        //  dd($mode_btc);
                        if ($mode_btc == 'live') {
                            $mode = 'BTC';
                            $btc_mode = 'live';
                            $url = 'https://chain.so/';
                        } else {
                            $mode = 'BTCTEST';
                            $btc_mode = 'test';
                            $url = 'https://chain.so/';
                        }
                        if ($type == 'spend') {
                            $url_final = $url . 'api/v2/get_tx_spent/' . $mode . '/' . $address;
                        } else if ($type == 'receive') {
                            $url_final = $url . 'api/v2/get_tx_received/' . $mode . '/' . $address;
                        }
                        // dd($url_final);

                        $response = $this->getResponse($url_final);
                        //dd($response);

                        if (count($response) > 0) {
                            foreach ($response['data']['txs'] as $result) {
                                if (!CoinTransactions::where([['txid', $result['txid']], ['user_id', $value->user_id]])->exists()) {
                                    //dd($result);
                                    //dd($response);
                                    // $url_txn=$url.'/api/v2/get_tx/'.$mode.'/'.$result['txid'];
                                    $url_txn = $url . '/api/v2/get_tx/' . $mode . '/' . $result['txid'];
                                    $response_txn = $this->getResponse($url_txn);
                                    //dd($response_txn);

                                    try
                                    {
                                        //   $count=$response_txn['data']['inputs'][0]['from_output']['output_no'];
                                        $count = $result['output_no'];

                                        $from_address = $response_txn['data']['inputs'][0]['address'];
                                        $to_address = $response_txn['data']['outputs'][$count]['address'];
                                        $amount = $response_txn['data']['outputs'][$count]['value'];

                                        /*if ($type == 'spend')
                                    {

                                    $count=$response_txn['data']['inputs'][0]['from_output']['output_no'];

                                    $from_address=$response_txn['data']['inputs'][0]['address'];
                                    $to_address=$response_txn['data']['outputs'][$count]['address'];
                                    $amount=$response_txn['data']['outputs'][$count]['value'];

                                    }
                                    if ($type == 'receive')
                                    {
                                    $count=0;

                                    $from_address=$response_txn['data']['inputs'][0]['address'];
                                    $to_address=$response_txn['data']['outputs'][$count]['address'];
                                    $amount=$response_txn['data']['outputs'][$count]['value'];
                                    }*/
                                    } catch (Exception $e) {

                                    }

                                    $create = [
                                        'user_id' => $value->user_id,
                                        'paymentgateway_id' => $value->paymentgateways_id,
                                        'txid' => $result['txid'],
                                        'from_address' => $from_address,
                                        'to_address' => $to_address,
                                        'confirmations' => $result['confirmations'],
                                        'amount' => $amount,
                                        'network' => $btc_mode,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                    ];

                                    //dd($create);

                                    // $transaction = CoinTransactions::create($create);
                                    if ($amount > 0) {
                                        $transaction = CoinTransactions::create($create);
                                    }
                                }
                            }
                        }
                    }
                }
                //End BTC

                //Start LTC
                else if ($coin[$i] == 'LTC') {
                    $mode_ltc = env('LTC_MODE');
                    $address = $value->ltc_address;

                    $transaction_type = array('receive', 'spend');

                    foreach ($transaction_type as $type) {
                        $url = '';

                        if ($mode_ltc == 'live') {
                            $mode = 'LTC';
                            $ltc_mode = 'live';
                            $url = 'https://chain.so/';
                        } else {
                            $mode = 'LTCTEST';
                            $ltc_mode = 'test';
                            $url = 'https://chain.so/';
                        }

                        if ($type == 'spend') {
                            $url_final = $url . 'api/v2/get_tx_spent/' . $mode . '/' . $address;
                        } else if ($type == 'receive') {
                            $url_final = $url . 'api/v2/get_tx_received/' . $mode . '/' . $address;
                        }

                        $response = $this->getResponse($url_final);

                        if (count($response) > 0) {
                            foreach ($response['data']['txs'] as $result) {

                                if (!CoinTransactions::where([['txid', $result['txid']], ['user_id', $value->user_id]])->exists()) {

                                    $url_txn = $url . '/api/v2/get_tx/' . $mode . '/' . $result['txid'];
                                    $response_txn = $this->getResponse($url_txn);

                                    try
                                    {
                                        /*if ($type == 'spend')
                                        {

                                        $count=$response_txn['data']['inputs'][0]['from_output']['output_no'];

                                        $from_address=$response_txn['data']['inputs'][0]['address'];
                                        $to_address=$response_txn['data']['outputs'][$count]['address'];
                                        $amount=$response_txn['data']['outputs'][$count]['value'];

                                        }
                                        if ($type == 'receive')
                                        {
                                        $count=0;

                                        $from_address=$response_txn['data']['inputs'][0]['address'];
                                        $to_address=$response_txn['data']['outputs'][$count]['address'];
                                        $amount=$response_txn['data']['outputs'][$count]['value'];
                                        }*/
                                        $count = $result['output_no'];

                                        $from_address = $response_txn['data']['inputs'][0]['address'];
                                        $to_address = $response_txn['data']['outputs'][$count]['address'];
                                        $amount = $response_txn['data']['outputs'][$count]['value'];
                                    } catch (Exception $e) {

                                    }

                                    $create = [
                                        'user_id' => $value->user_id,
                                        'paymentgateway_id' => $value->paymentgateways_id,
                                        'txid' => $result['txid'],
                                        'from_address' => $from_address,
                                        'to_address' => $to_address,
                                        'confirmations' => $result['confirmations'],
                                        'amount' => $amount,
                                        'network' => $ltc_mode,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now(),
                                    ];

                                    if ($amount > 0) {
                                        $transaction = CoinTransactions::create($create);
                                    }
                                }
                            }
                        }
                    }
                }
                //End LTC

                //start ETH
                else if ($coin[$i] == 'ETH') {
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

                    $url .= 'api?module=account&action=txlist&address=' . $address . '&sort=asc&apikey=' . $apikey;

                    $response = $this->getResponse($url);
                    //dd($response);
                    if (count($response) > 0) {
                        foreach ($response['result'] as $txn => $res) {
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
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ];

                                $transaction = CoinTransactions::create($create);
                            }
                        }
                    }
                } //End ETH

                //start BCH
                else if ($coin[$i] == 'BCH') {
                    $mode_bch = env('BCH_MODE');
                    $bchaddress = $value->bch_address;

                    $address = str_replace("bchtest:", "", $bchaddress);

                    //$address = str_replace(BCH_PREFIX,"",$bchaddress);

                    if ($mode_bch == 'live') {
                        $bch_mode = 'live';
                        $url = 'https://bch-insight.bitpay.com/';

                    } else {
                        $bch_mode = 'test';
                        $url = 'https://test-bch-insight.bitpay.com/';

                    }

                    $url_final = $url . 'api/addrs/' . $address . '/utxo';

                    $response = $this->getResponse($url_final);

                    if (count($response) > 0) {
                        foreach ($response as $key => $result) {
                            if (!CoinTransactions::where([['txid', $result['txid']], ['user_id', $value->user_id]])->exists()) {
                                $bch_url = $url . 'api/tx/' . $result['txid'];

                                $response_txn = $this->getResponse($bch_url);
                                // dd($response_txn);
                                try
                                {
                                    // $count=count($response_txn['vout'])-1;
                                    $count = $result['vout'];

                                    $from_address = $response_txn['vin'][0]['addr'];
                                    $to_address = $response_txn['vout'][$count]['scriptPubKey']['addresses'][0];
                                    $amount = $response_txn['vout'][$count]['value'];
                                } catch (Exception $e) {

                                }

                                $create = [
                                    'user_id' => $value->user_id,
                                    'paymentgateway_id' => $value->paymentgateways_id,
                                    'txid' => $result['txid'],
                                    'from_address' => $from_address,
                                    'to_address' => $to_address,
                                    'confirmations' => $result['confirmations'],
                                    'amount' => $amount,
                                    'network' => $bch_mode,
                                    'timeStamp' => $response_txn['time'],
                                    'time_stamp' => date('Y-m-d H:i:s', $response_txn['time']),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ];
                                if ($amount > 0) {
                                    $transaction = CoinTransactions::create($create);
                                }
                            }
                        }
                    }
                }
                //end BCH
                //start QTUm
                else if ($coin[$i] == 'QTUM') {
                    $mode_qtum = env('QTUM');
                    $qtumaccount = $value->qtum_lable;
                    //  $address = str_replace("bchtest:","","qz6zkt0grmj2ec82z63glj97mt2a7p06nvja7n2fpr");
                    $url = "http://" . getenv('QTUMD_USER') . ":" . getenv('QTUMD_PASSWORD') . "@" . getenv('QTUMD_HOST') . ":" . getenv('QTUMD_PORT');
                    $data = '{
               "jsonrpc": "1.0", "id":"curltest", "method": "listtransactions", "params": ["' . $qtumaccount . '"]
           }';

                    $response = $this->getPostResponse($url, $data);

                    if (count($response['result']) > 0) {
                        foreach ($response['result'] as $key => $result) {
                            if (!CoinTransactions::where([['txid', $result['txid']], ['user_id', $value->user_id]])->exists()) {
                                $url_txn = "http://" . getenv('QTUMD_USER') . ":" . getenv('QTUMD_PASSWORD') . "@" . getenv('QTUMD_HOST') . ":" . getenv('QTUMD_PORT');
                                $data_txn = '{
                      "jsonrpc": "1.0", "id":"curltest", "method": "gettransaction", "params": ["' . $result['txid'] . '"]
                  }';
                                $response_txn = $this->getPostResponse($url_txn, $data_txn);

                                try {

                                    $count = $result['vout'];
                                    $from_address = '';
                                    if (count($response_txn['result']['details']) > 1) {
                                        $to_address = $response_txn['result']['details'][1]['address'];
                                        $amount = $response_txn['result']['details'][1]['amount'];
                                    } else if (count($response_txn['result']['details']) == 1) {
                                        $to_address = $response_txn['result']['details'][0]['address'];
                                        $amount = $response_txn['result']['details'][0]['amount'];
                                    } else {
                                        $from_address = $response_txn['result']['details'][0]['address'];
                                    }
                                } catch (Exception $e) {
                                }
                                $create = [
                                    'user_id' => $value->user_id,
                                    'paymentgateway_id' => $value->paymentgateways_id,
                                    'txid' => $result['txid'],
                                    'from_address' => $from_address,
                                    'to_address' => $to_address,
                                    'confirmations' => $result['confirmations'],
                                    'amount' => $amount,
                                    'network' => $mode_qtum,
                                    'timeStamp' => $response_txn['result']['time'],
                                    'time_stamp' => date('Y-m-d H:i:s', $response_txn['result']['time']),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ];
                                if ($amount > 0) {
                                    $transaction = CoinTransactions::create($create);
                                }
                            }
                        }
                    }
                }
                //end QTUM
                 //start Ripple
                 else if ($coin[$i] == 'RIPPLE') {
                  $mode_xrp = 'test';
                  $xrpaddress = $value->xrp_address;
                  //  $address = str_replace("bchtest:","","qz6zkt0grmj2ec82z63glj97mt2a7p06nvja7n2fpr");
                  $url = "https://s.altnet.rippletest.net:51234";
                  $data = '{
                    "method": "account_tx",
                    "params": [
                        {
                            "account": "'.$xrpaddress.'",
                            "binary": false,
                            "forward": false,
                            "ledger_index_max": -1,
                            "ledger_index_min": -1,
                            "limit": 5
                        }
                    ]
                }';

                  $response = $this->getPostResponse($url, $data);

                  if (count($response['result']['transactions']) > 0) {
                      foreach ($response['result']['transactions'] as $key => $result) {
                          if (!CoinTransactions::where([['txid', $result['tx']['hash']], ['user_id', $value->user_id]])->exists()) {
                              $url_txn = "https://s.altnet.rippletest.net:51234";
                              $data_txn = '{
                                "method": "tx",
                                "params": [
                                    {
                                        "transaction": "'.$result['tx']['hash'].'",
                                        "binary": false
                                    }
                                ]
                            }';
                              $response_txn = $this->getPostResponse($url_txn, $data_txn);

                              try {
                                      $to_address = $response_txn['result']['Destination'];
                                      $amount = $response_txn['result']['Amount'];
                                 
                                      $from_address = $response_txn['result']['Account'];
                              } catch (Exception $e) {
                              }
                              $create = [
                                  'user_id' => $value->user_id,
                                  'paymentgateway_id' => $value->paymentgateways_id,
                                  'txid' => $result['tx']['hash'],
                                  'from_address' => $from_address,
                                  'to_address' => $to_address,
                                  'confirmations' => $result['tx']['Flags'],
                                  'amount' => $amount,
                                  'network' => $mode_xrp,
                                  'timeStamp' => $response_txn['result']['date'],
                                  'time_stamp' => date('Y-m-d H:i:s', $response_txn['result']['date']),
                                  'created_at' => Carbon::now(),
                                  'updated_at' => Carbon::now(),
                              ];
                              if ($amount > 0) {
                                  $transaction = CoinTransactions::create($create);
                              }
                          }
                      }
                  }
              }
              //end Ripple
            }
        }
    }
}
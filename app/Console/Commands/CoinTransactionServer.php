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
use Qtumd;

class CoinTransactionServer extends Command
{
  use Common;
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'exchange:gettransactionserver';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Coin Transaction Server';

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




    $coin = array('BTC', 'LTC', 'BCH', 'QTUM', 'RIPPLE');

    for ($i = 0; $i < count($coin); $i++) {
      if ($coin[$i] == 'BTC') {
        $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');

      } elseif ($coin[$i] == 'LTC') {
        $pg = $this->getPgDetailsByGatewayName('ltc_blockio');
      } elseif ($coin[$i] == 'ETH') {
        $pg = $this->getPgDetailsByGatewayName('eth');
      } elseif ($coin[$i] == 'BCH') {
        $pg = $this->getPgDetailsByGatewayName('bch');
      } elseif ($coin[$i] == 'QTUM') {
        $pg = $this->getPgDetailsByGatewayName('qtum');
      }
      elseif($coin[$i]=='RIPPLE'){
        $pg = $this->getPgDetailsByGatewayName('xrp');
      }


      $list = Userpayaccounts::where('paymentgateways_id', $pg->id)->orderby('id', 'ASC')->get();

      foreach ($list as $key => $value) {
        //Start BTC
        if ($coin[$i] == 'BTC') {
          $mode_btc = env('BTC_MODE');
          if ($mode_btc == 'live') {
            $btc_mode = 'live';
          } else {
            $btc_mode = 'test';
          }
          $address = $value->btc_address;
          $account = $value->btc_label;


          $amount = 0;


          try {

            $blockInfo = Bitcoind::listtransactions($account);
            $response = response()->json($blockInfo->get());


            if (count($response->original) > 0) {
              foreach ($response->original as $result) {
                if (!CoinTransactions::where([['txid', $result['txid']], ['user_id', $value->user_id]])->exists()) {


                  $category = $result['category'];

                  $amount = abs($result['amount']);
                  if ($category == 'receive') {

                    $txn_details = Bitcoind::gettransaction($result['txid']);
                    $txn_details_res = response()->json($txn_details->get());
                    if (count($txn_details_res) > 0) {

                      $cat = $txn_details_res->original['details'][0]['category'];
                      if ($cat == 'send') {
                        $to_address = $txn_details_res->original['details'][0]['address'];
                        $from_account = $txn_details_res->original['details'][0]['account'];

                        $from_acc = Bitcoind::getaddressesbyaccount($from_account);

                        $fromaddress = response()->json($from_acc->get());
                        $from_address = str_replace('"', '', $fromaddress->getContent());
                        $from_address = str_replace('[', '', $from_address);
                        $from_address = str_replace(']', '', $from_address);

                      }
                    }

                  }

                  if ($category == 'send') {
                    $to_address = $result['address'];
                    $from_address = $address;
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
                    'timeStamp' => $result['time'],
                    'time_stamp' => date('Y-m-d H:i:s', $result['time']),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                  ];
                  if ($amount > 0) {
                    $transaction = CoinTransactions::create($create);
                  }
                      
                     
                      

                       
                      // dd($transaction);
                } else {
                  $update = [
                    'confirmations' => $result['confirmations'],

                  ];
                  $transaction = CoinTransactions::where('txid', $result['txid'])->update($update);
                }

              }
            }

          } catch (Exception $e) {

          }

        }
        //End BTC

        //Start LTC
        else if ($coin[$i] == 'LTC') {
          $mode_ltc = env('LTC_MODE');
          if ($mode_ltc == 'live') {
            $ltc_mode = 'live';
          } else {
            $ltc_mode = 'test';
          }
          $address = $value->ltc_address;
          $account = $value->ltc_label;


          $amount = 0;


          try {

            $blockInfo = Litecoind::listtransactions($account);
            $response = response()->json($blockInfo->get());
                //dd($response);

            if (count($response->original) > 0) {
              foreach ($response->original as $result) {
                if (!CoinTransactions::where([['txid', $result['txid']], ['user_id', $value->user_id]])->exists()) {


                  $category = $result['category'];

                  $amount = abs($result['amount']);
                  if ($category == 'receive') {
                    $txn_details = Litecoind::gettransaction($result['txid']);
                    $txn_details_res = response()->json($txn_details->get());
                    if (count($txn_details_res) > 0) {

                      $cat = $txn_details_res->original['details'][0]['category'];
                      if ($cat == 'send') {
                        $to_address = $txn_details_res->original['details'][0]['address'];
                        $from_account = $txn_details_res->original['details'][0]['account'];

                        $from_acc = Litecoind::getaddressesbyaccount($from_account);

                        $fromaddress = response()->json($from_acc->get());
                        $from_address = str_replace('"', '', $fromaddress->getContent());
                        $from_address = str_replace('[', '', $from_address);
                        $from_address = str_replace(']', '', $from_address);

                      }
                    }
                  }

                  if ($category == 'send') {
                    $to_address = $result['address'];
                    $from_address = $address;
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
                    'timeStamp' => $result['time'],
                    'time_stamp' => date('Y-m-d H:i:s', $result['time']),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                  ];
                  if ($amount > 0) {
                    $transaction = CoinTransactions::create($create);
                  }
                      
                     
                      

                       
                      // dd($transaction);
                } else {
                  $update = [
                    'confirmations' => $result['confirmations'],

                  ];
                  $transaction = CoinTransactions::where('txid', $result['txid'])->update($update);
                }

              }
            }

          } catch (Exception $e) {

          }
        }
        //End LTC

        
         //start BCH
        else if ($coin[$i] == 'BCH') {
          $mode_bch = env('BCH_MODE');
          if ($mode_bch == 'live') {
            $bch_mode = 'live';
          } else {
            $bch_mode = 'test';
          }
          $address = $value->bch_address;
          $account = $value->bch_label;
          $address = str_replace(BCH_PREFIX, "", $address);

          $amount = 0;


          try {

            $blockInfo = Bitcoincashd::listtransactions($account);
            $response = response()->json($blockInfo->get());
                //dd($response);

            if (count($response->original) > 0) {
              foreach ($response->original as $result) {
                if (!CoinTransactions::where([['txid', $result['txid']], ['user_id', $value->user_id]])->exists()) {


                  $category = $result['category'];

                  $amount = abs($result['amount']);
                  if ($category == 'receive') {
                    $txn_details = Bitcoincashd::gettransaction($result['txid']);
                    $txn_details_res = response()->json($txn_details->get());
                    if (count($txn_details_res) > 0) {

                      $cat = $txn_details_res->original['details'][0]['category'];
                      if ($cat == 'send') {
                        $to_address = $txn_details_res->original['details'][0]['address'];
                        $to_address = str_replace(BCH_PREFIX, "", $to_address);
                        $from_account = $txn_details_res->original['details'][0]['account'];

                        $from_acc = Bitcoincashd::getaddressesbyaccount($from_account);

                        $fromaddress = response()->json($from_acc->get());
                        $from_address = str_replace('"', '', $fromaddress->getContent());
                        $from_address = str_replace('[', '', $from_address);
                        $from_address = str_replace(']', '', $from_address);
                        $from_address = str_replace(BCH_PREFIX, "", $from_address);

                      }
                    }


                  }

                  if ($category == 'send') {
                    $to_address = $result['address'];
                    $to_address = str_replace(BCH_PREFIX, "", $to_address);
                    $from_address = $address;
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
                    'timeStamp' => $result['time'],
                    'time_stamp' => date('Y-m-d H:i:s', $result['time']),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                  ];
                  if ($amount > 0) {
                    $transaction = CoinTransactions::create($create);
                  }
                      
                     
                      

                       
                      // dd($transaction);
                } else {
                  $update = [
                    'confirmations' => $result['confirmations'],

                  ];
                  $transaction = CoinTransactions::where('txid', $result['txid'])->update($update);
                }

              }
            }

          } catch (Exception $e) {

          }
        }
        //end BCH
         //start QTUm
        else if ($coin[$i] == 'QTUM') {
          $mode_qtum = env('QTUM');
          $address = $value->qtum_address;
          $account = $value->qtum_label;
     
            
            $amount=0;
            
        
          try{
              
                 $blockInfo = Qtumd::listtransactions($account);
                 $response= response()->json($blockInfo->get());
                //dd($response);

                if(count($response->original)>0) 
                {
                  foreach ($response->original as  $result) 
                  {
                       if(!CoinTransactions::where([['txid',$result['txid']],['user_id',$value->user_id]])->exists())
                    {
                          
                      
                        $category=$result['category'];
                       
                        $amount=abs($result['amount']);
                        if($category=='receive')
                        {
                             $txn_details = Qtumd::gettransaction($result['txid']);
                             $txn_details_res= response()->json($txn_details->get());
                             if(count($txn_details_res)>0)
                             {

                              $cat=$txn_details_res->original['details'][0]['category'];
                              if($cat=='send')
                                {
                                   $to_address=$txn_details_res->original['details'][0]['address'];
                                   $from_account=$txn_details_res->original['details'][0]['account'];

                                   $from_acc = Qtumd::getaddressesbyaccount($from_account);
                                
                                   $fromaddress=response()->json($from_acc->get());
                                   $from_address=str_replace('"','',$fromaddress->getContent());
                                   $from_address=str_replace('[','',$from_address);
                                   $from_address=str_replace(']','',$from_address);

                                }
                             }
                        }
                        
                        if($category=='send')
                        {
                             $to_address=$result['address'];
                             $from_address=$address;
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
                        'timeStamp'=>$result['time'],   
                        'time_stamp'=>date('Y-m-d H:i:s',$result['time']),  
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                      ];
                      if($amount>0)
                      {
                            $transaction = CoinTransactions::create($create);
                      }
                      
                     
                      

                       
                      // dd($transaction);
                    }
                    else
                    {
                        $update=[
                            'confirmations' => $result['confirmations'],

                        ];
                         $transaction = CoinTransactions::where('txid',$result['txid'])->update($update);
                    }
                   
                  }   
                }

            }
            catch(Exception $e)
            {

            }  
        }
         //end QTUM
          //start Ripple
          else if ($coin[$i] == 'RIPPLE') {
            $mode_xrp = 'test';
            $xrpaddress = $value->xrp_address;
            $client = new Client(getenv('XRP_URL'));
            //  $address = str_replace("bchtest:","","qz6zkt0grmj2ec82z63glj97mt2a7p06nvja7n2fpr");
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
                                $to_address = $response_txn['Destination'];
                                $amount = $response_txn['Amount'];
                           
                                $from_address = $response_txn['Account'];
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



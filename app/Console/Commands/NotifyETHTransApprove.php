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
use App\Http\Controllers\CryptoPayment\CryptoPaymentBase;

class NotifyETHTransApprove extends Command
{
    use Common, TransactionProcess;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchanger:walletnotifyethapprove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ETH Transaction server wallet approve notify';

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
         $response = [];
        $pg = $this->getPgDetailsByGatewayName('eth');
        $trans_list = Transaction::where([['status', 'pending'], ['currency_id', $pg->currency_id]])->get();
          
       foreach($trans_list as $trans){
        
        $mode=env('ETH_MODE');
        $apikey=getenv('ETH_ERC20_TOKEN_APIKEY');
         $tran_details=json_decode($trans->blockchain_data,true);

         $from_address=$tran_details['from'];

                             if ($mode=='live') {
                                     $url = 'http://api.etherscan.io/';
                             } else {
                                 $url = 'http://api-rinkeby.etherscan.io/';
                             }

                             $url.='api?module=account&action=txlist&address='.$from_address.'&sort=asc&apikey='.$apikey;

                             $response = $this->getResponse($url);

                             if(count($response)>0)
                             {
                               foreach($response['result'] as $key=>$res)
                               {
                                 if($trans->blockchain_transaction_id==$res['hash'])

                                 {
                                        if($v['confirmations']>=env('ETH_MIN_CONF'))
                                        {
                                            

                                             $prev_details = Transaction::where([['status', 'approve'], ['currency_id', $pg->currency_id], ['user_id', $trans->user_id]])->latest()->first();

                            $balance_before = $prev_details->balance_after;

                             $balance_after = $balance_before+$res['value'];

                                    $update['status']='approve';
                                    $update['balance_before']=$balance_before;
                                    $update['balance_after']=$balance_after;
                                             
                                             Transaction::where('id',$trans->id)->update($update);

                                           

                                        }

                                 }
                               }
                             }



           }



                       


                 
    }
    
}

<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Traits\Common;
use Exception;
use Bitcoincashd;
use App\Http\Controllers\CryptoPayment\CryptoPaymentBase;
use App\Models\Userpayaccounts;
use App\Traits\TransactionProcess;
use App\Models\Transaction;
class CheckBitcoincashdTransaction extends Command
{
    use Common,TransactionProcess;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchanger:checkbchtransaction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Bitcoincashd Transaction';

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
        try{
        $currency_id=$this->getCurrencyId('BCH');

        $list=Transaction::where([['status','pending'],['currency_id',$currency_id]])->get();
        foreach($list as $key=>$txn)
        {


              $blockInfo = Bitcoincashd::gettransaction($txn->blockchain_transaction_id);
              $response= response()->json($blockInfo->get());
              $confirmations=$response->original['confirmations'];

              if($confirmations>=env('BCH_MIN_CONF'))
              {

                        $prev_details=Transaction::where([['status','approve'],['currency_id',$currency_id],['user_id',$txn->user_id]])->latest()->first();

                        $details=Userpayaccounts::where([['user_id',$txn->user_id],['currency_id',$currency_id]])->whereNotNull('bch_label')->first();

                         $fromaccount=$details->bch_label;
                         $balance_before=$prev_details->balance_after;
                         if($txn->type=='credit')
                         {
                            $balance_after=$balance_before+($txn->amount);
                         }
                         if($txn->type=='debit')
                         {
                            $balance_after=$balance_before-($txn->amount);
                         }

                         $toaccount=CryptoPaymentBase::crypto_getBCHaccount(env('DEPOSIT_BCH_ADDRESS'));

                       
                         $balance=$txn->amount;

                          $array=array();
                          $array['fromaccount']=$fromaccount;
                          $array['toaccount']=$toaccount;
                          $array['amount']=$balance;
                          $array['comment']='Cash In';
                          $response=CryptoPaymentBase::crypto_moveBCH($array);
                     

                      if(count($response)>0)
                      {
                         

                          $update=[
                             'status'=>'approve',
                             'balance_before'=>$balance_before,
                             'balance_after'=>$balance_after
                          ];
                          Transaction::where([['status','pending'],['currency_id',$currency_id],['blockchain_transaction_id',$txn->blockchain_transaction_id]])->update($update);
                     }



              }
        }
      }
      catch(Exception $e)
      {
        //dd($e->getMessage());
      }

        
    }
}



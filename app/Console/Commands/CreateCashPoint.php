<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\Common;
use Exception;
use App\Traits\TransactionProcess;
use App\Models\Transaction;
class CreateCashPoint extends Command
{
    use Common,TransactionProcess;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchanger:createcashpoint';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Cashpoint';

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
    
            $user_id = $this->ask('Enter the User id');
            $currency_id = $this->ask('Enter the Currency id');
            $amount = $this->ask('Enter the Amount');
            $comment="Test Point";
            $array=array();
            $balance_before=Transaction::BalanceBefore($user_id,$currency_id)->latest()->first();

                    
              $balance_before= $balance_before->balance_after;
              $balance_after= $balance_before+$amount;
                      
              $transaction=$this->createTransaction($user_id,$currency_id,$amount,"credit","approve","deposit",'NULL',$comment,'','','','',$balance_before,$balance_after,"NULL","NULL", $array);
        }
      
      catch(Exception $e)
      {
        dd($e->getMessage());
      }

        
    }
}



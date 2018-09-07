<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\TradeOrders;
use App\Traits\TradeOrdersProcess;
use App\Jobs\TradeOrdersJob;

class CheckTradeOrders extends Command
{
    use TradeOrdersProcess;
  
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchanger:checktradeorders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Trade Orders';

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
       
      //  $orders=TradeOrders::where('status','pending')->orderby('order_at','ASC')->get();//DESC if check-last order -old
      //  $orders=TradeOrders::where('status','pending')->orderby('id','ASC')->get();//DESC if check-last order
       // $orders=TradeOrders::where('status','pending')->where('id',10)->orderby('id','ASC')->get();//DESC if check-last order
        $orders=TradeOrders::where('status','pending')->orderby('id','DESC')->get();//DESC if check-last order
        foreach($orders as $key=>$value)
        {
               $this->checkTradeOrder($value);exit;
               $job = (new TradeOrdersJob($value));
             dispatch($job)->onQueue('order'); 

        }
      
        // exit;
            
                
      
           
           
               //  $this->checkTradeOrder($orders);
               
                         
  


     
        }

            
  

       
        
    

}
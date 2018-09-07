<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TradeOrders;
use App\Traits\TradeOrdersProcess;
use App\TradeCurrencyPair;
use App\Jobs\TradeOrdersJob;
use Carbon\Carbon;
class CreateOrders extends Command
{
          use TradeOrdersProcess;
  
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchanger:createorders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Orders';

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
        $orderchoice=$this->choice('What type of Order ?', ['Buy', 'Sell']);

        $count = $this->ask('No. of Orders (Count as Number) ');

        $user_id = $this->ask('Enter the User Id  ');         


         // $tradepair=TradeCurrencyPair::where('status','active')->get();
         // foreach($tradepair as $key=>$value)
         // {
         //    $res[$key]['id']=$value->id;
         //    $res[$key]['pair']=$value->CurrencyPair;
         // }
        
         // print_r( $res);

                 $pair_id = $this->ask('Enter the Pair Id');
                 $price = $this->ask('Enter the Price');
                 $quantity = $this->ask('Enter the Quantity');
                 $pair_details = TradeCurrencyPair::where('id',$pair_id)->first();

               

            for ($i=0; $i < $count; $i++) { 

                $updatedprice = $price + $i *  $price * 0.001;

                 $total= $updatedprice * $quantity;
                 $fee_total=($pair_details->fee/100)*$total;
             
                 $request=[ 
                          'amount'=>$updatedprice,                           
                          'volume'=> $quantity
                            ];
                     $request['fee']=$pair_details->fee;
                     $request['fee_total']=$fee_total;

                 if($orderchoice === "Buy" )
                 {
                    $this->info('Creating Buy Orders ... ');
                    $type='buy';
                    $request['from_coin_id']=$pair_details->from_currency_id;
                    $request['to_coin_id']=$pair_details->to_currency_id;
                    $total_amount=$total+$fee_total;
                 }
                if( $orderchoice === "Sell" )
                 {
                    $this->info('Creating Sell Orders ... ');
                    $type='sell';
                    $request['from_coin_id']=$pair_details->to_currency_id;
                    $request['to_coin_id']=$pair_details->from_currency_id;
                    $total_amount=$total-$fee_total;
                 }

                 $request['total_amount']=$total_amount;

                 //$req=(object)$request;
                 
                 $request=(object)$request;
                
                 dump($request);

                   $create=[
                            'user_id'=>$user_id,                                                     
                            'amount'=>$request->amount,                           
                            'quantity'=>$request->volume,
                            'from_coin_id'=>$request->from_coin_id,
                            'to_coin_id'=>$request->to_coin_id,
                            'status'=>'pending',
                            'type'=>$type,
                            'order_at'=>Carbon::now(),
                            'total_amount'=>$request->total_amount, 
                            'fee'=>$request->fee,                                   
       
                        ];
                     $create['fee_total']=$request->fee_total; 
                    // dd($create);
                       $trade=TradeOrders::create($create); 
                       $job = (new TradeOrdersJob($trade))->onQueue('order');
                       dispatch($job);        
            }
     
        }
}
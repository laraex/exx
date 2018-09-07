<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\TradeTestUserProcess;

use App\User;
use App\Traits\Common;
use App\Traits\PlacementProcessor;
use App\Traits\RegistersNewUser;
use App\TradeOrders;
use App\TradeCurrencyPair;

class CreateTradeUserOrders extends Command
{
    use  TradeTestUserProcess,RegistersNewUser,PlacementProcessor;
  
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchanger:tradeuserorders {--sponsor=0} {--count=1}  {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Trade User Orders';

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
       
        $fundamount=10000;
            
        $count = $this->option('count');
        $count = intval($count);
        $sponsor = $this->option('sponsor');
        $sponsor = intval($sponsor);


         $pair_id = $this->ask('Enter the Pair Id');
         $price = $this->ask('Enter the Price');
         $quantity = $this->ask('Enter the Quantity');
         $pair_details = TradeCurrencyPair::where('id',$pair_id)->first();

     
        for ($i=0; $i < $count; $i++) { 

        if($count > 1) {
             $username = $this->argument('username').$i;
        }else {
             $username = $this->argument('username');
        }
      
        $sponsorid ='';
          
        if($sponsor==1) {
            $sponsor_id = $this->ask('Enter the sponsor id');
           
        }
        else
        {
           

         $default_sponsor=$this->getSettingValue('default_sponsor');  
         $root  = User::where('email', $default_sponsor)->first();
         $sponsor_id = $root->id;

        }


       


          $updatedprice = $price + $i *  $price * 0.001;

                 $total= $updatedprice * $quantity;
                 $fee_total=($pair_details->fee/100)*$total;
             
                  $request=[ 
                          'amount'=>$updatedprice,                           
                          'volume'=> $quantity
                            ];
                     $request['fee']=$pair_details->fee;
                     $request['fee_total']=$fee_total;                  
                    $type='buy';
                    $request['from_coin_id']=$pair_details->from_currency_id;
                    $request['to_coin_id']=$pair_details->to_currency_id;
                    $total_amount=$total+$fee_total;
                    $request['total_amount']=$total_amount;

                 
                 $trade_request=(object)$request;


                $user = $this->createTestUser($username,$sponsor_id); 
                $userprofile = $this->createTestUserProfile($user); 
                $userinformation = $this->createTestUserInformation($user); 
                $useraccount= $this->createTestUserCurrencyAccount($user,$fundamount); 

              

                $this->info("New user added {$user->name}! - User Id : {$user->id}");

                

                $trade=$this->createTestTradeOrder($user->id,$trade_request,$type);
                $this->info('Creating Buy Orders ... ');
                dump($trade_request);


   

                $placement = $this->processPlacement($user);

             //   $this->createBTCWallet($user);


                       
           
              
   
       

        }    
                         
  


     
    }

            
  

       
        
    

}
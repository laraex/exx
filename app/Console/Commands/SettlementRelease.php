<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\Common;
use App\Traits\TransactionProcess;
use App\Settlement;
use App\Traits\SettlementProcess;
use App\Transfer;
class SettlementRelease extends Command
{
    use TransactionProcess,Common,SettlementProcess;
  
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchanger:settlementrelease';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Release a Settlement';

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

        $lists=Settlement::where('status','queue')->orderby('id','asc')->get();
        
            foreach($lists as $key=>$value)
            {

              /* $update=['status'=>'process'];
               Settlement::where('id',$value->id)->update($update);*/

               $currencydetails= $this->getCurrencyDetailsByName($value->type);
           
           
               if($value->mode=='offline')
               {

                    $res=$this->createCashPoint($value);
                    if($res)
                    {
                          $update=['status'=>'complete'];
                          Settlement::where('id',$value->id)->update($update);
                    }
                  
                  

               }

           
                
               

                 
                   

            
      
               
             
            }
    }

            
  

       
        
    

}

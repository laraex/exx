<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Traits\CoinProcess;
use App\CurrencyMaster;

class Exchangerates extends Command
{
    use CoinProcess;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchanger:getrates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exchange Rates';

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
        //
        
        
          $exchangerates['rates']['USD']=1;
         // $array=array('BTC','LTC','ETH','GBP','EUR','NGN');
          $array = CurrencyMaster::pluck('symbol');
          for($i=0;$i<count($array);$i++)
          {

          $final=0;
          

          $exchange_rates=$this->getExchangeValue($array[$i]);


          $base_currency='price_usd';
          $to_currency='price_'.strtolower($array[$i]);
          $final=$exchange_rates[0][$to_currency]/$exchange_rates[0][$base_currency];
        

          $exchangerates['rates'][$array[$i]]=$final;
          }
          

     
          $exchangerates = json_encode($exchangerates, true);       

          $this->storeExchangeRates($exchangerates);

        
    }
}

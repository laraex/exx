<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TradeCurrencyPair;
use Exception;
use App\Traits\CoinProcess;
use App\Cryptositerate;
use App\Cryptoothersiterate;

class GetCryptoRates extends Command
{
    use CoinProcess;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:getsiterates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get crypto other site rate';

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
         $siterate = Cryptoothersiterate::truncate();
         
          $pair_details = TradeCurrencyPair::where([['status','active']])->get();

           $site=array('bitfinex','kraken','bitflyer');

          foreach($pair_details as $pair){

             $bitfinex=$this->getBitfinex($pair->id);
             $kraken=$this->getKraken($pair->id);
             $bitflyer=$this->getBitflyer($pair->id);

           // dd($site);

          

             $siterate=new Cryptoothersiterate;
             $siterate->pair_id=$pair->id;
             $siterate->exchange_site='bitfinex';
             $siterate->exchange_val=$bitfinex['bitfinexval'];
             $siterate->save();

             $siterate_kra=new Cryptoothersiterate;
             $siterate_kra->pair_id=$pair->id;
             $siterate_kra->exchange_site='kraken';
             $siterate_kra->exchange_val=$kraken['krakenval'];
             $siterate_kra->save();

              $siterate_fly=new Cryptoothersiterate;
             $siterate_fly->pair_id=$pair->id;
             $siterate_fly->exchange_site='bitflyer';
             $siterate_fly->exchange_val=$bitflyer['bitflyer'];
             $siterate_fly->save();
          
          }
          
          echo "Sucessfully";



    }
    public function getBitfinex($pair)
    {

        //dd($pair);

         $pair_details = TradeCurrencyPair::where([['id',$pair],['status','active']])->first();

          if($pair_details->tocurrency->name=="KRW"){
                 $tocurrency="EUR";
             }else{
                 $tocurrency=$pair_details->fromcurrency->name;
             }


          //$exchangerate_perbit=$this->getexchangerate(1,$pair_details->tocurrency->name,$tocurrency,'buy');
           $exchangerate_perbit=$this->getexchange($tocurrency); 
       
       //dd($exchangerate_perbit);
       
          //dd($exchangerate_perbit);

          $bitval=0;
           $bitlast_price=0;

           try{
                 $bitfinexval=$this->exchangeFun('https://api.bitfinex.com/v1/pubticker/',$pair_details->fromcurrency->name,$pair_details->tocurrency->name,'','1');

                $bitlast_price= $bitfinexval->last_price;

                $bitval= $bitlast_price*$exchangerate_perbit;
            }
            catch(Exception $e)
            {

            }
        $bitfinex_value= array("bitfinex"=>$bitval,"bitfinexval"=>$bitlast_price);
       // $bitfinex_data =json_encode($bitfinex_value);
        return $bitfinex_value;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getKraken($pair)
    {
        $pair_details = TradeCurrencyPair::where([['id',$pair],['status','active']])->first();
         if($pair_details->tocurrency->name=="KRW"){
                 $tocurrencys="EUR";
                 
             }else{
                 $tocurrencys=$pair_details->fromcurrency->name;
                
             }

           //  dd($tocurrencys);

            $exchangerate_perkra=$this->getexchange($tocurrencys);

           //dd($exchangerate_perkra);


             $kra_value=0;
           $kraken_equ=0;
            try{
               
              $krakenval=$this->exchangeFun('https://api.kraken.com/0/public/Ticker?pair=',$pair_details->fromcurrency->name,$pair_details->tocurrency->name,$pair_details->fromcurrency,'2');

                if($pair_details->tocurrency->name=="KRW"){
                 $tocurrency="ZEUR";
                  }else{
                 $tocurrency=$pair_details->tocurrency->name;
                  } 
                if($pair_details->fromcurrency->type=='crypto'){
                    if($pair_details->fromcurrency->name=="BTC"){
                      $fromcurval="XXBT";
                    }else{
                       $fromcurval="X".$pair_details->fromcurrency->name;
                        }
                }

                   $kcurr=$fromcurval.$tocurrency;
                   $kraval_error=$krakenval->error;

                   if(count($kraval_error)=='0'){

                   $kra_value= $krakenval->result->$kcurr->c[0];
                    $kraken_equ=$kra_value*$exchangerate_perkra;
                    }
                    else{

                       $kra_value=0;
                       $kraken_equ=0;

                      }

           }
           catch(Exception $e)
            {

            }

              $krakenvalue= array("kraken"=>$kraken_equ,"krakenval"=>$kra_value,"equal"=> $exchangerate_perkra);

               //$krakendata =json_encode($krakenvalue);

             return $krakenvalue;
        
    }
     public function exchangeFun($url,$fromcurr,$tocurr,$fromcurrarray,$type)
    {


         if($type=="1"){

          if($tocurr=="KRW"){
                 $tocurrency="EUR";
             }else{
                 $tocurrency=$tocurr;
             } 

             $url_path=$url.$fromcurr.$tocurrency; 
         }

         if($type=="2"){

          if($tocurr=="KRW"){
                 $tocurrency="ZEUR";
             }else{
                 $tocurrency=$tocurr;
             } 
             if($fromcurrarray->type=='crypto'){
                 $fromcurval="X".$fromcurr;
             }
           //https://api.kraken.com/0/public/Trades?pair=XETHZEUR&since=0
             $url_path=$url.$fromcurval.$tocurrency; 
         }

         if($type=="3"){
              if($tocurr=="KRW"){
                 $tocurrency="JPY";
             }else{
                 $tocurrency=$tocurr;
             } 
           //https://api.kraken.com/0/public/Trades?pair=XETHZEUR&since=0
              $url_path=$url.$fromcurr.'_'.$tocurrency;
         }
          $ch = curl_init(); 
           //echo $url_path;
          $optArray = array(
              CURLOPT_URL => $url_path,
              CURLOPT_RETURNTRANSFER => true
          );

          // apply those options
          curl_setopt_array($ch, $optArray);

          // execute request and get response
             $result = curl_exec($ch);

               return $bitfinexval=json_decode($result);


    }

    function getexchange($currency){

      //echo $currency; 
                  // set API Endpoint and API key 
            $endpoint = 'latest';
           // $access_key = 'ce6df53e6cf94dbc77a9f09747104b8a';
            $access_key = '04c7730ad36ce277badefdca28aa55f7';

            // Initialize CURL:
            $ch = curl_init('http://data.fixer.io/api/'.$endpoint.'?access_key='.$access_key.'&base='.$currency.'');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Store the data:
            $json = curl_exec($ch);
            curl_close($ch);

            // Decode JSON response:
            $exchangeRates = json_decode($json, true);
//echo $exchangeRates['success'];
             //dd($exchangeRates);
             if($exchangeRates['success']==true){
                $rate=$exchangeRates['rates']['KRW'];
             }else{
                 $rate=0;
             }
            // Access the exchange rate values, e.g. GBP:
            return $rate;




    } 
     public function getBitflyer($pair)
    {

         $pair_details = TradeCurrencyPair::where([['id',$pair],['status','active']])->first();

         if($pair_details->tocurrency->name=="KRW"){
                  $tocurrency_bit="JPY";
           }else{
                 $tocurrency_bit=$pair_details->tocurrency->name;
           }
            $exchangerate_perfly=$this->getexchangerate(1,$pair_details->tocurrency->name,$tocurrency_bit,'buy');

            $bitflyer_equ=0;
            $bitflyer_value=0;

             try{

           $bitflyer=$this->exchangeFun('https://api.bitflyer.com/v1/ticker?product_code=',$pair_details->fromcurrency->name,$pair_details->tocurrency->name,$pair_details->fromcurrency,'3');

           //dd($bitflyer);

          $bitflyer_equ=$bitflyer->best_ask*$exchangerate_perfly;
          $bitflyer_value=$bitflyer->best_ask;
      
            }
            catch(Exception $e)
            {

            }

             $bitflyer_values= array('bitflyer'=>$bitflyer_equ,'bitflyerval'=>$bitflyer_value);

               //$bitflyer_data =json_encode($bitflyer_values);

             return $bitflyer_values;



    }  
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Http\Requests\BuyCoinRequest;
use App\Models\Country;
use Illuminate\Support\Facades\Cookie;
use App\Classes\block_io\BlockIo;
use App\TradeCurrencyPair;
use Exception;
use App\Traits\CoinProcess;
use App\Cryptoothersiterate;
class ExchangeRateController extends Controller
{
    use CoinProcess;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRates($pair)
    {


        $bitfinex = Cryptoothersiterate::where([['pair_id',$pair],['exchange_site','bitfinex']])->first();

        $kraken = Cryptoothersiterate::where([['pair_id',$pair],['exchange_site','kraken']])->first();

        $bitflyer = Cryptoothersiterate::where([['pair_id',$pair],['exchange_site','bitflyer']])->first();

        $bitfinex_val=$bitfinex->exchange_val;
        $kraken_val=$kraken->exchange_val;
        $bitflyer_val=$bitflyer->exchange_val;

         $getrate=$this->getexchangerate(1, 'KRW','EUR','buy');
         $getrate_fly=$this->getexchangerate(1, 'KRW','JPY','buy');

         $bitfinex_exc=$bitfinex_val*$getrate;
         $kraken_exc=$kraken_val*$getrate;
         $bitflyer_exc=$bitflyer_val*$getrate_fly;

         $site=array('bitfinex'=>$bitfinex_exc ,'bitfinexval'=>$bitfinex_val,'kraken'=>$kraken_exc,'krakenval'=>$kraken_val,'bitflyer'=>$bitflyer_exc,'bitflyerval'=>$bitflyer_val);

         $rate_details=json_encode($site);

         //dd($rate_details);

        return $rate_details;

    }
    
    public function getBitfinex($pair)
    {
         $pair_details = TradeCurrencyPair::where([['id',$pair],['status','active']])->first();

          if($pair_details->tocurrency->name=="KRW"){
                 $tocurrency="EUR";
             }else{
                 $tocurrency=$pair_details->fromcurrency->name;
             }


          //$exchangerate_perbit=$this->getexchangerate(1,$pair_details->tocurrency->name,$tocurrency,'buy');
           $exchangerate_perbit=$this->getexchange($tocurrency,$pair_details->tocurrency->name);
       
       
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

        $bitfinex_data =json_encode($bitfinex_value);


        return $bitfinex_data;

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

               $krakendata =json_encode($krakenvalue);

             return $krakendata;
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCoinmarketcap($pair)
    {
         $pair_details = TradeCurrencyPair::where([['id',$pair],['status','active']])->first();

         $getrate=$this->getexchangerate(1,  $pair_details->tocurrency->name,  $pair_details->fromcurrency->name,'buy');

         return $getrate;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getBitflyer($pair)
    {

         $pair_details = TradeCurrencyPair::where([['id',$pair],['status','active']])->first();

         if($pair_details->tocurrency->name=="KRW"){
                  $tocurrency_bit="JPY";
           }else{
                 $tocurrency_bit=$pair_details->tocurrency->name;
           }

           //dd($pair_details->tocurrency->name.$tocurrency_bit);

            $exchangerate_perfly=$this->getexchangerate(1,$pair_details->tocurrency->name,$tocurrency_bit,'buy');

            $bitflyer_equ=0;
            $bitflyer_value=0;

             try{

           $bitflyer=$this->exchangeFun('https://api.bitflyer.com/v1/ticker?product_code=',$pair_details->fromcurrency->name,$pair_details->tocurrency->name,$pair_details->fromcurrency,'3');

           //dd($exchangerate_perfly);

           //dd($bitflyer);

          $bitflyer_equ=$bitflyer->best_ask*$exchangerate_perfly;
          $bitflyer_value=$bitflyer->best_ask;
      
            }
            catch(Exception $e)
            {

            }

             $bitflyer_values= array('bitflyer'=>$bitflyer_equ,'bitflyerval'=>$bitflyer_value);

               $bitflyer_data =json_encode($bitflyer_values);

             return $bitflyer_data;



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

            // Access the exchange rate values, e.g. GBP:
            //return $exchangeRates['rates']['KRW'];
            //dd($exchangeRates);
             if($exchangeRates['success']==true){
              if($discur=='KRW'){
                $rate=$exchangeRates['rates']['KRW'];
               }

             }else{
                 $rate=0;
             }
            // Access the exchange rate values, e.g. GBP:
            return $rate;
    }   
}


//http://data.fixer.io/api/latest?access_key=ce6df53e6cf94dbc77a9f09747104b8a&base=USD
//latest?base=USD

//http://data.fixer.io/api/convert?access_key //=ce6df53e6cf94dbc77a9f09747104b8a&from=USD&to=EUR&amount = 25&date = 2018-07-19
<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Myaccount;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Currency;
use App\Traits\CoinProcess;
use App\User;
use App\Http\Requests\BuyCoinRequest;
use App\Models\Country;
use App\Coinorder;
use App\CurrencyPair;
use App\Traits\LogActivity;
use App\Traits\Trade;
use App\Events\TradetotalEvent;

use Illuminate\Support\Facades\Cookie;

use App\Classes\block_io\BlockIo;

use App\Requestorder;

use App\TradeCurrencyPair;
use Exception;


class TradeContentController extends Controller
{
    public function __construct()
  {
      $this->middleware(['auth', 'member'])->except(['show','testcurl','currencyInfor']);
  }

  use CoinProcess, LogActivity,Trade;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function currencyInfor($pair)
    {
          $pair_details = TradeCurrencyPair::where([['id',$pair],['status','active']])->first();

          $currencyname = Currency::where('id',$pair_details->from_currency_id)->where('is_coin',1)->first();

          $curlower=strtolower($currencyname->name);
          $trancontent=$curlower.'.content';

          $message=trans($trancontent);

          //dd($message);

        $value= array("coininfor"=>$message);
               $data =json_encode($value);

             return $data;
         


    }
    public function testcurl($pair)
    {

          // $pathmapper = {
          //   "1" => ""
          // }
       
          // $ch = curl_init("https://api.bitfinex.com/v1/pubticker/BTCUSD");
           
          //   curl_setopt($ch, CURLOPT_HEADER, 0);

          //   $s=curl_exec($ch);
          //   curl_close($ch);
          //   dd(json_decode($s));
         $pair_details = TradeCurrencyPair::where([['id',$pair],['status','active']])->first(); 

  //dd($pair_details);
              // init curl object  

          // $ch = curl_init();
          //   if($pair_details->tocurrency->name=="KRW"){
          //        $tocurrency="USD";
          //    }else{
          //        $tocurrency=$pair_details->tocurrency->name;
          //    } 

          // $optArray = array(
          //     CURLOPT_URL => 'https://api.bitfinex.com/v1/pubticker/'.$pair_details->fromcurrency->name.$tocurrency,
          //     CURLOPT_RETURNTRANSFER => true
          // );

          // // apply those options
          // curl_setopt_array($ch, $optArray);

        
          //    $result = curl_exec($ch);

        if($pair_details->tocurrency->name=="KRW"){
                 $tocurrency="USD";
             }else{
                 $tocurrency=$pair_details->fromcurrency->name;
             } 

             if($pair_details->tocurrency->name=="KRW"){
                 $tocurrencys="EUR";
                  $tocurrency_bit="JPY";
             }else{
                 $tocurrencys=$pair_details->fromcurrency->name;
                 $tocurrency_bit=$pair_details->tocurrency->name;
             }


          //dd($pair_details->tocurrency->name.$tocurrency);

           $exchangerate_perbit=$this->getexchangerate(1,$pair_details->tocurrency->name,$tocurrency,'buy');

           //dd("K");

           $exchangerate_perkra=$this->getexchangerate(1,$pair_details->tocurrency->name,$tocurrencys,'buy');

            $exchangerate_perfly=$this->getexchangerate(1,$pair_details->tocurrency->name,$tocurrency_bit,'buy');

           // dd("FF".$exchangerate_perfly);

          
             //$exchangerate_per=sprintf("%.4f",$exchangerate_per);
           $last_price=0;
           $bitval=0;
           $kra_value=0;
           $kraken_equ=0;
           $bitflyer_equ=0;
            $bitflyer_value=0;

           try{
      $bitfinexval=$this->curlfun('https://api.bitfinex.com/v1/pubticker/',$pair_details->fromcurrency->name,$pair_details->tocurrency->name,'','1');

       $krakenval=$this->curlfun('https://api.kraken.com/0/public/Ticker?pair=',$pair_details->fromcurrency->name,$pair_details->tocurrency->name,$pair_details->fromcurrency,'2');
       //dd($krakenval);
     
        $bitflyer=$this->curlfun('https://api.bitflyer.com/v1/ticker?product_code=',$pair_details->fromcurrency->name,$pair_details->tocurrency->name,$pair_details->fromcurrency,'3');
        //dd($bitflyer->error_message);
        try{
        
          $bitflyer_equ=$bitflyer->best_ask*$exchangerate_perfly;
          $bitflyer_value=$bitflyer->best_ask;
        }
          catch(Exception $e)
              {

              }

        //}
        


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
             //dd("test");
             // dd($kcurr);
        //dd($krakenval->result->$kcurr->c[0]);
       $kraval_error=$krakenval->error;
       
       //$cur="XETHZEUR";
       //dd(count($kraval_error));
       if(count($kraval_error)=='0'){
       $kra_value= $krakenval->result->$kcurr->c[0];
        $kraken_equ=$kra_value*$exchangerate_perkra;
      }else{
         $kra_value=0;
           $kraken_equ=0;
          }
             // if($bitfinexval->message=="Unknown symbol"){
             //       $bitfinexval->last_price=0;
             //       $bitval=0;
             // }
                $last_price= $bitfinexval->last_price;

                $bitval= $last_price*$exchangerate_perbit;

              }
              catch(Exception $e)
              {

              }
     
               // $krakenvals= $kraval*$exchangerate_perkra;

               $value= array("bitfinex"=>$bitval,"bitfinexval"=>$last_price,"kraken"=>$kraken_equ,"krakenval"=>$kra_value,'bitflyer'=>$bitflyer_equ,'bitflyerval'=>$bitflyer_value);




               $data =json_encode($value);


             return $data;

         //         $s=json_decode($result);

         // dd($s->last_price);

            //fclose($fp);
    }    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function curlfun($url,$fromcurr,$tocurr,$fromcurrarray,$type)
    {


         if($type=="1"){

          if($tocurr=="KRW"){
                 $tocurrency="USD";
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $currency = CurrencyPair::where('id', $request->currency)->first();
      $fromcurr=$currency->from_currency_id;
      $tocurr=$currency->to_currency_id;

     $latest_order=Requestorder::where([['request_type','sell'],['fromcurrency_id',$tocurr],['tocurrency_id',$fromcurr]])->whereIn('request_status',['Completed'])->latest()
                ->first();
  

     $max_order=Requestorder::where([['request_type','sell'],['fromcurrency_id',$tocurr],['tocurrency_id',$fromcurr]])->whereIn('request_status',['Completed'])->max('amount');

      $min_order=Requestorder::where([['request_type','sell'],['fromcurrency_id',$tocurr],['tocurrency_id',$fromcurr]])->whereIn('request_status',['Completed'])->min('amount');



       $sell_total_amount=Requestorder::where([['request_type','sell'],['fromcurrency_id',$tocurr],['tocurrency_id',$fromcurr]])->whereIn('request_status',['Completed'])->sum('buy_volume');



          $currencyname = Currency::where('id',$fromcurr)->first();
          $currencynamet = Currency::where('id',$tocurr)->first();

          if($max_order==null){
            $max_order=0;  
          }
          if($min_order==null){
            $min_order=0;  
          }
          if($sell_total_amount!=''){
            $sell_total_amount=0;  
          }
          if($latest_order!=null){
         
            $latestorder=$latest_order->amount;  
          
         }else{
            $latestorder=0;
         }
 
   $currency_name=$currencyname->name."-".$currencynamet->name;

    $curr_detail=array("max_order"=>$max_order,"min_order"=>$min_order,'latest_order'=>$latestorder,'currency_name'=>$currency_name,'sell_total_amount'=>$sell_total_amount); 

      $c=json_encode($curr_detail);

      return $c;

    
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
}

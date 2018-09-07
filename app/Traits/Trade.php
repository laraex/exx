<?php
/**
 * Trait for processing common
 */
namespace App\Traits;


use Illuminate\Support\Facades\Cookie;
use App\User;
use App\Classes\block_io\BlockIo;

use App\CurrencyPair;
use App\Requestorder;
use App\Models\Currency;
/**
 *
 * @class trait
 * Trait for Common Processes
 */
trait Trade
{
    /**
     * Getting a Value from Settings
     *
     * @param [type] $key
     * @return string
     */
  public static function gettrade($fromcurr,$tocurr)
  {
     //$currency=Currency::where('name', '=', 'PrimaryCoin')->first();

     $fromcurrency = Currency::where('id',$fromcurr)->first();
   
      $tocurrency = Currency::where('id', $tocurr)->first(); 

      $buyorders=Requestorder::where([['request_type','buy'],['fromcurrency_id',$fromcurr],['tocurrency_id',$tocurr]])->whereIn('request_status',['Completed'])->selectRaw('sum(buy_volume) as quantity,amount')->groupBy('amount')->orderBy('amount','DESC')->take(10)->get();

     $sellorders=Requestorder::where([['request_type','sell'],['fromcurrency_id',$tocurr],['tocurrency_id',$fromcurr]])->whereIn('request_status',['Completed'])->selectRaw('sum(buy_volume) as quantity,amount')->groupBy('amount')->orderBy('amount','ASC')->take(10)->get();
   
     //$orders=TradeOrders::where([['type','order'],['user_id','!=',TRADEPOT_ID]])->orderBy('id','DESC')->take(10)->get();

     $buy_total_quantity=Requestorder::where([['request_type','buy'],['fromcurrency_id',$fromcurr],['tocurrency_id',$tocurr]])->whereIn('request_status',['Completed'])->sum('buy_volume');


     $sell_total_quantity=Requestorder::where([['request_type','sell'],['fromcurrency_id',$tocurr],['tocurrency_id',$fromcurr]])->whereIn('request_status',['Completed'])->sum('buy_volume');

    $buy_total_amount=Requestorder::where([['request_type','buy'],['fromcurrency_id',$fromcurr],['tocurrency_id',$tocurr]])->whereIn('request_status',['Completed'])->select(\DB::raw("sum(amount*buy_volume) as total"))->first();

    $sell_total_amount=Requestorder::where([['request_type','sell'],['fromcurrency_id',$tocurr],['tocurrency_id',$fromcurr]])->whereIn('request_status',['Completed'])->select(\DB::raw("sum(amount*buy_volume) as total"))->first();

      $buy_total_amount=$buy_total_amount['total'];
      $sell_total_amount=$sell_total_amount['total'];
      

    if($buy_total_amount=='')
    {
     $buy_total_amount=0;
    }
   
   if($sell_total_amount=='')
    {
     $sell_total_amount=0;
    }
    $array['buyorders']= $buyorders;
    $array['sellorders']= $sellorders;
    //$array['orders']= $orders;
    $array['buy_total_quantity']= $buy_total_quantity;
    $array['sell_total_quantity']= $sell_total_quantity;
    $array['buy_total_amount']= $buy_total_amount;
    $array['sell_total_amount']= $sell_total_amount;
    $array['from_currency']= $fromcurrency->name;
    $array['to_currency']= $tocurrency->name;


    //$array['currency_token']= $currency->token;

    return $array;

   }

    
   
 }


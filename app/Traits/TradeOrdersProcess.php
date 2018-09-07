<?php

namespace App\Traits;

use App\TradeOrders;
use App\Traits\Common;
use App\User;
use App\Traits\TransactionProcess;
use App\Jobs\TradeOrdersJob;
use App\Traits\LogActivity;
use Carbon\Carbon;
use App\Traits\UserInfo;
use App\Traits\TradeProcess;
use App\Models\Currency;
use App\Models\Userpayaccounts;
use App\Http\Controllers\CryptoPayment\CryptoPaymentBase;
use Illuminate\Support\Facades\Auth;
use App\Models\Accountingcode;

use Exception;
use App\Traits\TradeBuyProcess;
use App\Traits\TradeSellProcess;
use App\Traits\SettlementProcess;
trait TradeOrdersProcess
{

  use UserInfo, TradeProcess, LogActivity,TradeBuyProcess,TradeSellProcess,SettlementProcess;
  public function makeTradeOrder($request, $user_id, $type, $queuetype)
  {

          /*  if($type=='buy')
             {
               $request->amount=$request->buy_amount;
               $request->volume=$request->buy_volume;
             }

            if($type=='sell')
             {
               $request->amount=$request->sell_amount;
               $request->volume=$request->sell_volume;
             }
     */
   \DB::beginTransaction();
    try{
          $create = [
            'user_id' => $user_id,
            'amount' => $request->amount,
            'quantity' => $request->volume,
            'from_coin_id' => $request->from_coin_id,
            'to_coin_id' => $request->to_coin_id,
            'status' => 'pending',
            'type' => $type,
            'order_at' => Carbon::now(),
            'total_amount' => $request->total_amount,

            'fee' => $request->fee,
            'base_fee' => $request->base_fee,

          ];
          if (isset($request->fee_total)) {

            $create['fee_total'] = $request->fee_total;

          }
          if (isset($request->ref_id)) {

            $create['ref_id'] = $request->ref_id;

          }
          if (isset($request->order_at)) {


            $create['order_at'] = $request->order_at;

          }
          if (isset($request->response)) {

            $create['response'] = json_encode($response);

          }
          if (isset($request->buy_order_id)) {

            $create['buy_order_id'] = $request->buy_order_id;

          }
          if (isset($request->sell_order_id)) {

            $create['sell_order_id'] = $request->sell_order_id;

          }

          $trade = TradeOrders::create($create);


          if ($type == 'buy') {

            if (TRADEPOT_ID != $trade->user_id) {

               $this->createTradeBuyDebit($trade);
               
             }
            }

          

          if ($type == 'sell') {

            if (TRADEPOT_ID != $trade->user_id) {
                  //dd(Auth::id().$from_currencydetails->id);
          
                     $this->createTradeSellDebit($trade);

            }

          }
          \DB::commit();

          $job = (new TradeOrdersJob($trade))->onQueue($queuetype);

          dispatch($job);

          if ($type == 'buy') {
                                 //Activity Log

            $message = "Make Buy Order";

            $user = User::find($user_id);
            $this->doActivityLog(
              $user,
              $user,
              ['ip' => request()->ip(), 'order' => $trade->id],
              LOGNAME_BUYTRADEORDER,
              $message
            );
          }

          if ($type == 'sell') {
                               //Activity Log

            $message = "Make Sell Order";

            $user = User::find($user_id);
            $this->doActivityLog(
              $user,
              $user,
              ['ip' => request()->ip(), 'order' => $trade->id],
              LOGNAME_SELLTRADEORDER,
              $message
            );
          }

    return $trade;
  }
  catch(Exception $e)
  {//dd($e->getMessage());
      \DB::rollBack();
  }
  }

  public function checkTradeOrder($trade)
  {

    if ($trade->type != 'order') {
      $flag = 0;

      if ($trade->type == 'buy') {

        $sellorder = TradeOrders::where([['type', 'sell'], ['from_coin_id', $trade->to_coin_id], ['to_coin_id', $trade->from_coin_id], ['id', '<=', $trade->id]])->whereIn('status', ['pending'])->where('amount', '<=', $trade->amount)->orderBy('amount', 'ASC')->orderBy('order_at', 'ASC')->orderByRaw('ISNULL(parent_id), parent_id ASC')->first();
        if (count($sellorder) > 0) {
          $flag = 1;
        }

        $buyorder = $trade;

      } else if ($trade->type == 'sell') {


        $sellorder = $trade;


        $buyorder = TradeOrders::where([['type', 'buy'], ['from_coin_id', $trade->to_coin_id], ['to_coin_id', $trade->from_coin_id], ['id', '<=', $trade->id]])->whereIn('status', ['pending'])->where('amount', '>=', $trade->amount)->orderBy('amount', 'ASC')->orderBy('order_at', 'ASC')->orderByRaw('ISNULL(parent_id), parent_id ASC')->first();
        if (count($buyorder) > 0) {
          $flag = 1;
        }

      }

      if ($flag == 1) {
        $quantity = 0;
        $type = '';

        if ($sellorder->amount == $buyorder->amount) {

          if ($sellorder->quantity > $buyorder->quantity) {
            $quantity = $sellorder->quantity - $buyorder->quantity;
            $buy_quantity = $buyorder->quantity;
            $id = $sellorder->id;
            $type = 'sell';


            $this->createTrade($buyorder->user_id, $buyorder->amount, $buyorder->quantity, $buyorder->from_coin_id, $buyorder->to_coin_id, 'NULL', 'order', $buyorder->id, $buyorder->id, $sellorder->id, 'NULL', $buyorder->order_at, $buyorder);
                                         
                                  
                                    

                                     //Check previous txn

            $this->checkPreviousTxn($buyorder->id);

                                    //Activity Log

            $message = "Buy order Complete " . $buyorder->id . " match with " . $sellorder->id;

            $user = User::find(SYSTEM_ID);
            $this->doActivityLog(
              $user,
              $user,
              ['ip' => request()->ip(), 'order'=>$buyorder->id],
              LOGNAME_TRADEORDER,
              $message
            );


            echo $message;

            $update = [
              'status' => 'complete',

            ];

            TradeOrders::where('id', $buyorder->id)->update($update);
                          
           // $this->createTradeBuyCreditTransaction($buyorder, $buyorder->quantity);
            $order= $this->getParentOrder($buyorder->id);

            if($order->status=='complete')
            {
                if($order->type=='buy')
                {
                      $this->createTradeBuyCreditTransaction($order);
                }

                 if($order->type=='sell')
                {
                   $this->createTradeSellCreditTransaction($order);
                }
            }
         



          } else if ($sellorder->quantity < $buyorder->quantity) {

            $quantity = $buyorder->quantity - $sellorder->quantity;
            $buy_quantity = $sellorder->quantity;
            $id = $buyorder->id;
            $type = 'buy';

                           
          //  $this->createTradeSellCreditTransaction($sellorder, $sellorder->total_amount);

         
            /* $sell_order= $this->getParentOrder($sellorder->id);
             if($sell_order->status=='complete')
            {
               $this->createTradeSellCreditTransaction($sell_order);
            }*/

            

                             
                             //  if($response)
                              // {
            $this->createTrade($sellorder->user_id, $sellorder->amount, $sellorder->quantity, $sellorder->from_coin_id, $sellorder->to_coin_id, 'NULL', 'order', $sellorder->id, $buyorder->id, $sellorder->id, 'NULL', $sellorder->order_at, $sellorder);

                                   

                                     //Check previous txn

            $this->checkPreviousTxn($sellorder->id);

                                     //Activity Log

            $message = "Sell order Complete " . $sellorder->id . " match with " . $buyorder->id;

            $user = User::find(SYSTEM_ID);
            $this->doActivityLog(
              $user,
              $user,
              ['ip' => request()->ip(), 'order'=> $sellorder->id],
              LOGNAME_TRADEORDER,
              $message
            );

            echo $message;



            //$this->createTradeBuyCreditTransaction($buyorder, $sellorder->quantity);
                            




            $update = [
              'status' => 'complete',

            ];

            TradeOrders::where('id', $sellorder->id)->update($update);
                           // }
                            /*else
                            {
                              echo "Admin Balance Insufficient";
                            }*/
            $order= $this->getParentOrder($sellorder->id);

            if($order->status=='complete')
            {
                if($order->type=='buy')
                {
                      $this->createTradeBuyCreditTransaction($order);
                }

                 if($order->type=='sell')
                {
                   $this->createTradeSellCreditTransaction($order);
                }
            }

          }


          if ($type == 'buy') {

            if ($quantity != 0) {
              if ($buyorder->parent_id != '') {

                $parent_id = $buyorder->parent_id . "-" . $buyorder->id;
              } else {
                $parent_id = $buyorder->id;
              }

              $this->createTrade($buyorder->user_id, $buyorder->amount, $quantity, $buyorder->from_coin_id, $buyorder->to_coin_id, 'pending', $type, $buyorder->id, 'NULL', $sellorder->id, $parent_id, $buyorder->order_at, $buyorder);
            }

          }
          if ($type == 'sell') {
            if ($quantity != 0) {
              if ($sellorder->parent_id != '') {

                $parent_id = $sellorder->parent_id . "-" . $sellorder->id;
              } else {
                $parent_id = $sellorder->id;
              }



              $this->createTrade($sellorder->user_id, $sellorder->amount, $quantity, $sellorder->from_coin_id, $sellorder->to_coin_id, 'pending', $type, $sellorder->id, $buyorder->id, 'NULL', $parent_id, $sellorder->order_at, $sellorder);
            }
          }
          if (($type == '') && ($quantity == 0)) {
            $buy_quantity = $buyorder->quantity;


                     
          //  $this->createTradeSellCreditTransaction($sellorder, $sellorder->total_amount);
                            /*  $response=1;
                            if($response)
                            {*/
            $update = [
              'status' => 'complete',

            ];

            TradeOrders::where('id', $sellorder->id)->update($update);
            TradeOrders::where('id', $buyorder->id)->update($update);
                            

                         
                                       
                       /*        $this->createTrade($buyorder->user_id,$buyorder->amount,$buyorder->quantity,$buyorder->from_coin_id,$buyorder->to_coin_id,'NULL','order',$buyorder->id,$buyorder->id,$sellorder->id,'NULL',$buyorder->order_at,$buyorder);*/


            $this->createTrade($sellorder->user_id, $sellorder->amount, $sellorder->quantity, $sellorder->from_coin_id, $sellorder->to_coin_id, 'NULL', 'order', $sellorder->id, $buyorder->id, $sellorder->id, 'NULL', $sellorder->order_at, $sellorder);

                                

                                     //Check previous txn                         
            $this->checkPreviousTxn($buyorder->id);

                                     //Check previous txn                          
            $this->checkPreviousTxn($sellorder->id);

                               //Activity Log

            $message = "Order Complete Buy id-" . $buyorder->id . " Sell id-" . $sellorder->id;

            $user = User::find(SYSTEM_ID);
            $this->doActivityLog(
              $user,
              $user,
              ['ip' => request()->ip()],
              LOGNAME_TRADEORDER,
              $message
            );

            echo $message;

          //  $this->createTradeBuyCreditTransaction($buyorder, $buyorder->quantity);
             $buy_order= $this->getParentOrder($buyorder->id);
             if(($buy_order->status=='complete')&&($buy_order->user_id!=TRADEPOT_ID))
              {
                 $this->createTradeBuyCreditTransaction($buy_order);
              }
             $sell_order= $this->getParentOrder($sellorder->id);
             if(($sell_order->status=='complete')&&($sell_order->user_id!=TRADEPOT_ID))
             {
               $this->createTradeSellCreditTransaction($sell_order);
             }
                       
                            
                            
                           /*}
                           else
                            {
                              echo "Admin Balance Insufficient";
                            }*/

          }
          if($quantity != 0)//If anyone Remaining(Always one)
          {
            $update = [
              'status' => 'partialcomplete',

            ];
            TradeOrders::where('id', $id)->update($update);
          }
        }else {

          $this->createTradePot($buyorder, $sellorder);
        }
      }
    }

  }


  public function createTrade($user_id, $amount, $quantity, $from_coin_id, $to_coin_id, $status, $type, $order_id, $buy_order_id, $sell_order_id, $parent_id, $order_at, $order)
  {

    $total_amount = 0;
    $fee_total = 0;
    if ($type == 'buy') {

      $total = $amount * $quantity;
     /* $fee_total = ($order->fee / 100) * $total;
      $total_amount = $total + $fee_total;*/

      $fee_total = (($order->fee / 100) * $quantity)+$order->base_fee;
      $total_amount = $order->total_amount;
    }
    if ($type == 'sell') {

      $total = $amount * $quantity;
    /*  $fee_total = ($order->fee / 100) * $total;
      $total_amount = $total - $fee_total;*/

      $fee_total = (($order->fee / 100) * $total)+$order->base_fee;
      $total_amount = $total - $fee_total;
    }

    $create = [
      'user_id' => $user_id,
      'amount' => $amount,
      'quantity' => $quantity,
      'from_coin_id' => $from_coin_id,
      'to_coin_id' => $to_coin_id,
      'type' => $type,
      'order_id' => $order_id,
      'total_amount' => $total_amount,
      'fee' => $order->fee,
      'base_fee' => $order->base_fee,
      'fee_total' => $fee_total,

    ];




    if ($status != 'NULL') {

      $create['status'] = $status;
    }
    if ($buy_order_id != 'NULL') {

      $create['buy_order_id'] = $buy_order_id;
    }
    if ($sell_order_id != 'NULL') {

      $create['sell_order_id'] = $sell_order_id;
    }
    if ($parent_id != 'NULL') {

      $create['parent_id'] = $parent_id;

    }
    if ($order_at != 'NULL') {

      $create['order_at'] = $order_at;

    }

    $trade = TradeOrders::create($create); 

                         //  if($type=='order')
                          // {
                             //Dispatch Queue
    $job = (new TradeOrdersJob($trade));
    dispatch($job)->onQueue('trade');
                          // }

  }
  public function checkPreviousTxn($id)
  {
    $update = [
      'status' => 'complete',

    ];
    $order = TradeOrders::where('id', $id)->first();

    $order_parent = explode('-', $order->parent_id);
    if (count($order_parent) > 0) {
      TradeOrders::whereIn('id', $order_parent)->update($update);
    }

  }
  public function getParentOrder($id)
  {
    $parentorder=[];

    $order = TradeOrders::where('id', $id)->first();

    /*if($order->user_id==TRADEPOT_ID)
    {
         $order = TradeOrders::where('id', $order->ref_id)->first();

    }*////imp
    if($order->parent_id!='')
    {
        $order_parent = explode('-', $order->parent_id);
        if (count($order_parent) > 0) {
          $parentorder=TradeOrders::whereIn('id', $order_parent)->whereNull('parent_id')->first();
        }
    }
        else
        {
            return $order;//Single match
        }
    return $parentorder;

  }
  public function createTradePot($buyorder, $sellorder)
  {


    $user = User::where('id', TRADEPOT_ID)->first();
          
               //  $userbalance = $this->getUserCurrencyBalance($user, $sellorder->from_coin_id);

    if ($sellorder->quantity == $buyorder->quantity) {
      $buy_quantity = $buyorder->quantity;
      $sell_quantity = $sellorder->quantity;


    }
    if ($sellorder->quantity < $buyorder->quantity) {
                     // $buy_quantity=$buyorder->quantity-$sellorder->quantity;
      $sell_quantity = $sellorder->quantity;
      $buy_quantity = $sellorder->quantity;
    }

    if ($sellorder->quantity > $buyorder->quantity) {
      $buy_quantity = $buyorder->quantity;
                    //  $sell_quantity=$sellorder->quantity-$buyorder->quantity;
      $sell_quantity = $buyorder->quantity;


    }

                  // if ($sellorder->amount <= $userbalance)
                 //  {



    $request_sell = [

      'amount' => $sellorder->amount,
      'volume' => $buy_quantity,
      'ref_id' => $sellorder->id,
      'order_at' => $sellorder->order_at,
      'from_coin_id' => $buyorder->from_coin_id,
      'to_coin_id' => $buyorder->to_coin_id,
      'fee' => $sellorder->fee,
      'base_fee' => $sellorder->base_fee,
      'buy_order_id' => $buyorder->id,
      'sell_order_id' => $sellorder->id,
      'total_amount' => $sellorder->total_amount,
    ];

    $request_sell = (object)$request_sell;
    $exists = TradeOrders::where('ref_id', $sellorder->id)->exists();


    if (($user->id != $sellorder->user_id) && (!$exists)) {
      $this->makeTradeOrder($request_sell, TRADEPOT_ID, 'buy', 'trade');
    }



    $request_buy = [

      'amount' => $buyorder->amount,
      'volume' => $sell_quantity,
      'ref_id' => $buyorder->id,
      'order_at' => $buyorder->order_at,
      'from_coin_id' => $sellorder->from_coin_id,
      'to_coin_id' => $sellorder->to_coin_id,

      'fee' => $buyorder->fee,
      'base_fee' => $buyorder->base_fee,
      'buy_order_id' => $buyorder->id,
      'sell_order_id' => $sellorder->id,
      'total_amount' => $buyorder->total_amount,
    ];

    $request_buy = (object)$request_buy;
    $exists = TradeOrders::where('ref_id', $buyorder->id)->exists();
    if (($user->id != $buyorder->user_id) && (!$exists)) {
      $this->makeTradeOrder($request_buy, TRADEPOT_ID, 'sell', 'trade');
    }


                  


                 //  }
  }

  public function createTradeBuyCreditTransaction($order)
  {
    try {

      $to = '';
      $amount=0;
     
      $currencyname=$order->fromcurrency->name;
     
      //$amount=$order->quantity;
      $amount=$order->quantity-$order->fee_total;
     
      
     // $to=$this->getAddress($currencyname,$order->user_id);//Blockchain

      $this->sendToSettlement($order->user_id,$order->from_coin_id,$order, $to, $amount,$order->fromcurrency->name,'offline');
                    //Fee
     // $account = $this->getAccountDetails(ADMIN_ID, $order->to_coin_id);//Blockchain
      $this->sendToSettlement(ADMIN_ID,$order->from_coin_id,$order, '', $order->fee_total, $order->fromcurrency->name,'offline');

    } catch (Exception $e) {
                 //  dd($e->getMessage());
    }


  }

  public function createTradeSellCreditTransaction($order)
  {
    try {
      $to='';
      $amount=0;
      $amount=$order->total_amount;
      if($order->fromcurrency->type=='fiat')
      {
         // $user_account = $this->getAccountDetails($order->user_id, $order->from_coin_id);
         // $to=$user_account->account_no;//Blockchain
          
      }
      if($order->fromcurrency->type=='crypto')
      {
             $currencyname=$order->fromcurrency->name;
           //  $to=$this->getAddress($currencyname,$order->user_id);//Blockchain
            
      }

       $this->sendToSettlement($order->user_id,$order->from_coin_id,$order, $to, $amount, $order->fromcurrency->name,'offline');
     
                      //Fee

    //  $admin_account = $this->getAccountDetails(ADMIN_ID, $order->from_coin_id);//Blockchain

      $this->sendToSettlement(ADMIN_ID,$order->from_coin_id,$order,'', $order->fee_total, $order->fromcurrency->name,'offline');
    } catch (Exception $e) {
                  //  dd($e->getMessage());
    }




  }
  /*public function getAddress($currencyname,$user_id)
  {
    try{
      $to='';

      if ($currencyname == 'BTC') {
        $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
      }
      if ($currencyname == 'LTC') {
        $pg = $this->getPgDetailsByGatewayName('ltc_blockio');
      }

      if ($currencyname == 'ETH') {
        $pg = $this->getPgDetailsByGatewayName('eth');
      }

      if ($currencyname == 'BCH') {
        $pg = $this->getPgDetailsByGatewayName('bch');
      }
      if ($currencyname == 'XRP') {
        $pg = $this->getPgDetailsByGatewayName('xrp');
      }

      $user_accounts = Userpayaccounts::getAccountDetails($user_id, $pg->id)->first();

      if ($currencyname == 'BTC') {
        $to = $user_accounts->btc_address;

      }
      if ($currencyname == 'LTC') {
        $to = $user_accounts->ltc_address;
      }
       if ($currencyname == 'ETH') {
        $to = $user_accounts->eth_address;
      }
       if ($currencyname == 'BCH') {
        $to = $user_accounts->bch_address;
      }
       if ($currencyname == 'XRP') {
        $to = $user_accounts->xrp_address;
      }
      return $to;
    }
    catch(Exception $e)
    {
         return $to;

    }

  }//Imp Blockchain
 
*/


  public static function gettrade($pair_details)
  {
       
     // echo "TO".$pair_details->tocurrency->id;
     // echo "<br>";
     // echo "FROM".$pair_details->fromcurrency->id;
    $sellbuyorders = '';

      // $sellbuyorders=TradeOrders::where([['user_id','!=',TRADEPOT_ID]])->whereIn('status',['pending'])->orWhere([['type','buy'],['type','sell'],['from_coin_id',$pair_details->fromcurrency->id],['to_coin_id',$pair_details->tocurrency->id],['from_coin_id',$pair_details->tocurrency->id],['to_coin_id',$pair_details->fromcurrency->id]])->selectRaw('sum(quantity) as quantity,amount,total_amount,created_at')->groupBy('amount')->orderBy('amount','DESC')->take(10)->get(['amount', 'quantity','total_amount','updated_at']);

     /*  $buyorders=TradeOrders::where([['type','buy'],['user_id','!=',TRADEPOT_ID],['from_coin_id',$pair_details->fromcurrency->id],['to_coin_id',$pair_details->tocurrency->id]])->whereIn('status',['pending'])->selectRaw('sum(quantity) as quantity,amount')->groupBy('amount')->orderBy('id','DESC')->take(10)->get(['amount', 'quantity','total_amount','updated_at']);
     */

    $buyorders = TradeOrders::where([['type', 'buy'], ['user_id', '!=', TRADEPOT_ID], ['from_coin_id', $pair_details->fromcurrency->id], ['to_coin_id', $pair_details->tocurrency->id]])->whereIn('status', ['pending'])->selectRaw('sum(quantity) as quantity,amount,updated_at,id')->groupBy('amount')->orderBy('amount', 'ASC')->take(10)->get(['amount', 'quantity', 'total_amount', 'updated_at','id']);

    $sellorders = TradeOrders::where([['type', 'sell'], ['user_id', '!=', TRADEPOT_ID], ['from_coin_id', $pair_details->tocurrency->id], ['to_coin_id', $pair_details->fromcurrency->id]])->whereIn('status', ['pending'])->selectRaw('sum(quantity) as quantity,amount,updated_at,id')->groupBy('amount')->orderBy('amount', 'ASC')->take(10)->get(['amount', 'quantity', 'total_amount', 'updated_at','id']);
    //  // $sellorders='';


    $orders = TradeOrders::where([['type', 'order'], ['user_id', '!=', TRADEPOT_ID], ['from_coin_id', $pair_details->tocurrency->id], ['to_coin_id', $pair_details->fromcurrency->id]])->selectRaw('sum(quantity) as quantity,amount,total_amount')->orderBy('id', 'DESC')->take(10)->get(['amount', 'quantity', 'total_amount', 'updated_at']);


    $buy_total_quantity = TradeOrders::where([['type', 'buy'], ['user_id', '!=', TRADEPOT_ID], ['from_coin_id', $pair_details->fromcurrency->id], ['to_coin_id', $pair_details->tocurrency->id]])->whereIn('status', ['pending'])->sum('quantity');

    $sell_total_quantity = TradeOrders::where([['type', 'sell'], ['user_id', '!=', TRADEPOT_ID], ['from_coin_id', $pair_details->tocurrency->id], ['to_coin_id', $pair_details->fromcurrency->id]])->whereIn('status', ['pending'])->sum('quantity');

    $buy_total_amount = TradeOrders::where([['type', 'buy'], ['user_id', '!=', TRADEPOT_ID], ['from_coin_id', $pair_details->fromcurrency->id], ['to_coin_id', $pair_details->tocurrency->id]])->whereIn('status', ['pending'])->select(\DB::raw("sum(amount*quantity) as total"))->first();

    $sell_total_amount = TradeOrders::where([['type', 'sell'], ['user_id', '!=', TRADEPOT_ID], ['from_coin_id', $pair_details->tocurrency->id], ['to_coin_id', $pair_details->fromcurrency->id]])->whereIn('status', ['pending'])->select(\DB::raw("sum(amount*quantity) as total"))->first();
//$transorders='';
    $transorders = TradeOrders::where([['type', 'order'], ['from_coin_id', $pair_details->fromcurrency->id], ['to_coin_id', $pair_details->tocurrency->id]])->orderBy('id', 'DESC')->take(5)->get(['amount', 'quantity', 'total_amount', 'updated_at']);

      //dd($transorders);
 //dd("GGhbhb");

    $buy_total_amount = $buy_total_amount['total'];
    $sell_total_amount = $sell_total_amount['total'];
    if ($buy_total_amount == '') {
      $buy_total_amount = 0;
    }

    if ($sell_total_amount == '') {
      $sell_total_amount = 0;
    }

    $completedorders = '';
/*    $completedorders = TradeOrders::where([['user_id', '!=', TRADEPOT_ID], ['type', 'buy'], ['from_coin_id', $pair_details->fromcurrency->id], ['to_coin_id', $pair_details->tocurrency->id]])->whereIn('status', ['completed'])->orWhere([['type', 'sell'], ['from_coin_id', $pair_details->tocurrency->id], ['to_coin_id', $pair_details->fromcurrency->id]])->groupBy('amount')->orderBy('amount', 'DESC')->take(10)->get(['type', 'from_coin_id', 'to_coin_id', 'amount', 'quantity', 'total_amount', 'updated_at']);*/

    /*$completedorders = TradeOrders::where([['user_id', '!=', TRADEPOT_ID],['status', 'complete']])
      ->where(function($q) use ($pair_details){
          $q->orwhere([['type', 'buy'], ['from_coin_id', $pair_details->fromcurrency->id], ['to_coin_id', $pair_details->tocurrency->id]])
            ->orWhere([['type', 'sell'], ['from_coin_id', $pair_details->tocurrency->id], ['to_coin_id', $pair_details->fromcurrency->id]]);
      })->orderBy('updated_at', 'DESC')->take(10)->get(['type', 'from_coin_id', 'to_coin_id', 'amount', 'quantity', 'total_amount', 'updated_at']);*///Imp

$completedorders = TradeOrders::where('type','order')
      ->where([['from_coin_id', $pair_details->tocurrency->id], ['to_coin_id', $pair_details->fromcurrency->id]])
      ->with('order')
      ->orderBy('updated_at', 'DESC')->take(10)->get(['type', 'from_coin_id', 'to_coin_id', 'amount', 'quantity', 'total_amount', 'updated_at','order_id']);

      //dd($completedorders);

    $data = [];
    foreach ($completedorders as $order) {

      //dd($order->order->amount);

      $month = explode(' ', $order->order->updated_at);
      $months = explode('-', $month[0]);
      $times = explode(':', $month[1]); //dd($times); 
      $datetime = $months[1] . "." . $months[2] . " " . $times[0] . "-" . $times[1]; $data[] = array('amount' => $order->order->amount, 'quantity' => $order->order->quantity, 'total_amount' => $order->order->total_amount, 'updated_at' => $datetime, 'type' => $order->order->type);
     } $array['completedorders'] = $data;
     
    // $array['sellbuyorders']= $sellbuyorders;
      $array['buyorders'] = $buyorders;
      $array['sellorders'] = $sellorders;
      $array['orders'] = $orders;
      $array['transorders'] = $transorders;

      $array['buy_total_quantity'] = $buy_total_quantity;
      $array['sell_total_quantity'] = $sell_total_quantity;
      $array['buy_total_amount'] = $buy_total_amount;
      $array['sell_total_amount'] = $sell_total_amount;

      $array['from_currency_token'] = $pair_details->fromcurrency->token;
      $array['to_currency_token'] = $pair_details->tocurrency->token;

    // dd($array);

      return $array;


    }

  public static function getusertrade($pair_details,$user_id)
  {
    
    $sellorders = '';
    $buyorders = TradeOrders::where([['type', 'buy'], ['user_id', '=', $user_id], ['user_id', '!=', TRADEPOT_ID], ['from_coin_id', $pair_details->fromcurrency->id], ['to_coin_id', $pair_details->tocurrency->id]])->whereIn('status', ['pending'])->selectRaw('sum(quantity) as quantity,amount,updated_at,id')->groupBy('amount')->orderBy('amount', 'DESC')->take(10)->get(['amount', 'quantity', 'total_amount', 'updated_at','id']);

    $sellorders = TradeOrders::where([['type', 'sell'],['user_id', '=', $user_id],['user_id', '!=', TRADEPOT_ID], ['from_coin_id', $pair_details->tocurrency->id], ['to_coin_id', $pair_details->fromcurrency->id]])->whereIn('status', ['pending'])->selectRaw('sum(quantity) as quantity,amount,updated_at,id')->groupBy('amount')->orderBy('amount', 'ASC')->take(10)->get(['amount', 'quantity', 'total_amount', 'updated_at','id']);

   //dd($sellorders);
    $orders = TradeOrders::where([['type', 'order'], ['from_coin_id', $pair_details->fromcurrency->id], ['to_coin_id', $pair_details->tocurrency->id]])->orderBy('id', 'DESC')->take(5)->get(['amount', 'quantity', 'total_amount', 'updated_at']);

  
     
    // $array['sellbuyorders']= $sellbuyorders;
      $array['buyorders'] = $buyorders;
      $array['sellorders'] = $sellorders;
      $array['orders'] = $orders;
      $array['from_currency_token'] = $pair_details->fromcurrency->token;
      $array['to_currency_token'] = $pair_details->tocurrency->token;

  
      return $array;


    }


  }

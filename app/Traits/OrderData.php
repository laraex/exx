<?php
namespace App\Traits;
use App\Exchangerate;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Settings;
use App\Requestorder;
use App\TradeOrders;

trait OrderData 
{
   public function getOrderValue($fromcurr,$tocurr,$order)
   {

      //dd($fromcurr."-".$tocurr);
      $orderdata=TradeOrders::where([['from_coin_id',$fromcurr],['to_coin_id',$tocurr],['status','complete']]);

      $past_24hrs = Carbon::now()
                   ->subHours(24)
                   ->format("Y-m-d H:i:s");

      if($order=='max_order'){
           return $orderval=$orderdata->max('amount');

      }
      else if($order=='min_order'){

         return $orderval=$orderdata->min('amount');

      }
   
      else if($order=='24hourvolume'){


     return $orderval= TradeOrders::where([['from_coin_id',$tocurr],['to_coin_id',$fromcurr],['status','complete']])->where("type",'sell')->where("created_at", ">=", $past_24hrs)->sum('quantity');

      }
      else if($order=='24houramount'){

        return $orderval= $orderdata->where("type",'buy')->where("created_at", ">=", $past_24hrs)->sum('amount');
     
      }

           //return $orderval;

   }
  
 
 }
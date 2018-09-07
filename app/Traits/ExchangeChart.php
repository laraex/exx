<?php

namespace App\Traits;


use App\Exchangerate;
use Carbon\Carbon;

use App\User;
use Illuminate\Support\Facades\Auth;
use App\Settings;

trait ExchangeChart 
{
  

  public function getExchangeValues($currency,$count)
  {
      
     $exchangerates=Exchangerate::orderBy('id','DESC')->take($count)->get();
     

       if(count($exchangerates)>0)
        {
          
        foreach ($exchangerates as $rate)  {


        $exchange_rates=json_decode($rate->exchange_rates,true);
   
            foreach ($exchange_rates['rates'] as $key => $value)
              {
                    if ($key == $currency)
                    {
                        $from_currencyvalue[] = $value;
                    }
                    
              }
          }
        }

      $avg = array_sum($from_currencyvalue)/ count($from_currencyvalue);

      $last_element = array_reverse( $from_currencyvalue )[0];
    

        foreach($from_currencyvalue as $key=>$exval){

            $diff= (($avg - $exval ) / $avg * 10000);

           $vall[]=array("day"=>$key+1,"value"=>number_format($diff));
   
        }

      $v=json_encode($vall);

        return $v;

   }
  
 
 }
<?php

namespace App\Traits;


use App\Exchangerate;
use Carbon\Carbon;
use App\Traits\Common;
use App\Coinorder;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Settings;
use App\Traits\CoinBuyProcess;
use App\Traits\CoinOrderProcess;
use App\Traits\TransactionProcess;

trait CoinProcess 
{
  use Common,CoinBuyProcess,CoinOrderProcess,TransactionProcess;

  public function storeExchangeRates($exchangerates)
  {
    $create=[
     'exchange_rates'=>$exchangerates,
     'created_at'=>Carbon::now(),
     'updated_at'=>Carbon::now()
    ];
    
    \ DB::table('exchangerates')->insert($create);
   }
  
  public  function getexchangerate($amount, $from_currency_name, $to_currency_name,$type)
  {
     
        //Payment Gateway -$from_currency_name

        $exchangerates=Exchangerate::latest()->first();

        $exchange_rates=json_decode($exchangerates['exchange_rates'],true);
    

        $finalcurrencyvalue='';
        if(count($exchange_rates)>0)
        {
            foreach ($exchange_rates['rates'] as $key => $value)
              {
                    if ($key == $from_currency_name)
                    {
                        $from_currencyvalue = $value;
                    }
                     if(($key=='PrimaryCoin_buy')&&($type=='buy')&&($from_currency_name=='PrimaryCoin'))
                    {
                         $from_currencyvalue = $value;

                    }
                     if(($key=='PrimaryCoin_sell')&&($type=='sell')&&($from_currency_name=='PrimaryCoin'))
                    {
                        $from_currencyvalue = $value;

                    }
              }
          
  
             foreach ($exchange_rates['rates'] as $key => $value)
              {
                    if ($key == $to_currency_name)
                    {
                        $currencyvalue = $value;
                    }
                     if(($key=='PrimaryCoin_buy')&&($type=='buy')&&($to_currency_name=='PrimaryCoin'))
                    {
                         $currencyvalue = $value;

                    }
                     if(($key=='PrimaryCoin_sell')&&($type=='sell')&&($to_currency_name=='PrimaryCoin'))
                    {
                        $currencyvalue = $value;

                    }
              }


              if ($to_currency_name != $from_currency_name)
              {
                  
                   if ($type=='buy')
                    {
                        $finalcurrencyvalue = $amount *($from_currencyvalue / $currencyvalue);

                    }

                    if ($type=='sell')
                    {
                        $finalcurrencyvalue = $amount *($currencyvalue / $from_currencyvalue);
                    }

              }
        }
 //dd($finalcurrencyvalue);
          return $finalcurrencyvalue;
    }
     public function getTransactionID()
    {

       $transaction_id = uniqid();

       $transactionid = Coinorder::where('transaction_id', $transaction_id)->exists(); 

       if($transactionid)
       {
          $this->getTransactionID();

       }
       return $transaction_id;

    }
     public   function getOrderRate($amount, $from_currency_name, $to_currency_name,$type)
    {

            $finalcurrencyvalue= $this->getexchangerate($amount, $from_currency_name, $to_currency_name,$type);

            \Session::put('request_to_amount',$finalcurrencyvalue);

            // $adminCommission=$this->CalculateAdminCommission($finalcurrencyvalue,$from_currency_name,$to_currency_name,$type);
  $adminCommission='0';
            if($type=='buy')
            {
              $total=$finalcurrencyvalue+$adminCommission;
            }
           

            return $total;

    }
    public   function CalculateAdminCommission($amount, $from_currency_name,$to_currency_name,$type)
    {
            $total=0;
           
            $user=User::find(Auth::id());

            $account_type=$user->account_type;

           //  $key=$to_currency_name.'-'.$from_currency_name.'-commission-'.$type;    
             $key=$to_currency_name.'-commission-'.$type;    
             $admin_commission=Settings::where('key', $key)->get();
             $admin_commission=$admin_commission[0]['value'];
             if($admin_commission!='')
             {

              if($amount!='')
              {
                  $total=$amount*($admin_commission/100);

              }
              else
              {

                $total=$admin_commission;
              }

          
             }


            return $total;

    }
//sowmi  //For Ticker-Comparison
    public  function getexchangerates($amount, $from_currency_name, $to_currency_name,$type,$exchangerates)
    {

        //Payment Gateway -$from_currency_name

      
        $exchange_rates=json_decode($exchangerates['exchange_rates'],true);
    

        $finalcurrencyvalue='';
        if(count($exchange_rates)>0)
        {
            foreach ($exchange_rates['rates'] as $key => $value)
              {
                    if ($key == $from_currency_name)
                    {
                        $from_currencyvalue = $value;
                    }
                     if(($key=='PrimaryCoin_buy')&&($type=='buy')&&($from_currency_name=='PrimaryCoin'))
                    {
                         $from_currencyvalue = $value;

                    }
                     if(($key=='PrimaryCoin_sell')&&($type=='sell')&&($from_currency_name=='PrimaryCoin'))
                    {
                        $from_currencyvalue = $value;

                    }
              }
          

             foreach ($exchange_rates['rates'] as $key => $value)
              {
                    if ($key == $to_currency_name)
                    {
                        $currencyvalue = $value;
                    }
                     if(($key=='PrimaryCoin_buy')&&($type=='buy')&&($to_currency_name=='PrimaryCoin'))
                    {
                         $currencyvalue = $value;

                    }
                     if(($key=='PrimaryCoin_sell')&&($type=='sell')&&($to_currency_name=='PrimaryCoin'))
                    {
                        $currencyvalue = $value;

                    }
              }


              if ($to_currency_name != $from_currency_name)
              {
                  
                   if ($type=='buy')
                    {
                        $finalcurrencyvalue = $amount *($from_currencyvalue / $currencyvalue);

                    }

                    if ($type=='sell')
                    {
                        $finalcurrencyvalue = $amount *($currencyvalue / $from_currencyvalue);
                    }

              }
        }

          return $finalcurrencyvalue;
    }
   


    public function sessionToRequest()
    {

        $array=[
            "coin_currency_id"=>\Session::get('coin_currency_id'),
           // "to_coin_currency_id"=>\Session::get('to_coin_currency_id'),
            "from_currency"=>\Session::get('from_currency'),
            "request_amount"=>\Session::get('request_amount'),
            "order_amount"=>\Session::get('order_amount'),
            "transaction_id"=>\Session::get('transaction_id'),
            "request_to_amount"=>\Session::get('request_to_amount'),
           // "payment_gateway_id"=>\Session::get('payment_gateway_id'),
          
            ];

                      \Session::forget('request_amount'); 
                      \Session::forget('order_amount'); 
                      \Session::forget('transaction_id');
                    //  \Session::forget('coin_currency_id'); 
                      \Session::forget('to_coin_currency_id'); 
                      \Session::forget('request_to_amount');
                    //  \Session::forget('payment_gateway_id');
                  
           
      
      return $array;
    }

     
 
 }
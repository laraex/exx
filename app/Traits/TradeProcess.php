<?php 

namespace App\Traits;
use App\Classes\block_io\BlockIo;
use Exception;
use App\Models\Userpayaccounts;
use App\User;
use App\Traits\TransactionProcess;
use App\Models\Currency;
use App\TradeOrders;
use App\Exchangerate;
use App\Events\TradeEvent;
use Illuminate\Support\Facades\Auth;
use App\Models\Accountingcode;
use App\Http\Controllers\CryptoPayment\CryptoPaymentBase;
use App\Models\Transaction;
trait TradeProcess {


	


    public function getTradeDetails($request,$pair_details,$type,$user)
    {

     // dd($pair_details->fromcurrency->name);
        
        $balance=0;
        $exchangerate_per=$this->getexchangerate(1, $pair_details->fromcurrency->name,$pair_details->tocurrency->name,$type);

          //dd($exchangerate_per);

        $exchangerate_per=sprintf("%.8f", $exchangerate_per);

        $variant=$pair_details->exchange_rate_variant;
        $fee=$pair_details->fee;
        $base_fee=$pair_details->base_fee;

        $amount=$request->amount;

        $variant_total=$exchangerate_per*($variant/100);

        $total_amount=$exchangerate_per+$variant_total;

      //  dd($variant_total."-".$total_amount);


        $exchangerate=$total_amount*$amount;//Qty check

           //dd($request->volume."-".$exchangerate);

        $exchangerate=$request->volume*$exchangerate;

        $exchangerate=sprintf("%.8f", $exchangerate);

        $fee_amount=$exchangerate*($fee/100);

        $fee_total=$base_fee+$fee_amount;
        $final_amount=0;

        if($type=='buy')
        {

            $final_amount=$exchangerate+$base_fee+$fee_amount;
           // $balance= $this->getUserBalance($user,$pair_details->from_currency_id);
        }
        if($type=='sell')
        {

            $final_amount=$exchangerate-$base_fee-$fee_amount;
        }
        
          $final_amount=sprintf("%.8f", $final_amount);
          $fee=sprintf("%.8f", $fee);
          $fee_total=sprintf("%.8f", $fee_total);


          //dd($final_amount);
        $res=array();
        $res['final_amount']=$final_amount;
        $res['fee_total']=$fee_total;
        $res['external_exchange_final_amount']=$final_amount;
        $res['exchange_rate_variant']=$variant;
        $res['fee']=$fee;
        $res['base_fee']=$base_fee;
        $res['exchangerate_per']=$exchangerate_per;
        $res['exchangerate_variant']=$total_amount;
        $res['balance']=$balance;
        $res['token']=$pair_details->fromcurrency->token;

        $exchangerates=Exchangerate::latest()->first();

        $exchange_rates=json_decode($exchangerates['exchange_rates'],true);

       //  if($pair_details->fromcurrency->name=='PrimaryCoin')
       //  {
       //    $from_currency_name=$pair_details->fromcurrency->name."_".$type;
       //    $to_currency_name=$pair_details->tocurrency->name;

       //  }
       // if($pair_details->tocurrency->name=='PrimaryCoin')
       //  {
       //    $to_currency_name=$pair_details->tocurrency->name."_".$type;
       //    $from_currency_name=$pair_details->fromcurrency->name;

       //  }

         $from_currency_name=$pair_details->tocurrency->name;
          $to_currency_name=$pair_details->fromcurrency->name;

          // /dd($from_currency_name."-".$to_currency_name);


        $from_currency_rate=0;
        $to_currency_rate=0;
   
        if(count($exchange_rates)>0)
        {

            $from_currency_rate=$exchange_rates['rates'][$from_currency_name];
            $to_currency_rate=$exchange_rates['rates'][$to_currency_name];

        }

        $res['from_currency_rate']=$from_currency_rate;
        $res['to_currency_rate']=$to_currency_rate;
      //  echo $final_amount;
       \Session::put('external_exchange_amount',$amount);
       \Session::put('external_exchange_final_amount',$final_amount);
       \Session::put('external_exchange_details',$pair_details);
       \Session::put('external_exchange_fee_total',$fee_total);
       \Session::put('exchangerate_per',$exchangerate_per);
       \Session::put('exchangerate_variant',$total_amount);
       \Session::put('volume',$request->volume);
       \Session::put('from_currency_rate',$from_currency_rate);
       \Session::put('to_currency_rate',$to_currency_rate);

     //  dd($res);
        return $res;

    }

   

    public function cancelTradeOrder($id)
    {

      $trade=TradeOrders::where('id',$id)->first();

      //dd($trade);


      if($trade->status=='pending')
      {
             $array=array();
             $balance_before=Transaction::BalanceBefore($trade->user_id,$trade->to_coin_id)->latest()->first();

             $balance_before= $balance_before->balance_after;
             $accounting_code="trade-".$trade->type."-credit";
         
              $accounting_code=$this->getAccountingCode($accounting_code);

              $request_json = array('volume'=>$trade->volume,'amount'=>$trade->amount, 'fee' =>$trade->fee,'fee_total'=>$trade->fee_total,'net_amount'=>$trade->total_amount,'order_id'=>$trade->id,'userid'=>$trade->user_id,'from_currency'=>$trade->fromcurrency->name,'to_currency'=>$trade->tocurrency->name);


              if($trade->type=='buy')
              {

                  $action="cancelbuytrade";
                  $comment = "Cancel Buy - " . $trade->fromcurrency->name . "Credit Wallet";
                  $amount=$trade->total_amount;
           

              } 

              if($trade->type=='sell')
              {
                  $action="cancelselltrade"; 
                   $comment = "Cancel Sell - " . $trade->fromcurrency->name . "Credit Wallet";
                   $amount=$trade->quantity;

              }

              
         
            $balance_after= $balance_before+$amount;
       
            $transaction=$this->createTransaction($trade->user_id,$trade->to_coin_id,$amount,"credit","approve",$action,$accounting_code,$comment,json_encode($request_json),'',$trade->id,get_class($trade),$balance_before,$balance_after,"NULL","NULL", $array);

              $update=['status'=>'cancel',
                    ];

              TradeOrders::where('id',$id)->update($update); 
      

            return true;   
      }

         

           
      return false;
    }

    public function updateResponse($response,$id)
    {
        $update=[                                                           
            'response'=>json_encode($response),
                                                                   
                ];

        TradeOrders::where('id',$id)->update($update);

    }

    public function updateCancelResponse($response,$id)
    {

        $update=[                                                           
            'cancel_response'=>json_encode($response),
                                                                   
                ];
        TradeOrders::where('id',$id)->update($update);

    }

  
  

 }
<?php

namespace App\Traits;
use Exception;

use App\Settlement;
use App\Models\Transaction;
trait SettlementProcess
{

 public function sendToSettlement($user_id,$currency_id,$order, $to, $amount, $type,$mode)
  {

   
    $create = [
      
      'entity_id' => $order->id,
      'entity_name' => get_class($order),
      'amount' => $amount,
      'to' => $to,
      'type' => $type,
      'mode' => $mode,

    ];
    if($user_id!='NULL')
    {
      $create['user_id']=$user_id;
    }
    if($user_id!='NULL')
    {
      $create['currency_id']=$currency_id;
    }
    Settlement::create($create);
    return true;
  }
  public function createCashPoint($order)
  {
    try{


      $comment="Settlement";
      $accounting_code=$this->getAccountingCode('settlement');
      $array=array();
      $balance_before=Transaction::BalanceBefore($order->user_id,$order->currency_id)->latest()->first();

      $balance_before= $balance_before->balance_after;
      $balance_after= $balance_before+$order->amount;
    
      $transaction=$this->createTransaction($order->user_id,$order->currency_id,$order->amount,"credit","approve","settlement",$accounting_code,$comment,'','',$order->id,get_class($order),$balance_before,$balance_after,"NULL","NULL", $array);
      return true;
    }
   catch(Exception $e)
    {
     // dd($e->getMessage());
      return false;
    }
  }


}
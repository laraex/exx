<?php 

namespace App\Traits;
use App\Models\Transaction;
use App\User;
use App\Models\Accountingcode;
trait LivefeedProcess {


	public static function getlivefeed($transactions)
    {
 

        $user = User::where('id', 1)->with('useraccount')->first();

        $allUserAccount = $user->useraccount->whereIn('currency_id', [1,2,3,4,5])->pluck('id')->toarray();
        

        $accounting_code  = LivefeedProcess::getAccountingCodeLivefeed(); 

         $count =Transaction::whereNotIn('accounting_code_id',$accounting_code)->where('id',$transactions['id'])->get()->count();



          
          $details=[]; 
           
        if(($transactions['status']==1)&&($count==1))
        {
            $transaction_type='';
                $response = json_decode($transactions->response, true);
                $request = json_decode($transactions->request, true);
                $transaction_number = '';
                  if ( isset($response['transaction_number']))
                  {
                        $transaction_number = $response['transaction_number'];
                  }

                   if ( isset($request['transaction_number']))
                  {
                        $transaction_number = $request['transaction_number'];
                  }
                  $flag=0;
         
                if (($transactions->action == 'deposit')&&($transactions->deposit_status=='active'))
                {
                    $flag=1;
                    $transaction_type='Fund Deposited';
                    $sendername=$transactions->present()->getFundDepositSendername($transactions->account_id);
                    $receivername=$transactions->present()->getFundDepositReceivername($transactions->account_id);
                }
                elseif (($transactions->action == 'withdraw')&&(isset($response['transaction_number'])))
                {
                    $flag=1;
                    $transaction_type='Withdraw';
                    $sendername=$transactions->present()->getTransactionWithdrawAccountName($transactions->account_id);
                    $receivername=$transactions->present()->getTransactionAccountName($transactions->account_id);

                }
                elseif ($transactions->action== 'transfer')
                {
                    $flag=1;
                   $transaction_type='Fund Transfer';
                   $sendername=$transactions->present()->getExchangeSenderAccountName($transactions->account_id);
                   $receivername=$transactions->present()->getExchangeReceiverAccountName($transactions->account_id);
                  
                }
                elseif ($transactions->action == 'exchange')
                {
                    $flag=1;
                   $transaction_type='Exchange';
                   $sendername=$transactions->present()->getExchangeSenderAccountName($transactions->account_id);
                   $receivername=$transactions->present()->getExchangeReceiverAccountName($transactions->account_id);

                }
               /* elseif ($transactions->action == '')
                {
                    $flag=1;
                     $transaction_type=$response['comment'] ;
                     $sendername=$transactions->present()->getAdminSenderAccountName($transactions->account_id,$request['userid']);
                     $receivername=$transactions->present()->getExchangeSenderAccountName($transactions->account_id);
                }*/

                 elseif(($transactions->action == 'buygiftcard')&&(isset($request['transaction_number'])))
                {
                         $flag=1;
                     $transaction_number = $request['transaction_number'];
                     $transaction_type=ucfirst($transactions->action);
                     $receivername=$transactions->present()->getSenderAccountName($transactions->account_id);
                     $sendername="-";

                }
                

              if($flag==1)
              {
                                  $details=[   
                                    'date' => $transactions->created_at->format('d/m/Y H:i:s') , 
                                    'amount' => number_format((float)$transactions->amount,2),
                                    'transaction_number' => $transaction_number,
                                    'currency_code'=>$transactions->present()->getCurrencyDisplayName($transactions->account_id),
                                    'transaction_type'=>$transaction_type,
                                    'sendername'=>$sendername,
                                    'receivername'=>$receivername,
                                    'id'=>$transactions->id,
                                    'image'=>$transactions->present()->getCurrencyImage($transactions->account_id),
                                    
                                ];
                }
            }
             
            return $details;
     
         //  return array_reverse($details);
         

    }
    public static function getAccountingCodeLivefeed()
    {


      $accounting_code  = Accountingcode::whereIn('accounting_code', ['fund-exchange-commission','fund-transfer-commission'])->get(['id'])->toArray();
      return $accounting_code;


    }


	
 }
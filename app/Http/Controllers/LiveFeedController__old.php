<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Transaction;
use App\User;
use App\Models\Accountingcode;

class LiveFeedController extends Controller
{

    public function index()
    {
        return view('livefeed');
    }
    
   public function livefeed()
    {
        $id=$_GET['id'];

        $user = User::where('id', 1)->with('useraccount')->first();

        $accounting_code  = Accountingcode::whereIn('accounting_code', ['EBuck-admin-user-debit-buy','EBuck-admin-user-commission-buy','EBuck-admin-user-commission-sell','EBuck-admin-user-addbank-sell','EBuck-admin-user-debit-sell','fund-exchange-commission','ebuck-add','fund-transfer-commission'])->get(['id'])->toArray();  


       // dd($accounting_code);
     

        $allUserAccount = $user->useraccount->whereIn('currency_id', [1,2,3,4,5])->pluck('id')->toarray();
        // dd($allUserAccount);
      /*   $transactions = Transaction::where([                       
                         ['type', '=', 'credit'],
                         ['id','>',$id],
                        ['deposit_status','active'],
                         ['status',1],
                        ])->orWhere([
                        ['action', '=', 'withdraw'],
                         ['type', '=', 'debit']
                        ])->whereNotIn('accounting_code_id',$accounting_code)
                        ->orderBy('id', 'desc')->take(10)->get();
*/
        $transactions =Transaction::where(function ($query)use ($id) {
                    $query->where([                       
                    ['type', '=', 'credit'],
                    ['id','>',$id],
                    /* ['deposit_status','active'],*/
                    ['status',1],
                    ])->orWhere([
                    ['type', '=', 'debit']])
                    ->orWhereIn(
                    'action', ['withdraw','transfer'])
                    ;
                })->where(function ($query)use ($accounting_code) {
                    $query->whereNotIn('accounting_code_id',$accounting_code);
                })->orderBy('id', 'desc')->take(10)->get();

          // dd($transactions); 

            $details[]='';
            $n=count($transactions);
            $flag=0;
            for($txn=0;$txn<$n;$txn++){
                $transaction_type='';

                $reponse = json_decode($transactions[$txn]['response'], true);
                $request = json_decode($transactions[$txn]['request'], true);
                $transaction_number = '';
                  if ( isset($reponse['transaction_number']))
                  {
                        $transaction_number = $reponse['transaction_number'];
                  }

                   if ( isset($request['transaction_number']))
                  {
                        $transaction_number = $request['transaction_number'];
                  }
         
                if (($transactions[$txn]['action'] == 'deposit')&&($transactions[$txn]['deposit_status']=='active'))
                {
                    $flag=1;
                    $transaction_type='Fund Deposited';
                    $sendername=$transactions[$txn]->present()->getFundDepositSendername($transactions[$txn]['account_id']);
                    $receivername=$transactions[$txn]->present()->getFundDepositReceivername($transactions[$txn]['account_id']);
                }
                elseif (($transactions[$txn]['action'] == 'withdraw')&&(isset($reponse['transaction_number'])))
                {
                    $flag=1;
                    $transaction_type='Withdraw';
                    $sendername=$transactions[$txn]->present()->getTransactionWithdrawAccountName($transactions[$txn]['account_id']);
                    $receivername=$transactions[$txn]->present()->getTransactionAccountName($transactions[$txn]['account_id']);
                }
                elseif($transactions[$txn]['action'] == 'transfer')
                {
                    $flag=1;
                   $transaction_type='Fund Transfer';
                   $sendername=$transactions[$txn]->present()->getExchangeSenderAccountName($reponse['from_account_id']);
                   $receivername=$transactions[$txn]->present()->getExchangeReceiverAccountName($reponse['to_account_id']);
                }
                elseif ($transactions[$txn]['action'] == 'exchange')
                {
                   $flag=1;

                   $transaction_type='Exchange';
                   $sendername=$transactions[$txn]->present()->getExchangeSenderAccountName($transactions[$txn]['account_id']);
                   $receivername=$transactions[$txn]->present()->getExchangeReceiverAccountName($transactions[$txn]['account_id']);
                }
              

           
                elseif((($transactions[$txn]['action'] == 'buycoin')||($transactions[$txn]['action'] == 'sellcoin')||($transactions[$txn]['action'] == 'buygiftcard'))&&(isset($request['transaction_number'])))
                {
                    $flag=1;
                     $transaction_number = $request['transaction_number'];
                     $transaction_type=ucfirst($transactions[$txn]['action']);

                     $sendername=$transactions[$txn]->present()->getAdminSenderAccountName($transactions[$txn]['account_id'],$request['userid']);
                     $receivername=$transactions[$txn]->present()->getExchangeSenderAccountName(1);

                }
                

                if(($transactions[$txn]['id']>$id)&&($flag==1)&&($transactions[$txn]['action'] != ''))
                {


                                  $details[]=[   
                                    'date' => $transactions[$txn]['created_at']->format('d/m/Y H:i:s') , 
                                    'amount' => $transactions[$txn]['amount'],
                                    'transaction_number' => $transaction_number,
                                    'currency_code'=>$transactions[$txn]->present()->getCurrencyCode($transactions[$txn]['account_id']),
                                    'transaction_type'=>$transaction_type,
                                    'sendername'=>$sendername,
                                    'receivername'=>$receivername,
                                    'id'=>$transactions[$txn]['id'],
                                    'image'=>$transactions[$txn]->present()->getCurrencyImage($transactions[$txn]['account_id']),
                                    
                                ];
               }

            }
            return array_reverse($details);
    }


    public function completelivefeedview()
    {
        //dd('gdfgdfg');
        // $id = $_GET['id'];
        // dd($id);
        $user = User::where('id', 1)->with('useraccount')->first();
        $allUserAccount = $user->useraccount->whereIn('currency_id', [1,2,3,4,5])->pluck('id')->toarray();
        $transactions = Transaction::where([                       
            ['type', '=', 'credit'],
            ['deposit_status','active'],
            ['status', 1],
            ])->orWhere([
            ['type', '=', 'debit'],
            // 'action', ['withdraw', 'NULL'],
            ['action', 'withdraw'],
            ])
            ->orWhereIn(
            'action', ['exchange', 'transfer']
            )->orderBy('id', 'desc')->get();
            //dd($transactions);
            $details[] = '';
            $n = count($transactions);
            for($txn=0;$txn<$n;$txn++)
            {
                $reponse = json_decode($transactions[$txn]['response'], true);
                $request = json_decode($transactions[$txn]['request'], true);
                $transaction_number = '';
                if ( isset($reponse['transaction_number']))
                {
                    $transaction_number = $reponse['transaction_number'];
                }
                 if ($transactions[$txn]['action'] == 'deposit')
                {
                    $transaction_type='Fund Deposited';
                    $sendername=$transactions[$txn]->present()->getFundDepositSendername($transactions[$txn]['account_id']);
                    $receivername=$transactions[$txn]->present()->getFundDepositReceivername($transactions[$txn]['account_id']);
                }
                elseif ($transactions[$txn]['action'] == 'withdraw')
                {
                    $transaction_type='Withdraw';
                    $sendername=$transactions[$txn]->present()->getTransactionWithdrawAccountName($transactions[$txn]['account_id']);
                    $receivername=$transactions[$txn]->present()->getTransactionAccountName($transactions[$txn]['account_id']);
                }
                elseif ($transactions[$txn]['action'] == 'transfer')
                {
                   $transaction_type='Fund Transfer';
                   $sendername=$transactions[$txn]->present()->getTransactionFundtransferName($transactions[$txn]['account_id']);
                   $receivername=$transactions[$txn]->present()->getFundtransferReceiverName($transactions[$txn]['account_id']);
                }
                elseif ($transactions[$txn]['action'] == 'exchange')
                {
                   $transaction_type='Exchange';
                   $sendername=$transactions[$txn]->present()->getExchangeSenderAccountName($transactions[$txn]['account_id']);
                   $receivername=$transactions[$txn]->present()->getExchangeReceiverAccountName($transactions[$txn]['account_id']);
                }
                elseif ($transactions[$txn]['action'] == 'NULL')
                {
                     $transaction_type=$reponse['comment'] ;
                     $sendername=$transactions[$txn]->present()->getAdminSenderAccountName($transactions[$txn]['account_id'],$request['userid']);
                     $receivername=$transactions[$txn]->present()->getExchangeSenderAccountName($transactions[$txn]['account_id']);
                }
               
                $details[] = [   
                                'date' => $transactions[$txn]['created_at']->format('d/m/Y H:i:s') , 
                                'amount' => $transactions[$txn]['amount'],
                                'transaction_number' => $transaction_number,
                                'currency_code'=>$transactions[$txn]->present()->getCurrencyCode($transactions[$txn]['account_id']),
                                'transaction_type'=>$transaction_type,
                                'sendername'=>$sendername,
                                'receivername'=>$receivername,
                                'id'=>$transactions[$txn]['id'],
                                'image'=>$transactions[$txn]->present()->getCurrencyImage($transactions[$txn]['account_id']),
                            ];
              
            }
            //dd($details[3]['date']);
            return view('livefeedlist', [
                'transactions' => $transactions,
            ]);
    }

}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Userpayaccounts;
use App\Models\Paymentgateway;
use App\Models\Withdraw;
use App\User;
use App\Models\Userprofile;
use App\Models\Usercurrencyaccount;
use App\Models\Currency;
use Illuminate\Support\Facades\Redirect;

class WithdrawController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status, $paymentgatewayid)
    {
        if (in_array( $status, array( 'pending', 'completed', 'rejected')) == FALSE)
        {
                    $norecords = array('message' => '404 Found.');
                    return [
                    'data' => $norecords,
                    ];
        }
        
        $withdrawlists = Withdraw::where('status', $status)->where('user_id',  Auth::guard('api')->id())->with(['user', 'transaction', 'userpayaccounts'])->latest('updated_at')->paginate(\Config::get('settings.pagecount'));

        // dd($withdrawlists);

        $pendingsum = Withdraw::where('status', 'pending')->where('user_id', Auth::guard('api')->id())->sum('amount');
        $completedsum = Withdraw::where('status', 'completed')->where('user_id',  Auth::guard('api')->id())->sum('amount');
        $lifetimesum = Withdraw::whereNotIn('status', array('rejected', 'request'))->where('user_id',  Auth::guard('api')->id())->sum('amount');

        $paymentdetails  = Paymentgateway::where('id', $paymentgatewayid)->get(['withdraw_commission', 'displayname', 'currency_id'])->toArray();

         $currency_accounting_code = Usercurrencyaccount::where([
                ['user_id', '=', Auth::guard('api')->id()],
                ['currency_id', '=', $paymentdetails[0]['currency_id']]
            ])->first();

         // dd(\Session::get('currencyid'));

         $currencydetails = Currency::where('id', $paymentdetails[0]['currency_id'])->first();   


        if (count($withdrawlists) == 0)
        {
            $norecords = array('norecord' => 'No records found.');
            return [
            'data' => $norecords,
            ];

        }

        foreach($withdrawlists as $key => $data)   
        {
            if ($status == 'pending')
            {
                $withdraw[$key]['amount']  =  $data->amount .' '. $data->transaction->present()->getCurrencyName($data->transaction->account_id);
               $withdraw[$key]['paymentName']  = $data->userpayaccounts->payment->displayname;
                $withdraw[$key]['dateTime']  = $data->created_at->format('d/m/Y H:i:s');
            }
            elseif ($status == 'completed')
            {
                 $response = json_decode($data->transaction->response, true);

                     $withdraw[$key]['amount']  =  $data->amount .' '. $data->transaction->present()->getCurrencyName($data->transaction->account_id);
               $withdraw[$key]['paymentName']  = $data->userpayaccounts->payment->displayname;
                $withdraw[$key]['transactionNumber']  = $response['transaction_number'];   
                $withdraw[$key]['comment']  = $data->comments_on_complete;         
                $withdraw[$key]['dateTime']  = $data->created_at->format('d/m/Y H:i:s');
                $withdraw[$key]['completed_on']  = $data->completed_oncompleted_on;
            }
            elseif ($status == 'rejected')
            {
                     $withdraw[$key]['amount']  =  $data->amount .' '. $data->transaction->present()->getCurrencyName($data->transaction->account_id);
               $withdraw[$key]['paymentName']  = $data->userpayaccounts->payment->displayname;
               $withdraw[$key]['comment']  = $data->comments_on_rejected;  
                $withdraw[$key]['dateTime']  = $data->created_at->format('d/m/Y H:i:s');
                $withdraw[$key]['rejected_on']  = $data->rejected_on;
            }
            
        }

        return [
            'data' => $withdraw,
            ];       
    }    
}

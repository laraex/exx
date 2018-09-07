<?php
namespace App\Presenters;
use Laracasts\Presenter\Presenter;
use App\User;
use App\Models\Transaction;
use App\Models\Usercurrencyaccount;
use App\Models\Paymentgateway;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\Currency;
use App\Models\Accountingcode;
use App\Traits\Common;
use App\Traits\UserInfo;
use App\Models\Country;
class SitePresenter extends Presenter
{
    
    use UserInfo;
    public function getLastDepositAmount($id)
    {
        $transaction = Transaction::where([
            ['account_id', $id],
            ['action', 'deposit'],
            ])->latest()->first();
         // dd($transaction['amount']);

        $amount = '0';
        if (!is_null($transaction['amount']))
        {
            $amount = $transaction['amount'];
        } 
        return $amount;
    }

    public function getPaymentgatewayid($currency_id)
    {

        //dd($currency_id);
        $paymentmethod = Paymentgateway::where('currency_id', $currency_id)->get(['id'])->toArray();
        $id = $paymentmethod[0]['id'];
        // dd($displayname);
       
        return $id;
    }

    public function getLastDepositDateTime($id)
    {
        $transaction = Transaction::where('account_id', $id)->latest()->first();
         // dd($transaction['amount']);

        $created_at = '';
        
        if (!is_null($transaction['created_at']))
        {
            $created_at = $transaction['created_at'];
        } 
        return $created_at;

    }

    public function getTransactionUsername($account_id)
    {
        $getuserid = Usercurrencyaccount::where('id', '=', $account_id)->get(['user_id'])->toArray();
        $user_id = $getuserid[0]['user_id'];
        // dd($user_id);

        $user = User::where('id', $user_id)->get(['name'])->toArray();
        $username = $user[0]['name'];
        // dd($username);
        return $username;
    }

    public function getTransactionUserid($account_id)
    {
        $getuserid = Usercurrencyaccount::where('id', '=', $account_id)->get(['user_id'])->toArray();
        $user_id = $getuserid[0]['user_id'];        
        return $user_id;
    }

    public function getTransactionPaymentName($paymentid)
    {
        $paymentmethod = Paymentgateway::where('id', $paymentid)->get(['displayname'])->toArray();
        $displayname = $paymentmethod[0]['displayname'];

        // dd($displayname);
        return $displayname;
    }

    public function getTransactionNumber($id)
    {
        $transaction = Transaction::where('id', $id)->first();
        
        $transaction_number = json_decode($transaction['response'], true);
        // dd($transaction_number['transaction_number']);
        return $transaction_number['transaction_number'];
    }

    public function getBalance_old($currencyid, $user_id)
    {
          // dd($user_id);
        $getid = Usercurrencyaccount::where([
            ['currency_id', '=', $currencyid],
            ['user_id', '=', $user_id]
            ])->get(['id'])->toArray();
        $usercurrencyaccountid = $getid[0]['id'];


    
        $creditTransactions = Transaction::where([
            ['account_id', $usercurrencyaccountid],
            ['type', 'credit'],
             ['status', 1],
            ])->whereIn('action', array('deposit', 'transfer', 'exchange'))->sum('amount');
             // print_r($creditTransactions

            
        $debitTransactions  = Transaction::where(
                        'account_id' ,$usercurrencyaccountid)
                        ->where('type', '=', 'debit')->sum('amount');
        // print_r($debitTransactions);
         $balance = $creditTransactions - $debitTransactions;
          

        return $balance;
    }
    public function getBalance($currencyid, $user_id)
    {

        $user =User::find($user_id);
        $balance=$this->getUserCurrencyBalance($user,$currencyid);
          

        return $balance;
    }

    public function getTransactionAccountName($account_id)
    {
        $getuseraccount = Usercurrencyaccount::where('id', '=', $account_id)->get(['account_no'])->toArray();
        $getuseraccountno = $getuseraccount[0]['account_no'];
        
        return $getuseraccountno;
    }
        
     public function getTransactionAccountNames($account_id,$paymentid)
    {
        $getuseraccount = Usercurrencyaccount::where('id', '=', $account_id)->get(['account_no'])->toArray();
        $getuseraccountno = $getuseraccount[0]['account_no'];

         $paymentmethod = Paymentgateway::where('id', $paymentid)->first();

      // dd($paymentmethod->params);

        $request = json_decode($paymentmethod->params, true); 


        $getdetails="" .$getuseraccountno."<br/>"."Account Name: ".$request['account_name']."<br/>"."Account No: ".$request['account_no']."<br/>"."Bank Name: ".$request['bank_name']."<br/>"."Bank Address: ".$request['bank_address']."<br/>"."Swift Code: ".$request['swift_code']."<br/>";
       

        return $getdetails;
    }
    

    public function getCurrencyName($account_id)
    {
        $getuseraccount = Usercurrencyaccount::where('id', '=', $account_id)->with('currency')->first();
        // dd($getuseraccount);
        
        return $getuseraccount->currency->token;
    }


    public function getUsername($id)
    {
        $user = User::where('id', $id)->first();
        //dd($id);
        return $user->name;
    }

    public function getMessageUnreadCount($conversationid)
    {
        $messagecount = Message::where([
            ['conversation_id', $conversationid],
            ['user_id', '!=', Auth::id()],
            ['is_seen', 0]
            ])->count();      

        return $messagecount;
    }

    public function getCountryName($countryid)
    {

        $country = Country::where([
            ['id', '=', $countryid]
            ])->first();

        return $country->name;
    }

    public function getCurrencyCode($accountid)
    {

        $currencydetails = Usercurrencyaccount::where([
            ['id', '=', $accountid]
            ])->with('currency')->first();

        return $currencydetails->currency->name;
    }

    public function getAdminSenderAccountName($account_id, $user_id)
    {

        $getaccount = Usercurrencyaccount::where('id', '=', $account_id)->get(['currency_id'])->toArray();
        $getaccountcurrency = $getaccount[0]['currency_id'];

         $getuseraccount = Usercurrencyaccount::where([
            ['currency_id', '=', $getaccountcurrency],
            ['user_id', $user_id],
            ])->get(['account_no'])->toArray();
        
        $getaccountname = $getuseraccount[0]['account_no'];
        
        return $getaccountname;
    }

    public function getTransactionWithdrawAccountName($account_id)
    {
        $getaccount = Usercurrencyaccount::where('id', '=', $account_id)->get(['currency_id'])->toArray();
        $getaccountcurrency = $getaccount[0]['currency_id'];

        $getadminaccount = Usercurrencyaccount::where([
            ['currency_id', '=', $getaccountcurrency],
            ['user_id', 1],
            ])->get(['account_no'])->toArray();
        $getaccountname = $getadminaccount[0]['account_no'];
        
        return $getaccountname;
    }

    public function getExchangeSenderAccountName($account_id)
    {
        // echo $account_id;
        $getaccount = Usercurrencyaccount::where('id', '=', $account_id)->get(['currency_id'])->toArray();
        $getaccountcurrency = $getaccount[0]['currency_id'];

    /*    $getadminaccount = Usercurrencyaccount::where([
            ['currency_id', '=', $getaccountcurrency],
            ['user_id', 1],
            ])->get(['account_no'])->toArray();
        $getaccountname = $getadminaccount[0]['account_no'];*/

        $getadminaccount = Usercurrencyaccount::where([
            ['currency_id', '=', $getaccountcurrency],
            ['user_id', 1],
            ])->with('currency')->get();
        $getaccountname = $getadminaccount[0]['account_no'];

       
        
        return $getaccountname;
    }

     public function getExchangeReceiverAccountName($account_id)
    {
        // echo $account_id;
        $getaccount = Usercurrencyaccount::where('id', '=', $account_id)->get(['currency_id', 'user_id'])->toArray();
        $getaccountcurrency = $getaccount[0]['currency_id'];
        $user_id = $getaccount[0]['user_id'];

      /*  $getadminaccount = Usercurrencyaccount::where([
            ['currency_id', '=', $getaccountcurrency],
            ['user_id', $user_id],
            ])->get(['account_no'])->toArray();
        $getaccountname = $getadminaccount[0]['account_no'];*/

        $getadminaccount = Usercurrencyaccount::where([
            ['currency_id', '=', $getaccountcurrency],
            ['user_id', 1],
            ])->with('currency')->get();
        $getaccountname = $getadminaccount[0]['account_no'];

        
        
        return $getaccountname;
    }

    public function getTransactionFundtransferName($transactionid)
    {
        $transaction = Transaction::where('id', $transactionid)->first();
         // dd($transaction->response);
         $responsedata = json_decode($transaction->response, true);
        // dd($responsedata['from_account_id']);
          if ( isset($responsedata['from_account_id']))
          {
                 $getadminaccount = Usercurrencyaccount::where('id', '=', $responsedata['from_account_id'])->get(['account_no'])->toArray();
             $getaccountname = $getadminaccount[0]['account_no'];
          }
          else
          {
                $getaccountname = '';
          }

        return $getaccountname;

    }

    public function getFundtransferReceiverName($transactionid)
    {
        $transaction = Transaction::where('id', $transactionid)->first();
         // dd($transaction->response);
         $responsedata = json_decode($transaction->response, true);
        // dd($responsedata['from_account_id']);
          if ( isset($responsedata['to_account_id']))
          {
                 $getadminaccount = Usercurrencyaccount::where('id', '=', $responsedata['to_account_id'])->get(['account_no'])->toArray();
             $getaccountname = $getadminaccount[0]['account_no'];
          }
          else
          {
                $getaccountname = '';
          }

        return $getaccountname;

    }

    public function getFundDepositSendername($account_id)
    {

         $getaccount = Usercurrencyaccount::where('id', '=', $account_id)->get(['currency_id'])->toArray();
        $getaccountcurrency = $getaccount[0]['currency_id'];

        $getadminaccount = Usercurrencyaccount::where([
            ['currency_id', '=', $getaccountcurrency],
            ['user_id', 1],
            ])->get(['account_no'])->toArray();
        $getaccountname = $getadminaccount[0]['account_no'];
        
        return $getaccountname;
    }

    public function getFundDepositReceivername($account_id)
    {
        $getuseraccount = Usercurrencyaccount::where('id', '=', $account_id)->get(['account_no'])->toArray();
        $getuseraccountno = $getuseraccount[0]['account_no'];
        
        return $getuseraccountno;
       
    }   

    public function getCurrencyImage($accountid)
    {

        $currencydetails = Usercurrencyaccount::where([
            ['id', '=', $accountid]
            ])->with('currency')->first();

        return $currencydetails->currency->image;
    }
    public function getAdminEarnings($currencyid,$user_id)
    {

        $getid = Usercurrencyaccount::where([
            ['currency_id', '=', $currencyid],
            ['user_id', '=', $user_id]
            ])->get(['id'])->toArray();

        $usercurrencyaccountid = $getid[0]['id'];


        $earnings = Transaction::where([
            ['account_id', $usercurrencyaccountid],
            ['type', 'credit'],
             ['status', 1],
            ])->sum('amount');

        return $earnings;

    }
     public function getSenderAccountName($account_id)
    {
        // echo $account_id;
        $getaccount = Usercurrencyaccount::where('id', '=', $account_id)->with('currency')->get();
        $getaccountname = $getaccount[0]['account_no'];
        
        
        return $getaccountname;
    }
     public function getCurrencyDisplayName($accountid)
    {

        $currencydetails = Usercurrencyaccount::where([
            ['id', '=', $accountid]
            ])->with('currency')->first();

        return $currencydetails->currency->displayname;
    }

    public function getLastTransaction($id)
    { 
        $transaction = Transaction::where('account_id', $id)->latest()->first();
     
        return $transaction;
    }
  
   //Added -sss
    public function getAccountNo($user_id,$currency_id)
    {
       $getuseraccount = Usercurrencyaccount::where([['user_id', '=', $user_id],['currency_id',$currency_id]])->get(['account_no'])->toArray();
        $getuseraccountno = $getuseraccount[0]['account_no'];
        
        return $getuseraccountno;
    }
    public function getDepositDetails($data)
    {
        $getuseraccountno = $this->getAccountNo($data->user_id,$data->currency_id);

        $paymentmethod = Paymentgateway::where('id', $data->paymentgateway_id)->first();

      // dd($paymentmethod->params);

        $request = json_decode($paymentmethod->params, true); 


        $getdetails="" .$getuseraccountno."<br/>"."Account Name: ".$request['account_name']."<br/>"."Account No: ".$request['account_no']."<br/>"."Bank Name: ".$request['bank_name']."<br/>"."Bank Address: ".$request['bank_address']."<br/>"."Swift Code: ".$request['swift_code']."<br/>";
       

        return $getdetails;
    }

    //Added -sss


    
}
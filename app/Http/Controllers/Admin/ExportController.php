<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Redirect;
use League\Csv\Writer;
use App\Models\Usercurrencyaccount;
use App\Traits\UserInfo;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Userpayaccounts;
use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Models\Fundtransfer;
use App\Models\Exchange;
use App\SendMail;
use App\Models\ActivityLog;
use App\Models\Faq;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Exports\UsersExport;
use App\Exports\MemberBalanceExport;
use App\Exports\AllMemberBalanceExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AllMemberExport;

class ExportController extends Controller
{
    use Exportable,UserInfo;

    public function __construct()
    {
         $this->middleware(['auth','admin1']);
    }

    public function exportUsers()
    {   
        $users = User::with('userprofile')->UserGroup('3')->get();
      
        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        if(count($users) > 0)
        {
            $csv->insertOne(['Username','Email','First Name','Last name','Country']);
            
            foreach($users as $user) 
            {
                $country='';
                    if(count($user->userprofile->usercountry)>0)
                    {
                       $country=$user->userprofile->usercountry->name;
                    }
                $csv->insertOne([$user->name,$user->email,$user->userprofile->firstname,$user->userprofile->lastname,$country]);
            }
        }
        else
        {
            $csv->insertOne(['No Records Found']);
            $csv->output('Users_'.date('_d/m/Y_H:i').'.csv');
        }  
        $csv->output('Users-'.date('d-m-Y H:i').'.csv');       
    }  

    public function exportMember()
    {   
        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $balance=[];
        $i=0;
        $user = User::ByUserType('3')->with('userprofile')->get();

        //dd($user)

        if(count($user) > 0)
        {     
            $currency = Currency::where('status','1')->orderBy('id','ASC')->pluck('token');

            $currencyresult = array('Username','BTC','LTC');

                foreach($currency as $currencies)
                {
                    $currencyresult[] = $currencies;
                }
                        
            $csv->insertOne($currencyresult);

            foreach ($user as $key => $value) 
            {
                $walletlistss = Usercurrencyaccount::where('user_id', $value->id)->with('currency')->get();
                
                //$walletbal = new Collection;
               
                //BTC 
                $pg_btc= $this->getPgDetailsByGatewayName('bitcoin_blockio');
                $user_accounts_btc = '';
                $balance_btc = 0;
                $user_accounts_btc = Userpayaccounts::getAccountDetails($value->id,$pg_btc->id)->first();
                if(count($user_accounts_btc)>0)
                {
                  if($user_accounts_btc->btc_address!='')
                  {
                    $balance_btc = $this->getWalletBalance($user_accounts_btc->btc_address);

                    $user_accounts_btc = $user_accounts_btc->btc_address;
                    //dd($user_accounts_btc);

                  }
                }
                  $btc_currency_details=$this->getCurrencyDetailsByName('BTC');
                //LTC
                $pg_ltc = $this->getPgDetailsByGatewayName('ltc_blockio');
                $user_accounts_ltc = '';
                $balance_ltc = 0;
                $user_accounts_ltc = Userpayaccounts::getAccountDetails($value->id,$pg_ltc->id)->first();
                if(count($user_accounts_ltc)>0)
                {
                    if($user_accounts_ltc->ltc_address!='')
                      {
                           $balance_ltc = $this->getLTCWalletBalance($user_accounts_ltc->ltc_address);

                           $user_accounts_ltc = $user_accounts_ltc->ltc_address;
                      }
                }
                 $ltc_currency_details=$this->getCurrencyDetailsByName('LTC');

                // //DOGE
                // $pg_doge = $this->getPgDetailsByGatewayName('dogecoin_blockio');
                // $user_accounts_doge = '';
                // $balance_doge=0;
                // $user_accounts_doge=Userpayaccounts::getAccountDetails($value->id,$pg_doge->id)->first();
                // if(count($user_accounts_doge)>0)
                // {
                //   if($user_accounts_doge->doge_address!='')
                //     {
                //          $balance_doge=$this->getDOGEWalletBalance($user_accounts_doge->doge_address);
                //          $user_accounts_doge = $user_accounts_doge->doge_address;
                //     }
                // }
                // $doge_currency_details = $this->getCurrencyDetailsByName('DOGE');

                // $balance[$i]['name'] = $value->name;
                // $balance[$i]['btc_address'] = $value->user_accounts_btc;
                // $balance[$i]['ltc_address'] = $value->user_accounts_ltc;
                // $balance[$i]['doge_address'] = $value->user_accounts_doge;
                // $balance[$i]['btc_balance'] = $value ->balance_btc;
                // $balance[$i]['ltc_balance'] = $value ->balance_ltc;
                // $balance[$i]['doge_balance'] = $value->balance_doge;
                // $balance[$i]['btc_token'] = $btc_currency_details->token;
                // $balance[$i]['ltc_token'] = $ltc_currency_details->token;
                // $balance[$i]['doge_token'] = $doge_currency_details->token;
                
                $result = array($value->name, $user_accounts_btc." - ". $balance_btc, $user_accounts_ltc." - ".$balance_ltc);

               foreach ($walletlistss as $keys => $values) 
                {
                    $userbal = $this->getUserCurrencyBalance($value,$values->currency_id);          

                    // $balance[$i][$values->currency->token] = $userbal;

                    $result[]=$userbal;
                }  
               //dd($result);
                 $csv->insertOne($result);
                 $i++;  
            }
        }       
        else
        {
            $csv->insertOne(['No Records Found']);
        } 
            $csv->output('Users_'.date('_d/m/Y_H:i').'.csv');       
    } 

    public function exportCryptoExchangeFee()
    {
        $accounting_code=$this->getAccountingCode('external-exchange-fee');

        $exchangefee = Transaction::where('accounting_code_id' ,$accounting_code)->where('type', 'credit')->with('externalexchange')->orderBy('id','DESC')->get(); 
      //dd($exchangefee);
        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        if(count($exchangefee) > 0)
        {
            $csv->insertOne(['Username','From Currency','To Currency','Fee','Date']);
            
            foreach($exchangefee as $exchangefees) 
            {               
                $csv->insertOne([$exchangefees->externalexchange->user->name,$exchangefees->externalexchange->from_currency->token,$exchangefees->externalexchange->to_currency->token ,$exchangefees->externalexchange->fee_total, Carbon::parse($exchangefees->created_at)->format('Y/m/d')]);
            }
        }
        else
        {
            $csv->insertOne(['No Records Found']);
        }  

        $csv->output('ExchangeFee_'.date('Y-m-d H:i:s').'.csv');       

    }

    public function exportFund() 
    {
        $activefundlists = Transaction::where([['type', 'credit'],['deposit_status', 'active'],['action', 'deposit']])->get();

        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        if(count($activefundlists) > 0)
        {
            $csv->insertOne(['Username','Amount','Account Name','Payment Method','Date']);

            foreach($activefundlists as $key => $fund) 
            {
                $payment = json_decode($fund['request'],true); 
                $fundusername = $fund->present()->getTransactionUsername($fund->account_id);
                $acname = $fund->present()->getTransactionAccountName($fund->account_id);
                $paymentname = $fund->present()->getTransactionPaymentName($payment['payment_id']);

                $csv->insertOne([$fundusername, $fund->amount, $acname, $paymentname, Carbon::parse($fund->created_at)->format('Y/m/d')]);
            }
        }     
        else
        {
            $csv->insertOne(['No Records Found']);
        }  

      //  $csv->output('ExchangeFee_'.date('_Y/m/d_H:i:s').'.csv');       
        $csv->output('ExchangeFee_'.date('Y-m-d H:i:s').'.csv');       
    }

    public function exportfundtransfer()
    {
        $fundtransfer = Fundtransfer::with('fundtransfer_to_id', 'fundtransfer_from_id', 'transaction')->orderBy('id', 'DESC')->get();

        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        if(count($fundtransfer) > 0)
        {
            $csv->insertOne(['Amount','Sender','Receiver','Transfer Date']);
            
            foreach($fundtransfer as $fundtransfers) 
            {               
                $sendername = ucfirst($fundtransfers->present()->getUsername($fundtransfers->fundtransfer_from_id->user_id));
                $receivername = ucfirst($fundtransfers->present()->getUsername($fundtransfers->fundtransfer_to_id->user_id));

                $csv->insertOne([$fundtransfers->amount, $sendername, $receivername, Carbon::parse($fundtransfers->created_at)->format('Y/m/d')]);
            }
        }
        else
        {
            $csv->insertOne(['No Records Found']);
        }  

        $csv->output('ExchangeFee_'.date('_Y/m/d_H:i:s').'.csv');       
    }

    public function exportexchange()
    {
        $exchanges = Exchange::with(['user', 'exchange_from_account', 'exchange_to_account'])->get();

        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        if (count($exchanges)>0) 
        {
            $csv->insertOne(['Username','From Account','From Amount','Exchange Account','Exchange Amount','Created On']);

            foreach ($exchanges as $key => $exchange) 
            {
                $csv->insertOne([$exchange->user->name, $exchange->exchange_from_account->account_no, $exchange->exchange_to_account->account_no, $exchange->from_amount, $exchange->to_amount, Carbon::parse($exchange->created_at)->format('Y/m/d')]);
            }  
        }
        else
        {
            $csv->insertOne(['No Records Found']);
        }
        $csv->output('Exchange_'.date('_Y/m/d_H:i:s').'.csv');
    }

    public function exportsendmaillist()
    {
        $mail = SendMail::orderby('id','DESC')->get();
        //dd($list);

        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        if (count($mail)>0) 
        {
            $csv->insertOne(['Username','Subject','Message','Date']);

            foreach ($mail as $key => $sendmail) 
            {
                $csv->insertOne([$sendmail->user->name, $sendmail->subject, $sendmail->message, Carbon::parse($sendmail->created_at)->format('Y/m/d_H:i:s')]);
            }
        }
        else
        {
            $csv->insertOne(['No Records Found']);
        }
        $csv->output('SendMail_'.date('_Y/m/d_H:i:s').'.csv');
    }

    public function exportearnings()
    {
        $currency = Currency::pluck('id')->toarray();
           
        $allAccount = Usercurrencyaccount::whereIn('currency_id', $currency)->where('user_id', '1')->pluck('id')->toarray();
        
        $getcommissions = Transaction::whereIn('account_id' ,$allAccount)->where('type', 'credit')->with('accountingcode')->orderBy('id','ASC')->get(); 
         
        $walletlists = Usercurrencyaccount::join('currencies', 'usercurrencyaccounts.currency_id', '=', 'currencies.id')
            ->select('usercurrencyaccounts.*', 'currencies.*')
            ->where('usercurrencyaccounts.user_id', Auth::id())
            ->orderBy('currencies.order', 'ASC')
            ->get(); 

         $csv = Writer::createFromFileObject(new \SplTempFileObject());

        if(count($walletlists)>0)
        {
            foreach ($walletlists as $key => $walletlist) 
            {
                $wallet = $walletlist->currency->token.'-'.$walletlist->present()->getAdminEarnings($walletlist->currency->id, $walletlist->user_id); 

                $result[] = $wallet;
            }


            $csv->insertOne($result);               
        }

        if(count($getcommissions)>0)
        {
            $csv->insertOne(['Amount','Earnings Type','credited From','credited At']);

            foreach ($getcommissions as $key => $getcommission) 
            {
                $fromdetails = json_decode($getcommission['request'], true);
                $currencyname = $getcommission->present()->getCurrencyName($getcommission->account_id);
                
                if(isset($fromdetails['userid']))
                {
                    $username = ucfirst($getcommission->present()->getUsername($fromdetails['userid']));
              
                }
                $csv->insertOne([$getcommission->amount." - ".$currencyname, $getcommission->accountingcode->accounting_code, $username, Carbon::parse($getcommission->created_at)->format('Y/m/d_H:i:s')]);
               
            }
        }
        else
        {
            $csv->insertOne(['No Records Found']);
        }
         $csv->output('Earnings_'.date('_Y/m/d_H:i:s').'.csv');
    }

    public function exportactivitylogs()
    {
        $loglists = ActivityLog::with('loguser')->orderBy('id', 'DESC')->get();

        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        if (count($loglists)>0) 
        {
            $csv->insertOne(['Log Name','Username','Description', 'IP Address', 'Date']);

            foreach ($loglists as $key => $loglist) 
            {
                $properties = json_decode($loglist['properties'], true);

                $ip_address = '';

                if (isset($properties['ip']))
                {
                    $ip_address = $properties['ip'];
                }
                $logname = ucfirst($loglist->log_name);

                $csv->insertOne([$logname, $loglist->loguser->name, $loglist->description, $ip_address, Carbon::parse($loglist->created_at)->format('Y/m/d_H:i:s')]);

            }
        }
        else
        {
            $csv->insertOne(['No Records Found']);
        }
            $csv->output('ActivityLog'.date('_Y/m/d_H:i:s').'.csv');

    }
    public function exportWallet($id) 
    {
        $currency = Currency::orderBy('order', 'ASC')->get();
        $totalequ = 0;
        $i = 0;
        $balance = 0;
        $equ = 0;
        $address ="";

         $wallets =new Collection;
         $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(['Username','Coin Name','Token Name','Address','Balance','Balance(KRW)']);
      if(count($currency) > 0)
        {
        foreach ($currency as $val) {
            $balance = 0;
            $equ = 0;
            $address ="";  
            $i++;
            try {
                $user = User::where('id', $id)->with('userprofile')->first();
                if ($val->name == "KRW") {
                  $userpay = Usercurrencyaccount::where('currency_id', $val->id)->where('user_id', $id)->first();
                   $address = $userpay->account_no;
                    $balance = $this->getUserCurrencyBalance($user, $val->id);

                    $equ = $balance;

                    $totalequ += $balance;

                } else if ($val->name == "USD") {

                  $userpay = Usercurrencyaccount::where('currency_id', $val->id)->where('user_id', $id)->first();

                    $address = $userpay->account_no;
                    $balance = $this->getUserCurrencyBalance($user, $val->id);

                    $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                    (double) $totalequ += $equ;
                } else if ($val->name == 'BTC') {
                    //BTC
                    $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');

                   // dd($pg);

                    $user_accounts = Userpayaccounts::getAccountDetails($id, $pg->id)->first();
                    if (count($user_accounts) > 0) {

                         $address = $user_accounts->btc_address;
                        if ($user_accounts->btc_address != '') {
                            $balance = $this->getWalletBalance($user_accounts->btc_address);

                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');

                            (double) $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'LTC') {
                    $pg = $this->getPgDetailsByGatewayName('ltc_blockio');

                    $user_accounts = Userpayaccounts::getAccountDetails($id, $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->ltc_address;
                        if ($user_accounts->ltc_address != '') {
                            $balance = $this->getLTCWalletBalance($user_accounts->ltc_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'ETH') {
                    $pg = $this->getPgDetailsByGatewayName('eth');

                    $user_accounts = Userpayaccounts::getAccountDetails($id, $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->eth_address;
                        if ($user_accounts->eth_address != '') {
                            $balance = $this->getETHWalletBalance($user_accounts->eth_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'BCH') {
                    $pg = $this->getPgDetailsByGatewayName('bch');

                    $user_accounts = Userpayaccounts::getAccountDetails($id, $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->bch_address;
                        if ($user_accounts->bch_address != '') {
                            $balance = $this->getBCHWalletBalance($user_accounts->bch_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $equ;

                        }
                    }
                }

            } catch (Exception $e) {

                // dd($e->getMessage());
            }

            $csv->insertOne([$user->name, $val->displayname, $val->name,$address, $balance,$equ]);

            

        }
      }

        else{
            $csv->insertOne(['No Records Found']);
        }

      //  $csv->output('ExchangeFee_'.date('_Y/m/d_H:i:s').'.csv');       
        $csv->output('ExchangeWallet_'.date('Y-m-d H:i:s').'.csv');       
    }

    public function exportWalletXLSs($id) 
    {

        //dd("JJ");
        $currency = Currency::orderBy('order', 'ASC')->get();
        $totalequ = 0;
        $i = 0;
        $balance = 0;
        $equ = 0;
        $address ="";

         Excel::create('Report', function($excel) use ($currency) {
        $excel->sheet('report', function($sheet) use($currency) {
            $sheet->appendRow(array('Username','Coin Name','Token Name','Address','Balance','Balance(KRW)'
            ));
            $currency->chunk(100, function($rows) use ($sheet)
            {
                foreach ($rows as $val)
                {
                     $balance = 0;
            $equ = 0;
            $address ="";  
            $i++;

                    try {
                $user = User::where('id', $id)->with('userprofile')->first();
                if ($val->name == "KRW") {
                  $userpay = Usercurrencyaccount::where('currency_id', $val->id)->where('user_id', $id)->first();
                   $address = $userpay->account_no;
                    $balance = $this->getUserCurrencyBalance($user, $val->id);

                    $equ = $balance;

                    $totalequ += $balance;

                } else if ($val->name == "USD") {

                  $userpay = Usercurrencyaccount::where('currency_id', $val->id)->where('user_id', $id)->first();

                    $address = $userpay->account_no;
                    $balance = $this->getUserCurrencyBalance($user, $val->id);

                    $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                    (double) $totalequ += $equ;
                } else if ($val->name == 'BTC') {
                    //BTC
                    $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');

                   // dd($pg);

                    $user_accounts = Userpayaccounts::getAccountDetails($id, $pg->id)->first();
                    if (count($user_accounts) > 0) {

                         $address = $user_accounts->btc_address;
                        if ($user_accounts->btc_address != '') {
                            $balance = $this->getWalletBalance($user_accounts->btc_address);

                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');

                            (double) $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'LTC') {
                    $pg = $this->getPgDetailsByGatewayName('ltc_blockio');

                    $user_accounts = Userpayaccounts::getAccountDetails($id, $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->ltc_address;
                        if ($user_accounts->ltc_address != '') {
                            $balance = $this->getLTCWalletBalance($user_accounts->ltc_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'ETH') {
                    $pg = $this->getPgDetailsByGatewayName('eth');

                    $user_accounts = Userpayaccounts::getAccountDetails($id, $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->eth_address;
                        if ($user_accounts->eth_address != '') {
                            $balance = $this->getETHWalletBalance($user_accounts->eth_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'BCH') {
                    $pg = $this->getPgDetailsByGatewayName('bch');

                    $user_accounts = Userpayaccounts::getAccountDetails($id, $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->bch_address;
                        if ($user_accounts->bch_address != '') {
                            $balance = $this->getBCHWalletBalance($user_accounts->bch_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $equ;

                        }
                    }
                }

                        } catch (Exception $e) {

                            // dd($e->getMessage());
                        }
                    $sheet->appendRow(array($user->name, $val->displayname, $val->name,$address, $balance,$equ
                    ));
                }
            });
        });
     })->download('xlsx');

     }


    public function exportMemberWallet() 
    {

        $users = User::ByUserType('3')->with('userprofile')->get();

        

        $currency = Currency::orderBy('order', 'ASC')->get();
        $totalequ = 0;
        $i = 0;
        $balance = 0;
        $equ = 0;
        $address ="";

         $wallets =new Collection;
         $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(['Username','Coin Name','Token Name','Address','Balance','Balance(KRW)']);

       
      if(count($currency) > 0)
        {
            foreach ($users as $user) 
            {

         foreach ($currency as $val) {
            $balance = 0;
            $equ = 0;
            $address ="";  
            $i++;
            try {
                
                if ($val->name == "KRW") {
                  $userpay = Usercurrencyaccount::where('currency_id', $val->id)->where('user_id', $user->id)->first();
                   $address = $userpay->account_no;
                    $balance = $this->getUserCurrencyBalance($user, $val->id);

                    $equ = $balance;

                    $totalequ += $balance;

                } else if ($val->name == "USD") {

                  $userpay = Usercurrencyaccount::where('currency_id', $val->id)->where('user_id', $user->id)->first();

                    $address = $userpay->account_no;
                    $balance = $this->getUserCurrencyBalance($user, $val->id);

                    $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                    (double) $totalequ += $equ;
                } else if ($val->name == 'BTC') {
                    //BTC
                    $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');

                   // dd($pg);

                    $user_accounts = Userpayaccounts::getAccountDetails($user->id, $pg->id)->first();
                    if (count($user_accounts) > 0) {

                         $address = $user_accounts->btc_address;
                        if ($user_accounts->btc_address != '') {
                            $balance = $this->getWalletBalance($user_accounts->btc_address);

                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');

                            (double) $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'LTC') {
                    $pg = $this->getPgDetailsByGatewayName('ltc_blockio');

                    $user_accounts = Userpayaccounts::getAccountDetails($user->id, $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->ltc_address;
                        if ($user_accounts->ltc_address != '') {
                            $balance = $this->getLTCWalletBalance($user_accounts->ltc_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'ETH') {
                    $pg = $this->getPgDetailsByGatewayName('eth');

                    $user_accounts = Userpayaccounts::getAccountDetails($user->id, $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->eth_address;
                        if ($user_accounts->eth_address != '') {
                            $balance = $this->getETHWalletBalance($user_accounts->eth_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'BCH') {
                    $pg = $this->getPgDetailsByGatewayName('bch');

                    $user_accounts = Userpayaccounts::getAccountDetails($user->id, $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->bch_address;
                        if ($user_accounts->bch_address != '') {
                            $balance = $this->getBCHWalletBalance($user_accounts->bch_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $equ;

                        }
                    }
                }

            } catch (Exception $e) {

                // dd($e->getMessage());
            }
            if($val->name=='KRW'){
            $csv->insertOne([$user->name, $val->displayname, $val->name,$address, $balance,$equ]);
              }else{
                 $csv->insertOne(['', $val->displayname, $val->name,$address, $balance,$equ]);
              }

           }

          }
      }

        else{
            $csv->insertOne(['No Records Found']);
        }

      //  $csv->output('ExchangeFee_'.date('_Y/m/d_H:i:s').'.csv');       
        $csv->output('ExchangeMemberWallet_'.date('Y-m-d H:i:s').'.csv');       
    }
    public function exportWalletXLS($id) 
    {
        \Session::put('userxls',$id);
       return Excel::download(new MemberBalanceExport, 'memberbalance.xlsx');
    }

    public function exportAllMemberWallet() 
    {
       return Excel::download(new AllMemberBalanceExport, 'allmemberbalance.xlsx');
    }
    public function exportUsersXLS()
    { 

      return Excel::download(new AllMemberExport, 'allmembers.xlsx');  

            
    }  
}
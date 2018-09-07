<?php

namespace App\Http\Controllers\Myaccount;

use App\Http\Requests\ExchangeRequest;
use App\Models\Currency;
use App\Models\Exchange;
use App\Models\Usercurrencyaccount;
use App\Models\Userpayaccounts;
use App\Traits\ExchangeProcess;
use App\Traits\UserInfo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ExchangeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'member']);
    }

    //  use ExchangeProcess,CoinProcess;
    use ExchangeProcess, UserInfo;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function accounts($currency)
    {
        /*$walletlists = Usercurrencyaccount::where([
        ['user_id' , Auth::id()],
        ['currency_id', '!=', 1]
        ])->with('currency')->get();*/
        $scurrency = Currency::where('token',$currency)->get();

        $sitecurrency = $scurrency[0]->name;

        $currencies = Currency::where([
            ['is_coin', '=', 0],

        ])->pluck('id')->toArray();

        $walletlists = Usercurrencyaccount::where([
            ['user_id', Auth::id()],
        ])->whereIn('currency_id', $currencies)->with('currency')->get();

        $walletCount = $walletlists->count();

        $currency = Currency::where('status', 1)->count();

        // dd($walletlists);

        $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
        $balance = 0;
        $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();
        if (count($user_accounts) > 0) {
            if ($user_accounts->btc_address != '') {
                $balance = $this->getWalletBalance($user_accounts->btc_address);
            }
        }

        //LTC
        $pg_ltc = $this->getPgDetailsByGatewayName('ltc_blockio');
        $balance_ltc = 0;
        $user_accounts_ltc = Userpayaccounts::getAccountDetails(Auth::id(), $pg_ltc->id)->first();
        if (count($user_accounts_ltc) > 0) {
            if ($user_accounts_ltc->ltc_address != '') {
                $balance_ltc = $this->getLTCWalletBalance($user_accounts_ltc->ltc_address);
            }
        }

        $btc = $this->getCurrencyDetailsByName('BTC');
        $ltc = $this->getCurrencyDetailsByName('LTC');
        //$doge = $this->getCurrencyDetailsByName('DOGE');

        $balance_btc_equi = $this->getexchangerate($balance, $sitecurrency, $btc->name, 'buy');
        $balance_ltc_equi = $this->getexchangerate($balance_ltc, $sitecurrency, $ltc->name, 'buy');
        //$balance_doge_equi=$this->getexchangerate($balance_doge,$sitecurrency,$doge->name,'buy');

        $balance_btc_equi = number_format((float) $balance_btc_equi, $btc->decimal);
        $balance_ltc_equi = number_format((float) $balance_ltc_equi, $ltc->decimal);
        //$balance_doge_equi= number_format((float)$balance_doge_equi,$doge->decimal);

        return view('exchange.accounts', [
            'walletlists' => $walletlists,
            'walletcount' => $walletCount,
            'user_accounts' => $user_accounts,
            'balance' => $balance,
            'user_accounts_ltc' => $user_accounts_ltc,
            'balance_ltc' => $balance_ltc,
            //'user_accounts_doge'=>$user_accounts_doge,
            //'balance_doge'=>$balance_doge,
            'btc' => $btc,
            'ltc' => $ltc,
            //'doge'=>$doge,
            'balance_btc_equi' => $balance_btc_equi,
            'balance_ltc_equi' => $balance_ltc_equi,
            'scurrency' => $scurrency
            // 'balance_doge_equi'=>$balance_doge_equi,
        ]);

    }

    public function create()
    {

    }

    public function getCurrency()
    {
        $currency = Currency::orderBy('order', 'ASC')->get();
        $totalequ = 0;
        $btc_balance = 0;
        $btc_address = '';
        $ltc_balance = 0;
        $ltc_address = '';
        $eth_balance = 0;
        $eth_address = '';
        $bch_balance = 0;
        $bch_address = '';
        $xrp_balance = 0;
        $xrp_address = '';
        $icx_balance = 0;
        $icx_address = '';
        $eos_balance = 0;
        $eos_address = '';
        $ada_balance = 0;
        $ada_address = '';
        $qau_balance = 0;
        $qau_address = '';
        $etc_balance = 0;
        $etc_address = '';
        $userbalance = 0;

        $btc_equ = 0;
        $ltc_equ = 0;
        $eth_equ = 0;
        $bch_equ = 0;
        $usd_equ = 0;
        $btc_per = 0;
        $eth_per = 0;
        $ltc_per = 0;
        $bch_per = 0;
        $usd_per = 0;

        $xrp_per = 0;
        $ada_per = 0;
        $eos_per = 0;
        $icx_per = 0;
        $qau_per = 0;
        $krw_per = 0;
        $krw_equ = 0;
        $xrp_equ = 0;
        $ada_equ = 0;
        $eos_equ = 0;
        $icx_equ = 0;
        $qau_equ = 0;
        $krw_equ = 0;
        $etc_equ = 0;
        $krw_balance = 0;
        $usd_balance = 0;
        $i = 0;

        foreach ($currency as $val) {

            $i++;
            try {
                $user = User::where('id', Auth::id())->with('userprofile')->first();
                if ($val->name == "KRW") {
                    $krw_balance = $this->getUserCurrencyBalance($user, $val->id);

                    $krw_equ = $krw_balance;

                    $totalequ += $krw_balance;

                } else if ($val->name == "USD") {
                    $usd_balance = $this->getUserCurrencyBalance($user, $val->id);

                    $usd_equ = $this->getexchangerate($usd_balance, 'KRW', $val->name, 'buy');
                    (double) $totalequ += $usd_equ;
                } else if ($val->name == 'BTC') {
                    //BTC
                    $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');

                    $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $btc_address = $user_accounts->btc_address;
                        if ($user_accounts->btc_address != '') {
                            $btc_balance = $this->getWalletBalance($user_accounts->btc_address);

                            $btc_equ = $this->getexchangerate($btc_balance, 'KRW', $val->name, 'buy');

                            (double) $totalequ += $btc_equ;

                        }
                    }
                } else if ($val->name == 'LTC') {
                    $pg = $this->getPgDetailsByGatewayName('ltc_blockio');

                    $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $ltc_address = $user_accounts->ltc_address;
                        if ($user_accounts->ltc_address != '') {
                            $ltc_balance = $this->getLTCWalletBalance($user_accounts->ltc_address);
                            $ltc_equ = $this->getexchangerate($ltc_balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $ltc_equ;

                        }
                    }
                } else if ($val->name == 'ETH') {
                    $pg = $this->getPgDetailsByGatewayName('eth');

                    $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $eth_address = $user_accounts->eth_address;
                        if ($user_accounts->eth_address != '') {
                            $eth_balance = $this->getETHWalletBalance($user_accounts->eth_address);
                            $eth_equ = $this->getexchangerate($eth_balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $eth_equ;

                        }
                    }
                } else if ($val->name == 'BCH') {
                    $pg = $this->getPgDetailsByGatewayName('bch');

                    $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $bch_address = $user_accounts->bch_address;
                        if ($user_accounts->bch_address != '') {
                            $bch_balance = $this->getBCHWalletBalance($user_accounts->bch_address);
                            $bch_equ = $this->getexchangerate($bch_balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $bch_equ;

                        }
                    }
                }

            } catch (Exception $e) {

                // dd($e->getMessage());
            }

            $totalkrw_balance = ($btc_equ + $ltc_equ + $eth_equ + $bch_equ + $usd_equ);

            $curr_detail[] = array(
                "curname" => $val->name,
                "curname_webtype" => strtolower($val->name),
                "id" => $val->id,
                "displayname" => $val->displayname,
                "currimage" => $val->image,
                "type" => $val->type,
                "count_array" => $i,
                "curbalance" => $totalequ,
                "krw_balance" => $krw_balance,
                "usd_balance" => $usd_balance,
                "btc_address" => $btc_address,
                "btc_balance" => $btc_balance,
                "krw_equ" => $krw_equ,
                "btc_equ" => $btc_equ,
                "ltc_equ" => $ltc_equ,
                "eth_equ" => $eth_equ,
                "bch_equ" => $bch_equ,
                "usd_equ" => $usd_equ,
                "btc_per" => $btc_per,
                "ltc_per" => $ltc_per,
                "eth_per" => $eth_per,
                "bch_per" => $bch_per,
                "usd_per" => $usd_per,

                "xrp_per" => $xrp_per,
                "ada_per" => $ada_per,
                "eos_per" => $eos_per,
                "icx_per" => $icx_per,
                "qau_per" => $qau_per,
                "krw_per" => $krw_per,

                "xrp_equ" => $xrp_equ,
                "ada_equ" => $ada_equ,
                "eos_equ" => $eos_equ,
                "icx_equ" => $icx_equ,
                "qau_equ" => $qau_equ,
                "krw_equ" => $krw_equ,
                "etc_equ" => $etc_equ,

                "ltc_balance" => $ltc_balance,
                "ltc_address" => $ltc_address,
                "eth_balance" => $eth_balance,
                "eth_address" => $eth_address,
                "bch_balance" => $bch_balance,
                "bch_address" => $bch_address,
                "xrp_balance" => $xrp_balance,
                "xrp_address" => $xrp_address,
                "icx_balance" => $icx_balance,
                "icx_address" => $icx_address,
                "xrp_balance" => $xrp_balance,
                "xrp_address" => $xrp_address,
                "eos_balance" => $eos_balance,
                "eos_address" => $eos_address,
                "ada_balance" => $ada_balance,
                "ada_address" => $ada_address,
                "qau_balance" => $qau_balance,
                "qau_address" => $qau_address,
                "etc_balance" => $etc_balance,
                "etc_address" => $etc_address,
            );

        }

        $totalkrws_balance = ($btc_equ + $ltc_equ + $eth_equ + $bch_equ + $usd_equ);

        $currencylist = json_encode($curr_detail);

        //$array['currencylist']=  $currency;
        //$array['sellorders']= $sellorders;

        return $currencylist;

    }

    public function buysell()
    {

    }
    public function buy()
    {
        return view('exchange.buy');
    }
    public function sell()
    {
        return view('exchange.buy');
    }
    public function addfund()
    {
        return view('exchange.addfund');
    }
    public function withdrawfund()
    {
        return view('exchange.withdrawfund');
    }
    public function transferfund()
    {
        return view('exchange.transferfund');
    }
    public function exchange()
    {
        $currency = Currency::join('paymentgateways', 'currencies.id', '=', 'paymentgateways.currency_id')
            ->select('currencies.*', 'paymentgateways.*')
            ->where('paymentgateways.exchange', '=', 1)
            ->where('currencies.status', '=', 1)
            ->get();
        // dd($currency);

        return view('exchange.exchange', [
            'currency' => $currency,
        ]);
    }

    public function save(ExchangeRequest $request)
    {
        $success = $this->exchangeprocess($request);

        $request->session()->flash('successmessage', trans('forms.exchange_success_message'));

        return Redirect::to('myaccount/home');
    }

    public function changecurrencyvalue(Request $request)
    {
        $fromcurrency = Currency::where('id', $request->fromcurrency)->first();

        $tocurrency = Currency::where('id', $request->tocurrency)->first();
        // dd($currency);

        //  $gettocurrencyvalue = $this->getUSDToCurrency($fromcurrency->id, $request->fromcurrencyamount, $fromcurrency->name, $tocurrency->name,'sell');

        $gettocurrencyvalue = $this->getexchangerate($request->fromcurrencyamount, $fromcurrency->name, $tocurrency->name, 'sell');

        return $gettocurrencyvalue;
    }
    public function show()
    {
// dd('sdkjf');
        $transactions = Exchange::where('user_id', Auth::id())->with('exchange_from_account', 'exchange_to_account')->orderBy('id', 'DESC')->paginate(10);

        return view('exchange.show', [
            'transactions' => $transactions,
        ]);

    }

    public function getCurrencyNew()
    {
        $currency = Currency::orderBy('order', 'ASC')->get();
        $totalequ = 0;
        $i = 0;
        $balance = 0;
        $equ = 0;
        $address ="";

        foreach ($currency as $val) {
            $balance = 0;
            $equ = 0;
            $address ="";  
            $i++;
            try {
                $user = User::where('id', Auth::id())->with('userprofile')->first();
                $balance = $this->getUserCurrencyBalance($user, $val->id);
                if ($val->name == "KRW") {
                    //$balance = $this->getUserCurrencyBalance($user, $val->id);

                    $equ = $balance;

                    $totalequ += $balance;

                } else if ($val->name == "USD") {
                   // $balance = $this->getUserCurrencyBalance($user, $val->id);
                    $equ = $balance;
                    //$equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                    (double) $totalequ += $equ;

                } else if ($val->name == 'BTC') {
                    //BTC
                    $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');

                    $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->btc_address;
                        if ($user_accounts->btc_address != '') {
                           // $balance = $this->getWalletBalance($user_accounts->btc_address);

                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');

                            (double) $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'LTC') {
                    $pg = $this->getPgDetailsByGatewayName('ltc_blockio');

                    $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->ltc_address;
                        if ($user_accounts->ltc_address != '') {
                         //   $balance = $this->getLTCWalletBalance($user_accounts->ltc_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'ETH') {
                    $pg = $this->getPgDetailsByGatewayName('eth');

                    $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->eth_address;
                        if ($user_accounts->eth_address != '') {
                           // $balance = $this->getETHWalletBalance($user_accounts->eth_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'BCH') {
                    $pg = $this->getPgDetailsByGatewayName('bch');

                    $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->bch_address;
                        if ($user_accounts->bch_address != '') {
                          //  $balance = $this->getBCHWalletBalance($user_accounts->bch_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $equ;

                        }
                    }
                }
         else if ($val->name == 'XRP') {
                $pg = $this->getPgDetailsByGatewayName('xrp');

                $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();
                if (count($user_accounts) > 0) {
                    $address = $user_accounts->xrp_address;
                    if ($user_accounts->xrp_address != '') {
                        // $balance = $this->getXRPWalletBalance($user_accounts->xrp_address);
                        $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                        (double) $totalequ += $equ;

                    }
                }
            }
            else if ($val->name == 'QTUM') {
                //BTC
                $pg = $this->getPgDetailsByGatewayName('qtum');

                $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();
                if (count($user_accounts) > 0) {
                    $address = $user_accounts->qtum_address;
                    if ($user_accounts->qtum_address != '') {
                       // $balance = $this->getWalletBalance($user_accounts->btc_address);

                        $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');

                        (double) $totalequ += $equ;

                    }
                }
            } 

            } catch (Exception $e) {

                // dd($e->getMessage());
            }


            $curr_detail[] = array(
                "curname" => $val->name,
                "curname_webtype" => strtolower($val->name),
                "id" => $val->id,
                "displayname" => $val->displayname,
                "currimage" => $val->image,
                "type" => $val->type,
                "count_array" => $i,
                "curbalance" => $totalequ,
                "balance" => $balance,
                "equ" => $equ,   
            );

        }


        $currencylist = json_encode($curr_detail);

        //$array['currencylist']=  $currency;
        //$array['sellorders']= $sellorders;

        return $currencylist;

    }

}

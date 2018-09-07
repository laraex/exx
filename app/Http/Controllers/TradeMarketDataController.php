<?php

namespace App\Http\Controllers;

use App\CryptoCurrency;
use App\Http\Resources\CurrencyPairCollection;
use App\Models\Currency;
use App\Models\Paymentgateway;
use App\Models\Usercurrencyaccount;
use App\Models\Userpayaccounts;
use App\Models\Userprofile;
use App\TradeCurrencyPair;
use App\TradeOrders;
use App\Traits\ExchangeChart;
use App\Traits\OrderData;
use App\Traits\UserInfo;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradeMarketDataController extends Controller
{
    use UserInfo, OrderData, ExchangeChart;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tradepair = TradeCurrencyPair::where('status', 'active')->get()->keyby('id');

        return new CurrencyPairCollection($tradepair);

    }

    public function currencyDetails($curid)
    {
        $currency = Currency::where('id', $curid)->first();
        $user = User::where('id', Auth::id())->with('userprofile')->first();
        $address = '';
        $balance = 0;
        $pgs = null;
        $balance = $this->getUserCurrencyBalance($user, $curid);
        if ($currency->name == 'BTC') {
            $userpay = Userpayaccounts::where('currency_id', $currency->id)->where('user_id', Auth::id())->first();
            if ($userpay != null) {
                $address = $userpay->btc_address;
               // $balance = $this->getWalletBalance($address);


                $balance = $this->getUserCurrencyBalance($user, $currency->id);
            }
        } else if ($currency->name == 'LTC') {

            $userpay = Userpayaccounts::where('currency_id', $currency->id)->where('user_id', Auth::id())->first();

            if ($userpay != null) {
                $address = $userpay->ltc_address;
              //  $balance = $this->getLTCWalletBalance($address);
            }
        } 
        else if ($currency->name == 'DOGE') {

            $userpay = Userpayaccounts::where('currency_id', $currency->id)->where('user_id', Auth::id())->first();

            if ($userpay != null) {
                $address = $userpay->doge_address;
              //  $balance = $this->getLTCWalletBalance($address);
            }
        }else if ($currency->name == 'ETH') {
            $userpay = Userpayaccounts::where('currency_id', $currency->id)->where('user_id', Auth::id())->first();
            if ($userpay != null) {
                $address = $userpay->eth_address;
               // $balance = $this->getETHWalletBalance($address);
            }
        } else if ($currency->name == 'BCH') {
            $userpay = Userpayaccounts::where('currency_id', $currency->id)->where('user_id', Auth::id())->first();
            if ($userpay != null) {
                $address = $userpay->bch_address;
              //  $balance = $this->getBCHWalletBalance($address);
            }

        } else if ($currency->name == 'KRW') {
            $userpay = Usercurrencyaccount::where('currency_id', $currency->id)->where('user_id', Auth::id())->first();
            $address = $userpay->account_no;

           // $balance = $this->getUserCurrencyBalance($user, $currency->id);

        } else if ($currency->name == 'USD') {
            $userpay = Usercurrencyaccount::where('currency_id', $currency->id)->where('user_id', Auth::id())->first();
            $address = $userpay->account_no;
           // $balance = $this->getUserCurrencyBalance($user, $currency->id);

        } else if ($currency->name == 'XRP') {
            $userpay = Userpayaccounts::where('currency_id', $currency->id)->where('user_id', Auth::id())->first();
            if ($userpay != null) {
                $address = $userpay->xrp_address;
                // $balance = $this->getXRPWalletBalance($address);
            }
        }
        else if ($currency->name == 'QTUM') {
            $userpay = Userpayaccounts::where('currency_id', $currency->id)->where('user_id', Auth::id())->first();
            if ($userpay != null) {
                $address = $userpay->qtum_address;
               // $balance = $this->getQTUMWalletBalance($userpay);
            }
        }
        else if ($currency->type == 'token') {
            $userpay = Userpayaccounts::where('currency_id', 3)->where('user_id', Auth::id())->first();
            if ($userpay != null) {
                $address = $userpay->eth_address;
              //  $balance = $this->getETHTokenBalance($userpay->token,$address);
            }
        }

        
        $pgs = Paymentgateway::where('currency_id', $currency->id)->orderBy('id','DESC')->first();

        if ($pgs != null) {
            $payment_id = $pgs->id;
        } else {
            $payment_id = 0;
        }

        $curlower = strtolower($currency->name);

        $currency_details = array('currency_id' => $currency->id, 'displayname' => $currency->displayname, 'name' => $currency->token, 'image' => $currency->image, 'balance' => $balance, 'address' => $address, 'paymentgateway_id' => $payment_id, 'currency_lower' => $curlower, 'currency_type' => $currency->type);
        $curdetail = json_encode($currency_details);

        return $curdetail;
    }

    public function stats(Request $request)
    {

        \Session::put('currencypair', $request->pairid);

        $currency = TradeCurrencyPair::where('id', $request->pairid)->first();
        $fromcurr = $currency->from_currency_id;
        $tocurr = $currency->to_currency_id;
        $fromcur_name = $currency->fromcurrency->name;
        $tocur_name = $currency->tocurrency->name;

        // dd($currency);
        $latest_order = $this->getOrderValue($fromcurr, $tocurr, 'latest_order');

        $max_order = $this->getOrderValue($fromcurr, $tocurr, 'max_order');
        $min_order = $this->getOrderValue($fromcurr, $tocurr, 'min_order');

        $sell_total_amount = $this->getOrderValue($fromcurr, $tocurr, 'sell_total_amount');

        $hourvolume = $this->getOrderValue($fromcurr, $tocurr, '24hourvolume');
        $houramount = $this->getOrderValue($fromcurr, $tocurr, '24houramount');

        // dd($currency->fromcurrency->name);

        $crypto = CryptoCurrency::where('symbol', $fromcur_name)->first();

        // dd($crypto->volume_24h_usd);

        //  $fromcurrencyname = Currency::where('id',$fromcurr)->first();

        //$tocurrencyname = Currency::where('id',$tocurr)->first();

        $fromcurrencyname = $currency->fromcurrency->token;
        $tocurrencyname = $currency->tocurrency->token;

        if ($max_order == null) {
            $max_order = $crypto->price_usd;
        }
        if ($min_order == null) {
            $min_order = $crypto->price_usd;
        }
        if ($hourvolume == null) {
            $hourvolume = 0;
        }
        if ($houramount == null) {
            $houramount = $crypto->volume_24h_usd;
        }
        if ($sell_total_amount != '') {
            $sell_total_amount = 0;
        }
        if ($latest_order != null) {

            $latestorder = $latest_order->amount;

        } else {
            $latestorder = $crypto->price_usd;
        }
       
        $balance = 0;
        $sell_balance = 0;

        //$currency_name=$fromcurrencyname->name."-".$tocurrencyname->name;
        $currency_name = $fromcurrencyname . "-" . $tocurrencyname;

        //dsfsd
        $chartval = $this->getExchangeValues($currency->fromcurrency->name, '10');
        
        // dd("HHas");

        if (Auth::id() != '') {
            $isLogin = 1;
            $user = User::where('id', Auth::id())->with('userprofile')->first();
            //dd($tocurrencyname);
            // if($tocurrencyname=='USD' || $tocurrencyname=='KRW'){

            //  $userbalance = $this->getUserCurrencyBalance($user, $tocurr);
            //    }else{
            //   $userbalance=0;
            //   }

            if ($tocurr != '') {

                $balance = $this->getUserCurrencyBalance($user, $tocurr);
               // $balance = $this->getcurrencyBalance($tocurrencyname, $tocurr, Auth::id(), 'balance');//Imp Blockchain
            }
            if ($fromcurr != '') {

                $sell_balance = $this->getUserCurrencyBalance($user, $fromcurr);

               // $sell_balance = $this->getcurrencyBalance($fromcurrencyname, $fromcurr, Auth::id(), 'balance');//Imp Blockchain
            }

        } else {
            $balance = 0;
            $sell_balance = 0;
            $isLogin = 0;
        }

        //dd("HHqs");

        $curr_detail = array("max_order" => $max_order, "min_order" => $min_order, 'latest_order' => $latestorder, 'currency_name' => $currency_name, 'sell_total_amount' => $sell_total_amount, "chartval" => $chartval, "currencypair" => \Session::get('currencypair'), 'buy_userbalance' => $balance, 'sell_userbalance' => $sell_balance, "hourvolume" => $hourvolume, "houramount" => $houramount, 'isLogin' => $isLogin);

        $c = json_encode($curr_detail);

        return $c;
    }
    public function getOrder($pairid)
    {

        $currency = TradeCurrencyPair::where('id', $pairid)->first();

        $orderdata = TradeOrders::where([['to_coin_id', $currency->from_currency_id], ['from_coin_id', $currency->to_currency_id], ['type', 'order']])->with('buyorder', 'sellorder')->orderBy('created_at', 'ASC')->first();

        // dd($orderdata);

//dd(Carbon::now()->subDays(1));
        $lastday = TradeOrders::where([['to_coin_id', $currency->from_currency_id], ['from_coin_id', $currency->to_currency_id], ['type', 'order']])->where('created_at', '>=', Carbon::now()->subDays(1))->with('buyorder', 'sellorder')->first();

        $total_tran = TradeOrders::where([['to_coin_id', $currency->to_currency_id], ['from_coin_id', $currency->from_currency_id], ['type', 'buy']])->where('created_at', '>=', Carbon::now()->subDays(1))->sum('amount');

        //dd($total_tran);

        //dd($lastday);

        if ($orderdata != null) {
            $last_order_amt = $orderdata->buyorder->amount;
        } else {
            $last_order_amt = 0;
        }

        if ($lastday != null) {
            $last_day_amt = $lastday->buyorder->amount;
        } else {
            $last_day_amt = 0;
        }

        //echo $last_day_amt;"<br>";
        //echo $last_order_amt;"<br>";

        //if($last_day_amt<$last_order_amt){
        // dd("HH");
        if ($last_order_amt != '' && $last_day_amt != '') {

            $H24_diff_amt = $last_order_amt - $last_day_amt;
        } else {
            $H24_diff_amt = 0;
        }

        if ($last_day_amt < $last_order_amt) {

            $updown_status = 1;

        } else {
            $updown_status = 0;
        }

        // }else{

        //     $H24_diff_amt=$last_day_amt-$last_order_amt;
        // }
        if ($last_order_amt != '') {

            $per = ($H24_diff_amt / $last_order_amt * 100);
        } else {
            $per = 0;
        }

        $order = array('last_order_amt' => $last_order_amt, 'diff_amt' => $H24_diff_amt, 'order_per' => $per, 'updown_status' => $updown_status);

        $orders = json_encode($order);

        return $orders;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getPair()
    {

        $pair_currency = TradeCurrencyPair::distinct()->where('status', 'active')->pluck('to_currency_id');
        $pair = Currency::whereIn('id', $pair_currency)->where('is_tab', 1)->orderBy('order')->get();

        return $pair;
    }
    public function pairmarketrate()
    {
        $currency = Currency::where('is_tab', 1)->orderBy('order')->pluck('id');

        $userprofile = Userprofile::where('user_id', Auth::id())->with('user')->first();

        $tradepair = TradeCurrencyPair::whereIn('to_currency_id', $currency)->where('status', 'active')->get()->keyby('id');

        if (Auth::id()) {
            if (count($tradepair) > 0) {
                foreach ($tradepair as $key => $value) {
                    if (in_array($value->id, explode(',', $userprofile->fav_pair))) {
                        $tradepair[$key]['favourite'] = true;
                    } else {
                        $tradepair[$key]['favourite'] = false;
                    }

                }
            }
        }
        return new CurrencyPairCollection($tradepair);

    }
    public function checkXRP()
    {

        $currency = TradeCurrencyPair::where('id', 1)->first();
        $fromcurr = $currency->from_currency_id;
        $tocurr = $currency->to_currency_id;
        $fromcur_name = $currency->fromcurrency->name;
        $tocur_name = $currency->tocurrency->name;
        $balance = 0;

        $fromcurrencyname = $currency->fromcurrency->token;
        $tocurrencyname = $currency->tocurrency->token;
        if ($tocurr != '') {

            $balance = $this->getcurrencyBalance($tocurrencyname, $tocurr, Auth::id(), 'balance');
        }
        $pair_details = TradeCurrencyPair::where([['id',5],['status','active']])->first();

        $getrate=$this->getexchangerate(1,  $pair_details->tocurrency->name,  $pair_details->fromcurrency->name,'buy');

        if($getrate * 30 < $balance){
          return "success";
        }else{
          return "fail";
        }
    }
}

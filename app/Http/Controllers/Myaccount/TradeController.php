<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Myaccount;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Currency;
use App\Traits\CoinProcess;
use App\User;
use App\Http\Requests\BuyCoinRequest;
use App\Models\Country;
use App\Coinorder;
use App\CurrencyPair;
use App\Traits\LogActivity;
use App\Requestorder;
use Config;
use App\TradeCurrencyPair;
use App\TradeOrders;
use App\Traits\TradeOrdersProcess;
use App\Models\Transaction;
use App\Models\Usercurrencyaccount;
use App\CoinTransactions;
use App\Models\Userpayaccounts;
use App\Models\Paymentgateway;
use Illuminate\Database\Eloquent\Collection;
use App\Currencies;
use App\Deposit;
use App\Transfer;
use App\Models\Withdraw;
class TradeController extends Controller
{

  public function __construct()
  {
      //$this->middleware(['auth', 'member']);
    $this->middleware(['auth', 'member'])->except(['index', 'show', 'showDetails', 'showTrade']);
  }
//CoinProcess,LogActivity,,CoinProcess
  use TradeOrdersProcess;


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function index()
  {
    $coin_currency_id = \Session::get('coin_currency_id');

    $currencyaccounts = $this->getAccountDetails(Auth::id(), $coin_currency_id);

    $currencydetails = Currency::where('id', $coin_currency_id)->first();

    $currency = Currency::join('paymentgateways', 'currencies.id', '=', 'paymentgateways.currency_id')
      ->select('currencies.*', 'paymentgateways.*')
      ->where('paymentgateways.exchange', '=', 1)
      ->where('currencies.status', '=', 1)
      ->get();

    $list = CurrencyPair::where('status', 'active')->orderBy('from_currency_id', 'ASC')->get();

         // dd($currency['token']);

    return view('trade.trade', [
      'currencydetails' => $currencydetails,
      'currencyaccounts' => $currencyaccounts,
      'currency' => $currency, 'currencylist' => $list
    ]);
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
  public function showuserOrder($pair)
  {

    $pair_details = TradeCurrencyPair::where([['id', $pair], ['status', 'active']])->first();
    return $this->getusertrade($pair_details,Auth::id());
  }
  public function show($pair)
  {
        //$curr=explode('-',$id);
       // dd($curr);
        //return $this->gettrade($curr[0],$curr[1]);
    $pair_details = TradeCurrencyPair::where([['id', $pair], ['status', 'active']])->first();
    return $this->gettrade($pair_details,Auth::id());
  }
  public function showHistory($id)
  {

    $pid = Currencies::where('id', $id)->get();
    if ($pid[0]->type == 'token') {
      $coin_details = CoinTransactions::with('payment')->where([['token', $pid[0]->token], ['user_id', Auth::id()]])->take(5)->get();

    } else {
      $pg = Paymentgateway::where('currency_id', $pid[0]->id)->orderBy('id', 'DESC')->get();
      $coin_details = CoinTransactions::with('payment')->where([['paymentgateway_id', $pg[0]->id], ['user_id', Auth::id()]])->take(5)->get();
    }



    $address = '';
    $txnval = '';
    $coin_tran = [];


    if (count($coin_details) > 0) {
      foreach ($coin_details as $cointran) {
            //dd($cointran->payment->currency->name);
        $currencyname = $cointran->payment->currency->name;
        $currencyid = $cointran->payment->currency->id;

        if ($currencyname == 'BTC') {

          $userpay = Userpayaccounts::where('currency_id', $currencyid)->where('user_id', Auth::id())->first();
          if ($userpay != null) {
            $address = $userpay->btc_address;
          }

          $mode_btc = env('BTC_MODE');

          $url = $this->getBTCCoinTxn($mode_btc, $cointran->txid);

          $decimal = '%0.' . $cointran->payment->currency->decimal . 'f';
          $tran_amount = sprintf($decimal, $cointran->amount);

        } else if ($currencyname == 'LTC') {

          $userpay = Userpayaccounts::where('currency_id', $currencyid)->where('user_id', Auth::id())->first();

          if ($userpay != null) {
            $address = $userpay->ltc_address;

          }
          $mode_ltc = env('LTC_MODE');
          $url = $this->getLTCCoinTxn($mode_ltc, $cointran->txid);
          $decimal = '%0.' . $cointran->payment->currency->decimal . 'f';
          $tran_amount = sprintf($decimal, $cointran->amount);

        } else if ($currencyname == 'ETH') {
          $userpay = Userpayaccounts::where('currency_id', $currencyid)->where('user_id', Auth::id())->first();
          if ($userpay != null) {
            $address = $userpay->eth_address;

          }

          $mode_eth = env('ETH_MODE');
          $url = $this->getETHTxnUrl($mode_eth, $cointran->txid);
          $decimal = '%0.' . $cointran->payment->currency->decimal . 'f';
          $tran_amount = sprintf($decimal, $cointran->amount);

        } else if ($currencyname == 'BCH') {
          $userpay = Userpayaccounts::where('currency_id', $currencyid)->where('user_id', Auth::id())->first();
          if ($userpay != null) {
            $bchaddress = $userpay->bch_address;
          }

          $address = str_replace("bchtest:", "", $bchaddress);

          $mode_bch = env('BCH_MODE');
          $url = $this->getBCHUrl($cointran->txid);
          $decimal = '%0.' . $cointran->payment->currency->decimal . 'f';
          $tran_amount = sprintf($decimal, $cointran->amount);

        } else if ($currencyname == 'XRP') {
          $userpay = Userpayaccounts::where('currency_id', $currencyid)->where('user_id', Auth::id())->first();
          if ($userpay != null) {
            $address = $userpay->xrp_address;
          }

          $mode_btc = 'test';

          $url ="javascript:void(0);";

          $decimal = '%02f';
          $tran_amount = $cointran->amount * 0.0001 /100;
        } else if ($currencyname == 'QTUM') {
          $userpay = Userpayaccounts::where('currency_id', $currencyid)->where('user_id', Auth::id())->first();
          if ($userpay != null) {
            $address = $userpay->btc_address;
          }

          $mode_btc = env('QTUM_MODE');

          $url = $this->getQTUMCoinTxn($mode_btc, $cointran->txid);

          $decimal = '%0.' . $cointran->payment->currency->decimal . 'f';
          $tran_amount = sprintf($decimal, $cointran->amount);

        }
        
         //dd($address);

        if ($address == $cointran->from_address) {
          $txnval = "minus";
        } else if ($address == $cointran->to_address) {
          $txnval = "plus";
        }

        if ($pid[0]->type == 'token') {
          $curname = $pid[0]->token;
        } else {
          $curname = $cointran->payment->currency->name;
        }
        $coin_tran[] = array('curname' => $curname, 'amount' => $tran_amount, 'from_address' => $cointran->from_address, 'to_address' => $cointran->to_address, 'txid' => $cointran->txid, 'txurl' => $url, 'txtype' => $txnval, 'address' => $address);

      }

    } else {
      $coin_tran = $coin_details;
    }
    return json_encode($coin_tran);


  }

  public function showAllHistory($id)
  {

    $coin_details = CoinTransactions::with('payment')->where([['paymentgateway_id', $id], ['user_id', Auth::id()]])->paginate(\Config::get('settings.pagecount'));

      //dd($coin_details);
    $address = '';
    $txnval = '';
    $coin_tran = [];
    $coins = new Collection;

    if (count($coin_details) > 0) {
      foreach ($coin_details as $cointran) {
            //dd($cointran->payment->currency->name);
        $currencyname = $cointran->payment->currency->name;
        $currencyid = $cointran->payment->currency->id;

        if ($currencyname == 'BTC') {

          $userpay = Userpayaccounts::where('currency_id', $currencyid)->where('user_id', Auth::id())->first();
          if ($userpay != null) {
            $address = $userpay->btc_address;
          }

          $mode_btc = env('BTC_MODE');

          $url = $this->getBTCCoinTxn($mode_btc, $cointran->txid);

          $decimal = '%0.' . $cointran->payment->currency->decimal . 'f';
          $tran_amount = sprintf($decimal, $cointran->amount);

        } else if ($currencyname == 'LTC') {

          $userpay = Userpayaccounts::where('currency_id', $currencyid)->where('user_id', Auth::id())->first();

          if ($userpay != null) {
            $address = $userpay->ltc_address;

          }
          $mode_ltc = env('LTC_MODE');
          $url = $this->getLTCCoinTxn($mode_ltc, $cointran->txid);
          $decimal = '%0.' . $cointran->payment->currency->decimal . 'f';
          $tran_amount = sprintf($decimal, $cointran->amount);

        } else if ($currencyname == 'ETH') {
          $userpay = Userpayaccounts::where('currency_id', $currencyid)->where('user_id', Auth::id())->first();
          if ($userpay != null) {
            $address = $userpay->eth_address;

          }

          $mode_eth = env('ETH_MODE');
          $url = $this->getETHTxnUrl($mode_eth, $cointran->txid);
          $decimal = '%0.' . $cointran->payment->currency->decimal . 'f';
          $tran_amount = sprintf($decimal, $cointran->amount);

        } else if ($currencyname == 'BCH') {
          $userpay = Userpayaccounts::where('currency_id', $currencyid)->where('user_id', Auth::id())->first();
          if ($userpay != null) {
            $bchaddress = $userpay->bch_address;
          }

          $address = str_replace("bchtest:", "", $bchaddress);

          $mode_bch = env('BCH_MODE');
          $url = $this->getBCHUrl($cointran->txid);
          $decimal = '%0.' . $cointran->payment->currency->decimal . 'f';
          $tran_amount = sprintf($decimal, $cointran->amount);

        } else if ($currencyname == 'XRP') {

        } else if ($currencyname == 'QTUM') {
          $userpay = Userpayaccounts::where('currency_id', $currencyid)->where('user_id', Auth::id())->first();
          if ($userpay != null) {
            $address = $userpay->btc_address;
          }

          $mode_btc = env('QTUM_MODE');

          $url = $this->getQTUMCoinTxn($mode_btc, $cointran->txid);

          $decimal = '%0.' . $cointran->payment->currency->decimal . 'f';
          $tran_amount = sprintf($decimal, $cointran->amount);

        } else if ($cointran->payment->type == 'token') {

        }


        if ($address == $cointran->from_address) {
          $txnval = "minus";
        } else if ($address == $cointran->to_address) {
          $txnval = "plus";
        }

        $tranlists[] = array('curname' => $cointran->payment->currency->name, 'amount' => $tran_amount, 'from_address' => $cointran->from_address, 'to_address' => $cointran->to_address, 'txid' => $cointran->txid, 'txurl' => $url, 'txtype' => $txnval, 'address' => $address, 'time_stamp' => $cointran->time_stamp);

         //  $coins->push(array('curname'=>$cointran->payment->currency->name,'amount'=>$tran_amount,'from_address'=>$cointran->from_address,'to_address'=>$cointran->to_address,'txid'=>$cointran->txid,'txurl'=> $url,'txtype'=>$txnval,'address'=>$address,'time_stamp'=>$cointran->time_stamp);

      }
    } else {
      $tranlists = $coin_details;
    }  
         //dd(json_encode($tranlists));
    return view('transaction.show', [
      'tranlists' => $tranlists,
      'coin_details' => $coin_details,
    ]);

  }
  public function showDetails($pair)
  {
    $pair_details = TradeCurrencyPair::where([['id', $pair], ['status', 'active']])->first();
       //dd($pair_details);

    $sellbuyorders = '';

       // $sellbuyorders=TradeOrders::with('buyorder','sellorder')->where([['type','order'],['user_id','!=',TRADEPOT_ID],['from_coin_id',$pair_details->tocurrency->id],['to_coin_id',$pair_details->fromcurrency->id]])->orderBy('id','DESC')->take(10)->get();

    $sellbuyorders = TradeOrders::where([['user_id', '!=', TRADEPOT_ID], ['type', 'buy'], ['from_coin_id', $pair_details->fromcurrency->id], ['to_coin_id', $pair_details->tocurrency->id]])->whereIn('status', ['complete'])->orWhere([['type', 'sell'], ['from_coin_id', $pair_details->tocurrency->id], ['to_coin_id', $pair_details->fromcurrency->id]])->groupBy('amount')->orderBy('amount', 'DESC')->take(10)->get(['type', 'from_coin_id', 'to_coin_id', 'amount', 'quantity', 'total_amount', 'updated_at']);

         //dd($sellbuyorders);
    $sign = '';

    $orders = TradeOrders::with('buyorder', 'sellorder')->where([['type', 'order'], ['user_id', '!=', TRADEPOT_ID], ['from_coin_id', $pair_details->tocurrency->id], ['to_coin_id', $pair_details->fromcurrency->id]])->groupBy(\DB::raw("DATE_FORMAT(order_at, '%Y-%m-%d')"))->orderBy('order_at', 'DESC')->take(10)->get();
    if (count($orders) > 0) {
      for ($i = 0; $i < count($orders); $i++) {

        if (count($orders) > $i + 1) {

          if ($orders[$i]['amount'] > $orders[$i + 1]['amount']) {
            $sign = "plus";
          } else {
            $sign = "minus";
          }
          $diff_amount = $orders[$i]['amount'] - $orders[$i + 1]['amount'];
          $diff_per = ($diff_amount / $orders[$i]['amount'] * 100);
        } else {
           //dd("KK");
          $diff_amount = 0;
          $diff_per = 0;
        }
           // dd($s);
        $month = explode(' ', $orders[$i]['order_at']);
        $months = explode('-', $month[0]);
        $date = $months[1] . "." . $months[2];

        $glancedatas[] = array('amount' => $orders[$i]['amount'], 'quantity' => $orders[$i]['quantity'], 'updated_at' => $date, 'type' => $orders[$i]['type'], 'diff_per' => $diff_per, 'diff_amount' => $diff_amount, 'sign' => $sign);
      }
         // dd($glancedatas);
    } else {
      $glancedatas = '';
    }

    if (count($sellbuyorders) > 0) {
      foreach ($sellbuyorders as $order) {
        $month = explode(' ', $order->updated_at);

        $months = explode('-', $month[0]);
        $times = explode(':', $month[1]);
            
      //dd($times);
        $datetime = $months[1] . "." . $months[2] . " " . $times[0] . "-" . $times[1];

        $orderdatas[] = array('amount' => $order->amount, 'quantity' => $order->quantity, 'total_amount' => $order->total_amount, 'updated_at' => $datetime, 'type' => $order->type);
      }
        // dd($glancedatas);
    } else {
      $orderdatas = '';
    }
         //dd($glancedatas);
    $arrays['glanceorders'] = $glancedatas;
    $arrays['sellbuyorders'] = $orderdatas;
    $arrays['from_currency_token'] = $pair_details->fromcurrency->token;
    $arrays['to_currency_token'] = $pair_details->tocurrency->token;

    return $arrays;

  }

  public function showorder($status, $id)
  {

    if (in_array($status, array('holdcoin', 'transhistory', 'notconclude', 'deposit','cryptowithdraw','fiatwithdraw')) == false) {
      abort(404);
    }
    $lists = [];
  

      
   //Tab
    if($status=='holdcoin')
    {

         $lists = TradeOrders::where([['user_id', Auth::id()], ['status', '!=', 'cancel']])->orWhere([['type', '=', 'buy'], ['type', '=', 'sell']])->orderBy('id', 'DESC')->with('fromcurrency', 'tocurrency')->paginate(\Config::get('settings.pagecount'));
    }

   
   else if($status=='notconclude')
    {

         $lists = TradeOrders::where('user_id', Auth::id())->Where('status', 'pending')->Where('type', 'sell')->orderBy('id', 'DESC')->with('fromcurrency', 'tocurrency')->paginate(\Config::get('settings.pagecount'));
    }

   else if(($status=='deposit')&&($id=='pending'))
    {

       $lists = Deposit::where([['user_id',Auth::id()],['status','new']])->latest('updated_at')->paginate(\Config::get('settings.pagecount'));
    }
   else if ($status == "cryptowithdraw") {
     
         $lists = Transfer::Where('user_id',Auth::id())->orderBy('id','DESC')->with('currency','user')->paginate(\Config::get('settings.pagecount'));
    }
    else if ($status == "fiatwithdraw") {
         $lists = Withdraw::Where('user_id',Auth::id())->orderBy('id','DESC')->with('currency','user','userpayaccounts')->paginate(\Config::get('settings.pagecount'));         
         //dd($lists);
    }
         
  //Dropdown

   else if ($id == "all") {

      $lists = Transaction::where('user_id',Auth::id())->where([
        ['status', 'approve'],
      ])->WhereIn('action', ['deposit', 'withdraw','buytrade','selltrade'])->latest('updated_at')->paginate(\Config::get('settings.pagecount'));

    } 
    else if ($id == "buy") {
          $lists = Transaction::where('user_id', Auth::id())->where([
        ['status', 'approve'], ['action', '=', 'buytrade']
      ])->orderBy('amount','desc')->paginate(\Config::get('settings.pagecount'));
    } 
    else if ($id == "deposit") {
        $lists = Deposit::where('user_id',Auth::id())->latest('updated_at')->paginate(\Config::get('settings.pagecount'));
    }

    else if ($id == "sell") {
      $lists = Transaction::where('user_id', Auth::id())->where([
        ['status', 'approve'], ['action', '=', 'selltrade']
      ])->orderBy('amount','desc')->paginate(\Config::get('settings.pagecount'));
    } 
         
         //dd($lists);
 
    return view('trade.show', [
     
      'lists' => $lists,
      'status' => $status,
    ]);
  }

  public function showTrade($status, $pair)
  {
    $pair_details = TradeCurrencyPair::where([['id', $pair], ['status', 'active']])->first();
    if ($status == 'sell') {

            // $tradelists = TradeOrders::where('user_id', Auth::id())->Where('status','pending')->Where('type','sell')->orderBy('id','DESC')->with('fromcurrency','tocurrency')->paginate(\Config::get('settings.pagecount'));

      $tradelists = TradeOrders::where([['type', 'sell'], ['user_id', '!=', TRADEPOT_ID], ['from_coin_id', $pair_details->tocurrency->id], ['to_coin_id', $pair_details->fromcurrency->id]])->whereIn('status', ['pending'])->groupBy('amount')->orderBy('amount', 'ASC')->paginate(\Config::get('settings.pagecount'));

    }
    if ($status == 'buy') {
      $tradelists = TradeOrders::where([['type', 'buy'], ['user_id', '!=', TRADEPOT_ID], ['from_coin_id', $pair_details->fromcurrency->id], ['to_coin_id', $pair_details->tocurrency->id]])->whereIn('status', ['pending'])->groupBy('amount')->orderBy('amount', 'ASC')->paginate(\Config::get('settings.pagecount'));
    }

    if ($status == 'order') {
      $tradelists = TradeOrders::with('buyorder', 'sellorder')->where([['type', 'order'], ['user_id', '!=', TRADEPOT_ID], ['from_coin_id', $pair_details->tocurrency->id], ['to_coin_id', $pair_details->fromcurrency->id]])->orderBy('id', 'DESC')->paginate(\Config::get('settings.pagecount'));
    }

    return view('trade.showtrade', [
      'tradelists' => $tradelists,
      'status' => $status,
    ]);
  }
  public function cancelOrder($id)
  {


    $cancel_order = $this->cancelTradeOrder($id);

    \Session::put('successmessage', trans('myaccount.ordercancel'));

    return Redirect::to(url('myaccount/tradehistory/show/notconclude/all'));

  }

  public function cancelOrders($id)
  {
        $cancel_order = $this->cancelTradeOrder($id);
        $response['status']='ok';
        //$response['data']= $array;
        $response['message']=trans('myaccount.ordercancel');
        $response['code']='200';
        return $response;
  }

  public function getPayaccount($payid)
  {

    $payacc = Userpayaccounts::where([
      ['user_id', '=', Auth::id()],
      ['paymentgateways_id', '=', $payid],
      ['active', '=', '1'],
    ])->get();

    return $payacc;

  }

  public function getBuyExchange(Request $request)
  {
       // dd("HH");
        //$from_currency_id=$this->getCurrencyId('PrimaryCoin');
        //$paymentdetails = Paymentgateway::find($request->payment_thro);

    $pair_details = TradeCurrencyPair::where([['from_currency_id', $request->tocurid], ['to_currency_id', $request->fromcurid]])->first();

        //dd($pair_details);


    $s = $this->getexchange($request, $pair_details, 'buy');

    return $s;

  }

  public function getSellExchange(Request $request)
  {
    $from_currency_id = $this->getCurrencyId('PrimaryCoin');
    $paymentdetails = Paymentgateway::find($request->payment_thro);
    $pair_details = TradeCurrencyPair::where([['from_currency_id', $from_currency_id], ['to_currency_id', $paymentdetails->currency_id]])->first();

      /*  $pair_details = TradeCurrencyPair::where([['from_currency_id',\Session::get('sell_payment_to')],['to_currency_id',$from_currency_id]])->first();*/

    return $this->getexchange($request, $pair_details, 'sell');

  }
  public function getexchange($request, $pair_details, $type)
  {
    $user = User::where('id', Auth::id())->with('userprofile')->first();
    return $this->getTradeDetails($request, $pair_details, $type, $user);

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
}

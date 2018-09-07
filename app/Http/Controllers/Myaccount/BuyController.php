<?php
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
use App\Traits\LogActivity;
use App\Traits\UserInfo;
use App\Traits\Common;
use App\CurrencyPair;
use App\Models\Userpayaccounts;
use App\TradeCurrencyPair;
class BuyController extends Controller
{
  //use UserInfo;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware(['auth', 'member'])->except('exchangerates');
  }

  use LogActivity,UserInfo;

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function setcoin($currency)
  {     
      \Session::put('coin_currency_id', $currency);

      return Redirect::to('myaccount/buycoin');
  }

  public function create()
  {
      $coin_currency_id=\Session::get('coin_currency_id');    
  
      $currencyaccounts=$this->getAccountDetails(Auth::id(), $coin_currency_id);

      $currencydetails = Currency::where('id', $coin_currency_id)->first();

      $currency =  Currency::join('paymentgateways', 'currencies.id', '=', 'paymentgateways.currency_id')
          ->select('currencies.*', 'paymentgateways.*')
          ->where('paymentgateways.exchange', '=', 1)
          ->where('currencies.status', '=', 1)
          ->get();

      return view ('buycoin.coin_create', [
        'currencydetails' => $currencydetails,               
        'currencyaccounts' => $currencyaccounts,            
        'currency' => $currency,
      ]);
  }

 public function exchangerate(Request $request)
 {
    
    $fromcurrency = Currency::where('id',$request->fromcurrency)->first();
   
    $tocurrency = Currency::where('id', $request->tocurrency)->first();

    $gettocurrencyvalue = $this->getOrderRate($request->amount, $fromcurrency->name, $tocurrency->name, 'buy');

    \Session::put('order_amount', $gettocurrencyvalue);

      return $gettocurrencyvalue;
 }
 public function exchangerates(Request $request)
 {


    $currlist = TradeCurrencyPair::where('id',$request->currency)->first();

//dd($currlist->to_currency_id.$currlist->from_currency_id);
    $tocurrency = Currency::where('id',$currlist->from_currency_id)->first();


    $fromcurrency = Currency::where('id', $currlist->to_currency_id)->first();

     //dd($fromcurrency);

    //dd($fromcurrency->name.$tocurrency->name);

    $gettocurrencyvalue = $this->getOrderRate($request->amount, 
      $fromcurrency->name, $tocurrency->name, 'buy');

    //dd($gettocurrencyvalue);

    //$gettocurrencyvalue=0;

    \Session::put('order_amount', $gettocurrencyvalue);
    \Session::put('fromcurr', $fromcurrency->name);
    \Session::put('tocurr', $tocurrency->name);
    \Session::put('currencypair',$request->currency);

    

   

  $user = User::where('id', Auth::id())->with('userprofile')->first();


  $userbalance = $this->getUserCurrencyBalance($user,$fromcurrency->id);

  $userbalance = "0";

  $userbalance =sprintf("%.2f", $userbalance);
   //$userbalance=0;

     if($tocurrency->id=="1")
     {
    //BTC
        $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
        $balance=0;
        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
        if(count($user_accounts)>0)
        {
            if($user_accounts->btc_address!='')
              {
                   $balance=$this->getWalletBalance($user_accounts->btc_address);
              }else{
                  $balance=0;
              }
        }
        else{
                  $balance=0;
              }

     }
    if($tocurrency->id=="2")
     {
      //LTC
        $pg_ltc = $this->getPgDetailsByGatewayName('ltc_blockio');
        $balance_ltc=0;
        $user_accounts_ltc=Userpayaccounts::getAccountDetails(Auth::id(),$pg_ltc->id)->first();
        if(count($user_accounts_ltc)>0)
        {
            if($user_accounts_ltc->ltc_address!='')
              {
                   $balance=$this->getLTCWalletBalance($user_accounts_ltc->ltc_address);
              }
              else{
                  $balance=0;
              }
        }
        else{
          $balance=0;
        }
       }
       if($tocurrency->id=="8")
       {
        //DOGE
        $pg_doge = $this->getPgDetailsByGatewayName('dogecoin_blockio');
        $balance_doge=0;
        $user_accounts_doge=Userpayaccounts::getAccountDetails(Auth::id(),$pg_doge->id)->first();
        if(count($user_accounts_doge)>0)
        {
            if($user_accounts_doge->doge_address!='')
              {
                   $balance=$this->getDOGEWalletBalance($user_accounts_doge->doge_address);
              }
              else{
                  $balance=0;
              }
        } 
        else{
          $balance=0;
         }

       }




   $curr_detail=array("fromcurr"=>$fromcurrency->name,"tocurr"=>$tocurrency->name,'convertamt'=>$gettocurrencyvalue,'userbalance'=>$userbalance,"fromcurrid"=>$fromcurrency->id,"tocurrid"=>$tocurrency->id,'sellerbalance'=>$balance); 

      $c=json_encode($curr_detail);

      return $c;

  }

   public function getbuyexchange(Request $request)
    {
        //$id=\Session::get('exchange_pair_id');

        $pair_details = CurrencyPair::find($request->currency_pair);

        $exchangerate_per=$this->getexchangerate(1, $pair_details->tocurrency->name,$pair_details->fromcurrency->name ,'buy');

        $exchangerate_per=sprintf("%.8f", $exchangerate_per);

        $variant=$pair_details->exchange_rate_variant;

        $fee=$pair_details->fee;


        $base_fee=$pair_details->base_fee;

        $amount=$request->amount;

        $variant_total=$exchangerate_per*($variant/100);

        $total_amount=$exchangerate_per+$variant_total;
         $volume=$request->volume;

      $amt=$volume*$amount;

        $exchangerate=$total_amount*$amount;

        $exchangerate=sprintf("%.8f", $exchangerate);


        $fee_amount=$amt*($fee/100);

        $fee_total=$base_fee+$fee_amount;


        //$final_amount=$exchangerate-$base_fee-$fee_amount;

 $final_amount=$amt+$fee_total;

        $res=array();

        $res['final_amount']=$final_amount;

        $res['finaltot_amount']=$amt;

 \Session::put('buy_amount',$amt);
 \Session::put('buy_fee_amount',$fee_total);
 \Session::put('buy_total_amount',$final_amount);


        $res['fee_total']=$fee_total;

        $balance_btc_equi=$this->getexchangerate($final_amount,$request->fromcur,$request->tocur,'buy');

         $res['exchange_total']=$balance_btc_equi;

      //  echo $final_amount;
       \Session::put('external_exchange_amount',$amount);
       \Session::put('external_exchange_final_amount',$final_amount);
       \Session::put('external_exchange_details',$pair_details);
       \Session::put('external_exchange_fee_total',$fee_total);
       \Session::put('exchangerate_per',$exchangerate_per);
       \Session::put('exchangerate_variant',$total_amount);


        return $res;

    }

     public function getsellexchange(Request $request)
    {
        //$id=\Session::get('exchange_pair_id');

        $pair_details = CurrencyPair::find($request->currency_pair);

        $exchangerate_per=$this->getexchangerate(1, $pair_details->tocurrency->name,$pair_details->fromcurrency->name ,'buy');

        $exchangerate_per=sprintf("%.8f", $exchangerate_per);

        $variant=$pair_details->exchange_rate_variant;

        $fee=$pair_details->fee;


        $base_fee=$pair_details->base_fee;

        $amount=$request->amount;

        $variant_total=$exchangerate_per*($variant/100);

        $total_amount=$exchangerate_per+$variant_total;
         $volume=$request->volume;

      $amt=$volume*$amount;

        $exchangerate=$total_amount*$amount;

        $exchangerate=sprintf("%.8f", $exchangerate);


        $fee_amount=$amt*($fee/100);

        $fee_total=$base_fee+$fee_amount;


        //$final_amount=$exchangerate-$base_fee-$fee_amount;

 $final_amount=$amt+$fee_total;

        $res=array();

        $res['final_amount']=$final_amount;

        $res['finaltot_amount']=$amt;

 \Session::put('sell_amount',$amt);
 \Session::put('sell_fee_amount',$fee_total);
 \Session::put('sell_total_amount',$final_amount);


        $res['fee_total']=$fee_total;

        $balance_btc_equi=$this->getexchangerate($final_amount,$request->fromcur,$request->tocur,'buy');

         $res['exchange_total']=$balance_btc_equi;

      //  echo $final_amount;
       \Session::put('external_exchange_amount',$amount);
       \Session::put('external_exchange_final_amount',$final_amount);
       \Session::put('external_exchange_details',$pair_details);
       \Session::put('external_exchange_fee_total',$fee_total);
       \Session::put('exchangerate_per',$exchangerate_per);
       \Session::put('exchangerate_variant',$total_amount);


        return $res;

    }


 

  public function store(BuyCoinRequest $request)
  {
    $from_currency=$request->from_currency;

    $amount = $request->order_amount;

    $admin = User::find(1); 

    $user = User::where('id', Auth::id())->first();
      
    \Session::put('request_amount', $request->amount);

  //  \Session::put('order_amount', $request->order_amount);
    \Session::put('from_currency', $from_currency); 

    $transaction_id= $this->getTransactionID();

    \Session::put('transaction_id', $transaction_id);

     return Redirect::to( url('/myaccount/buycoin/confirm')); 
  }  

  public function confirm_create()
  {
    $amount = \Session::get('order_amount'); 

    $user = User::where('id', Auth::id())->first();  

    $currencyaccounts=$this->getAccountDetails(Auth::id(), \Session::get('from_currency'));

    $transaction_id=\Session::get('transaction_id');

    $currencydetails = Currency::where('id', \Session::get('coin_currency_id'))->first();

    return view('buycoin._confirm_form', [                       
      'amount' => $amount,                                            
      'transaction_id' => $transaction_id,
      'currencyaccounts' => $currencyaccounts, 
      'currencydetails' => $currencydetails, 
    ]);

  }

  public function confirm(Request $request)
  {

    $sessionarray=$this->sessionToRequest($request);

    $request->merge($sessionarray);

    $coinorder=$this->makeOrder(Auth::id(),1,'buy','pending',$request);

    $array = array();

    $array=[
      'amount'=>\Session::get('order_amount'),
      'comment'=>'Buy Coin',
    ];
      
    $request=(object)$array;

    $this->approveBuyCoin($request,$coinorder->id,'user');
  
    \Session::put('successmessage','Coin Bought Successfully');

    return Redirect::to(url('/myaccount/buycoin'));

  }

  public function show()
  {
    $transactions = Coinorder::where([['from_user_id',Auth::id()],['type','buy']])->with('tocurrency','fromcurrency')->orderBy('id','DESC')->paginate(10);

      return view('buycoin.show',[
        'transactions'=>$transactions,
      ]);
  } 
}

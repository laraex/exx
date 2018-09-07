<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Myaccount;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Currency;
use App\Traits\CoinProcess;
use App\Traits\CoinBuyProcess;
use App\User;
use App\Http\Requests\TradeSellRequest;
use App\Models\Country;
use App\Coinorder;
use App\Traits\LogActivity;
use App\Requestorder;
use App\Traits\UserInfo;
use App\Traits\TransactionProcess;
use App\Models\Userpayaccounts;
use App\Models\Accountingcode;
use App\Classes\block_io\BlockIo;
use Exception;
use App\TradeCurrencyPair;
  use App\Traits\TradeOrdersProcess;
  use App\Events\TradeEvent;

use App\Events\TradeAddEvent;
use App\Http\Controllers\CryptoPayment\CryptoPaymentBase;
class TradeSellController extends Controller
{
    public function __construct()
  {
      $this->middleware(['auth', 'member']);
  }

  use TradeOrdersProcess;



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checksell(TradeSellRequest $request)
    //public function checksell(Request $request)
    {
 
     //dd($request->currency_pair);
       $pair_details = TradeCurrencyPair::where([['id',$request->currency_pair],['status','active']])->first();

        
         $total=$request->sell_amount*$request->sell_volume;
         $fee_total=(($pair_details->sell_fee/100)*$total)+$pair_details->sell_base_fee;
         $total_amount=$total-$fee_total;

         $array=[
            "from_coin_id"=>$pair_details->from_currency_id,
            "to_coin_id"=>$pair_details->to_currency_id,
            "fee"=>$pair_details->sell_fee,
            "base_fee"=>$pair_details->sell_base_fee,
            "fee_total"=>$fee_total,
            "total_amount"=>$total_amount,
            "fromcur" => $request->fromcur,
            "tocur" => $request->tocur,
            "amount"=> $request->sell_amount,
            "buy_volume" => $request->sell_volume
            ];

        $response['status']='ok';
        $response['data']= $array;
        $response['message']=trans('forms.sell_success');
        $response['code']='200';
        return $response;

    }
    public function store(TradeSellRequest $request)
   //public function store(Request $request)
    {
 
     //dd($request->currency_pair);
       $pair_details = TradeCurrencyPair::where([['id',$request->currency_pair],['status','active']])->first();

        
         $total=$request->sell_amount*$request->sell_volume;
         $fee_total=(($pair_details->sell_fee/100)*$total)+$pair_details->sell_base_fee;
         $total_amount=$total-$fee_total;

        $array=[
            "from_coin_id"=>$pair_details->to_currency_id,
            "to_coin_id"=>$pair_details->from_currency_id,
            "fee"=>$pair_details->sell_fee,
            "base_fee"=>$pair_details->sell_base_fee,
            "fee_total"=>$fee_total,
            "total_amount"=>$total_amount,
            ];


        $request->merge($array);
        $request->merge(['amount'=>$request->sell_amount,'volume'=>$request->sell_volume]);
        $this->makeTradeOrder($request,Auth::id(),'sell','order');

         $currencypair=$pair_details->fromcurrency->name."-".$pair_details->tocurrency->name;
          //event 
         // event(new TradeEvent($currencypair));

         // event(new TradeAddEvent($currencypair));

        $response['status']='ok';
        $response['message']=trans('forms.sell_success');
        $response['code']='200';
        return $response;

       // dd($request);
     //    $amount= \Session::get('sell_amount');
      


     //   // if($req->save()){
     //    try
     //    {
     //       $req =new Requestorder;
     //   $req->user_id=Auth::id();
     //    $req->fromcurrency_id=$request->sfromcurid; 
     //   $req->tocurrency_id=$request->stocurid;
      
     //   $req->amount=$request->sell_amount;

     //   $req->buy_volume=$request->sell_volume;

     //   if($request->stocurid=="1"){
     //     $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
     //    $balance=0;
     //    $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
     //    if(count($user_accounts)>0)
     //    {
     //        if($user_accounts->btc_address!='')
     //          {
     //            $sendaddr=$user_accounts->btc_address;   
     //          }
     //    }

     //  }
     //  if($request->stocurid=="2"){
     //    //LTC
     //    $pg_ltc = $this->getPgDetailsByGatewayName('ltc_blockio');
     //    $balance_ltc=0;
     //    $user_accounts_ltc=Userpayaccounts::getAccountDetails(Auth::id(),$pg_ltc->id)->first();
     //    if(count($user_accounts_ltc)>0)
     //    {
     //        if($user_accounts_ltc->ltc_address!='')
     //          {
     //               $sendaddr=$user_accounts_ltc->ltc_address;
     //          }
     //    }
     // }
     // if($request->stocurid=="8"){
     //     //DOGE
     //    $pg_doge = $this->getPgDetailsByGatewayName('dogecoin_blockio');
     //    $balance_doge=0;
     //    $user_accounts_doge=Userpayaccounts::getAccountDetails(Auth::id(),$pg_doge->id)->first();
     //    if(count($user_accounts_doge)>0)
     //    {
     //        if($user_accounts_doge->doge_address!='')
     //          {
     //              $sendaddr=$user_accounts_doge->doge_address;
     //          }
     //    }
     //   }
     //  // dd($request->stocurid.$sendaddr);

     //   $params = json_decode($pg->params, true);
     //   $adminbtcaddress= $params['btc_address']; 
     //   $response_json = array('user_id'=>Auth::id(),
     //    'from_address'=>$sendaddr,                                
     //    'to_address'=>$adminbtcaddress,                                
     //    'amount'=>$amount,                                
     //    'order_id'=>$req->id,                                
     //    );

     //   $req->send_address=$sendaddr;
     //   $req->transaction_id="1234";
     //   $req->total_amount=$amount;
     //   $req->fee=\Session::get('sell_fee_amount'); 
     //   $req->net_amount=\Session::get('sell_total_amount');
     //   $req->request_type='sell';
     //   $req->request_status='Completed';
     //   $req->request_date=date('Y-m-d H:i:s');
     //   $req->request=json_encode($response_json);
     //   $req->save();
     //   $pgs = $this->getPgDetailsByGatewayName('bitcoin_blockio');
     //    // $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
     //    // $btc_address=$user_accounts->btc_address;
   
     //     $param = json_decode($pgs->params, true);
     //    $api_key= $param['api_key'];
     //    $pin= $param['pin']; 
     //    $version = $params['version']; // API version
     //    $block_io = new BlockIo( $api_key, $pin, $version);
     //    $response=$block_io->withdraw_from_addresses(array('amounts' => $amount, 'from_addresses' =>$sendaddr,'to_addresses' =>$adminbtcaddress));

     //   //dd($req->id);
     //        $reqs=Requestorder::where('id',$req->id)->first();
     //    $reqs->response=json_encode($response);
     //    $reqs->save();
     //    \Session::put('successmessage','Sell trade has been Successfully');

     //   }catch (Exception $e) 
     //    { 
     //      // if an exception happened in the try block above 
     //      \Session::put('failmessage',$e->getMessage());
     //    }

       //    $comment="Buy Trade Debit Wallet";
       //    //$comment="Buy Coin Debit Wallet";
       //    $type='debit';
       //    $acc_code=$request->tocur.'-buy-debit-wallet';
       //    //dd($acc_code);
       //    $accounting_ce = Accountingcode::where('accounting_code', $acc_code)->first();
       //     $accounting_code=$accounting_ce->id;
       // // $accounting_code=$this->getAccountingCode($accounting_code);
       // // $accounting_code=18;

         // $request_json = array('buy_amount' => \Session::get('buy_amount'), 'fee' => \Session::get('buy_fee_amount'),'transaction_number' =>'12134','net_amount'=>\Session::get('buy_total_amount'),'order_id'=>$req->id,'userid'=>Auth::id());

             
       //   $account_id=$this->getAccountID(Auth::id(),$request->fromcurid);

       //    $transaction=$this->makeTransaction($account_id,\Session::get('buy_total_amount'),"debit","1","buytrade",$accounting_code,$comment,$request_json,'',$req->id,get_class($req));
    
              return Redirect::to(url('/myaccount/trade'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

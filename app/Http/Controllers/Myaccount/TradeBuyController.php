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
use App\Http\Requests\TradeBuyRequest;
use App\Models\Country;
use App\Coinorder;
use App\Traits\LogActivity;
use App\Requestorder;
use App\Traits\Common;
use App\Traits\TransactionProcess;
use App\Models\Userpayaccounts;
use App\Models\Accountingcode;
use App\Events\TradeEvent;
use App\Traits\TradeOrdersProcess;
use App\Events\TradeAddEvent;
use App\TradeCurrencyPair;




class TradeBuyController extends Controller
{
    public function __construct()
  {
      $this->middleware(['auth', 'member']);
  }
 //use CoinBuyProcess,LogActivity,Common,TransactionProcess,
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkbuy(TradeBuyRequest $request)
    {
        $pair_details = TradeCurrencyPair::where([['id',$request->currency_pair],['status','active']])->first(); 


         $total=$request->buy_amount*$request->buy_volume;
         //$fee_total=($pair_details->fee/100)*$total;
         //$total_amount=$total+$fee_total;
         $fee_total=(($pair_details->buy_fee/100)*$request->buy_volume)-$pair_details->buy_base_fee;
         $total_amount=$total;
        $array=[
            "from_coin_id"=>$pair_details->from_currency_id,
            "to_coin_id"=>$pair_details->to_currency_id,
            "fee"=>$pair_details->fee,
            "fee_total"=>$fee_total,
            "total_amount"=>$total_amount,
            "fromcur" => $request->fromcur,
            "tocur" => $request->tocur,
            "amount"=> $request->buy_amount,
            "buy_volume" => $request->buy_volume
            ];
        $response['status']='ok';
        $response['data']= $array;
        $response['message']=trans('forms.buy_success');
        $response['code']='200';

        return $response;

    }
    public function store(TradeBuyRequest $request)
    {
      $pair_details = TradeCurrencyPair::where([['id',$request->currency_pair],['status','active']])->first(); 


         $total=$request->buy_amount*$request->buy_volume;
        // $fee_total=($pair_details->fee/100)*$total;
        // $total_amount=$total+$fee_total;
         $fee_total=(($pair_details->buy_fee/100)*$request->buy_volume)-$pair_details->buy_base_fee;
         $total_amount=$total;
         $array=[
            "from_coin_id"=>$pair_details->from_currency_id,
            "to_coin_id"=>$pair_details->to_currency_id,
            "fee"=>$pair_details->buy_fee,
            "base_fee"=>$pair_details->buy_base_fee,
            "fee_total"=>$fee_total,
            "total_amount"=>$total_amount,

            ];
        $request->merge($array);

        $request->merge(['amount'=>$request->buy_amount,'volume'=>$request->buy_volume]);
        $this->makeTradeOrder($request,Auth::id(),'buy','order');  

         $currencypair=$request->fromcur."-".$request->tocur;
          

        $response['status']='ok';
        $response['message']=trans('forms.buy_success');
        $response['code']='200';

        return $response;



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

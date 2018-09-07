<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\CurrencyPair;
use App\TradeCurrencyPair;
use Illuminate\Support\Facades\Redirect;
use App\Traits\CoinProcess;
use App\Http\Requests\CurrencyPairRequest;

class CurrencyPairController extends Controller
{
    use CoinProcess;
    public function __construct()
    {
        $this->middleware(['auth','admin1']);
    }

    public function index()
    {
       $list = TradeCurrencyPair::orderBy('id','ASC')->get();

        return view ('admin.currencypair.show', [
                'list' => $list
            ]);
    }

    public function edit($id)
    {
       $details = TradeCurrencyPair::where('id',$id)->first();
       $exchangerate=$this->getexchangerate(1, $details->tocurrency->name,$details->fromcurrency->name ,'buy');

       $exchangerate=sprintf("%.8f", $exchangerate);
    
        return view ('admin.currencypair.edit', [
                'details' => $details,
                'exchangerate' => $exchangerate
            ]);
    } 
    public function update(CurrencyPairRequest $request,$id)
    {

        $update=[                                                           
                'status'=>$request->status,
                'min_value'=>$request->min_amount,
                'max_value'=>$request->max_amount,
                //  'rate'=>$request->rate,
                //'exchange_rate_variant'=>$request->exchange_rate_variant,
                'buy_fee'=>$request->buy_fee,
                'buy_base_fee'=>$request->buy_base_fee,
                'sell_fee'=>$request->sell_fee,
                'sell_base_fee'=>$request->sell_base_fee,
               // 'reserve_amount'=>$request->reserve_amount,
                                                                  
              ];

      TradeCurrencyPair::where('id',$id)->update($update);
      \Session::put('successmessage','Saved Successfully');
      return Redirect::to('admin/currencypair');
       
    }

}

?>
<?php

namespace App\Http\Controllers\Myaccount;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Traits\CoinProcess;
use App\CurrencyPair;
use App\Traits\ExternalExchangeProcess;
use App\Http\Requests\ExternalExchangeRequest;
use App\ExternalExchange;
use App\Traits\Common;

class ExternalExchangeController extends Controller
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

    use CoinProcess,ExternalExchangeProcess;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function setpair($id)
    {
        \Session::put('exchange_pair_id',$id);
        return Redirect::to('myaccount/externalexchange/create');
    }

    public function create()
    {
        $list = CurrencyPair::where('status','active')->orderBy('from_currency_id','ASC')->get();
       
        if(!is_null(\Session::get('exchange_pair_id')))
        {
            $id=\Session::get('exchange_pair_id');
        }
        else
        {
            $id=0;
                if(count($list)>0)
                {
                     $id=$list[0]->id;
                    \Session::put('exchange_pair_id',$id);
                }
        }
            $pair_details=[];
            $total_amount=0;
            $transactions=[];
        if($id>0)
        {
            $pair_details = CurrencyPair::find($id);
            
            $total_amount=$this->getExternalExchange(1, $pair_details->tocurrency->name,$pair_details->fromcurrency->name ,'buy',$pair_details->exchange_rate_variant);

             $transactions = ExternalExchange::where([['user_id',Auth::id()],['from_currency_id',$pair_details->fromcurrency->id],['to_currency_id',$pair_details->tocurrency->id]])->latest()->take(10)->get();
        }

         return view('externalexchange.create',[
            'pair_details'=>$pair_details,
            'total_amount' => $total_amount,
            'list'=>$list,
            'transactions'=>$transactions,
        ]);    

    }

    public function store(ExternalExchangeRequest $request)
    {
         $transaction_id= $this->getExchangeTransactionID();

         \Session::put('transaction_id', $transaction_id);

         $pair_details = CurrencyPair::find(\Session::get('external_exchange_details')->id); 
           
         return view('externalexchange.exchange_confirm',[
           'transaction_id'=>$transaction_id,
           'pair_details'=>$pair_details,
        ]);
            //$this->createExchange($request,$user_id);

    }
    public function confirm(Request $request)
    {
            $sessionarray=$this->sessionToExchangeRequest();

            $request->merge($sessionarray);

            $this->createExchange($request,Auth::id());

            return Redirect::to(url('/myaccount/externalexchange/create'));

    }

    public function getexchange(Request $request)
    {
        $id=\Session::get('exchange_pair_id');

        $pair_details = CurrencyPair::find($id);

        $exchangerate_per=$this->getexchangerate(1, $pair_details->tocurrency->name,$pair_details->fromcurrency->name ,'buy');

        $exchangerate_per=sprintf("%.8f", $exchangerate_per);

        $variant=$pair_details->exchange_rate_variant;

        $fee=$pair_details->fee;

        $base_fee=$pair_details->base_fee;

        $amount=$request->amount;

        $variant_total=$exchangerate_per*($variant/100);

        $total_amount=$exchangerate_per+$variant_total;


        $exchangerate=$total_amount*$amount;

        $exchangerate=sprintf("%.8f", $exchangerate);

        $fee_amount=$exchangerate*($fee/100);

        $fee_total=$base_fee+$fee_amount;

        $final_amount=$exchangerate-$base_fee-$fee_amount;

        $res=array();

        $res['final_amount']=$final_amount;

        $res['fee_total']=$fee_total;

      //  echo $final_amount;
       \Session::put('external_exchange_amount',$amount);
       \Session::put('external_exchange_final_amount',$final_amount);
       \Session::put('external_exchange_details',$pair_details);
       \Session::put('external_exchange_fee_total',$fee_total);
       \Session::put('exchangerate_per',$exchangerate_per);
       \Session::put('exchangerate_variant',$total_amount);
        return $res;

    }
    public function show()
    {//dd('djf');
        $transactions = ExternalExchange::where('user_id',Auth::id())->orderBy('id','DESC')->paginate(10);
        return view('externalexchange.show',[
            'transactions'=>$transactions,
        ]);
    } 
    
    public function getWalletDetails()
    {
        return  $this->getWallet(Auth::id());
    }
}

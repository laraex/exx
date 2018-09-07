<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Usercurrencyaccount;
use App\Models\Currency;

class FundController extends Controller
{

    public function fundList($status, $currencyid)
    {

        $currency_accounting_code = Usercurrencyaccount::where([
                ['user_id', '=', Auth::guard('api')->id()],
                ['currency_id', '=', $currencyid]
            ])->first();
         // dd($accounting_code);

         $currencydetails = Currency::where('id', $currencyid)->first();
         //dd($currencydetails);

        $fundlists = Transaction::where([
                ['action', '=', 'deposit'],
                ['deposit_status', '=', $status],
                ['account_id', '=', $currency_accounting_code->id]
            ])->latest('updated_at')->paginate(\Config::get('settings.pagecount'));

       // dd(count($fundlists));

        if (count($fundlists) == 0)
        {
            $norecords = array('norecord' => 'No Records Found.');
            return [
            'data' => $norecords,
            ];
        }

        foreach ($fundlists as $key => $fundlist)
        {
            $request = json_decode($fundlist['request'], true); 
            $funds[$key]['amount'] = $fundlist->amount .' '. $currencydetails->name;
            $funds[$key]['payment'] = $fundlist->present()->getTransactionPaymentName($request['payment_id']);
            $funds[$key]['created_at'] = $fundlist->created_at->format('d/m/Y H:i:s');            
        }

        return [
            'data' => $funds,
       ];
    }   
   
}

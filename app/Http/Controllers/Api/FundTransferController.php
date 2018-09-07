<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Fundtransfer;
use App\Models\Usercurrencyaccount;
use Illuminate\Support\Facades\Redirect;
use Config;
use App\Models\Currency;

class FundTransferController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type, $currencyid)
    {
        $fundtransfer = Fundtransfer::latest('updated_at')->with('fundtransfer_to_id', 'fundtransfer_from_id');

        $currency_id = Currency::get()->pluck('id')->toarray();

          // dd($currency_id);

        $account_id = Usercurrencyaccount::where('user_id', '=', Auth::guard('api')->id())->whereIn('currency_id', $currency_id)->get()->pluck('id')->toArray();
        // dd($account_id);

        if ($type == 'send')
        {
            $transferlists = $fundtransfer->whereIn('from_account_id', $account_id)->paginate(Config::get('settings.pagecount'));
        }
        elseif ($type == 'received')
        {
            $transferlists = $fundtransfer->whereIn('to_account_id', $account_id)->paginate(Config::get('settings.pagecount'));
        }
        else
        {
            $status = array('status' => 'Wrong transaction type');
                return [
                'data' => $status,
                ];
        }

        $currency_accounting_code = Usercurrencyaccount::where([
                ['user_id', '=', Auth::guard('api')->id()],
                ['currency_id', '=', $currencyid]
            ])->first();

         $currencydetails = Currency::where('id', $currencyid)->first();  

        // dd(count($transferlists));
         if (count($transferlists) == 0)
         {
            //dd(count($transferlists));
            $status = array('status' => 'No transaction found.');
                return [
                'data' => $status,
                ];
         } 

         $funds['transferType'] = $type;
        foreach($transferlists as $key => $data)
        {
            if ($type == 'send')
            {
                $funds[$key]['receiver'] = $data->present()->getUsername($data->fundtransfer_to_id->user_id);
            }
            elseif ($type == 'received')
            {
                $funds[$key]['sender'] = $data->present()->getUsername($data->fundtransfer_from_id->user_id);
            }
            $funds[$key]['amount'] = $data->amount;
            $funds[$key]['created_at'] = $data->created_at->format('d/m/Y H:i:s');
        }

         return [
            'data' => $funds,
            ];   
    }
   
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Transaction;
use App\Models\Currency;
use App\Models\Usercurrencyaccount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class EarningsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['auth','admin1']);
    }

    public function index(Request $request)
    {
        $from_date = date('Y-m-d H:i:s',strtotime($request->from_date));
        $to_date = date('Y-m-d H:i:s',strtotime($request->to_date));

        $currency = Currency::pluck('id')->toarray();

        $allAccount = Usercurrencyaccount::whereIn('currency_id', $currency)->where('user_id', '1')->pluck('id')->toarray();

        $getcommissions = Transaction::whereIn('account_id' ,$allAccount)->where('type', 'credit')->with('accountingcode')->orderBy('id','ASC'); 
         

         $walletlists = Usercurrencyaccount::join('currencies', 'usercurrencyaccounts.currency_id', '=', 'currencies.id')
            ->select('usercurrencyaccounts.*', 'currencies.*')
            ->where('usercurrencyaccounts.user_id', Auth::id())
            ->orderBy('currencies.order', 'ASC')
            ->get(); 

        if ($from_date != "" && $to_date != "" && isset($request->from_date)) 
        {
            Validator::extend('checkdate', function ($attribute, $value, $parameters, $validator) 
            {   
            //dd('skjhgkg');
                $from_date = date('Y-m-d H:i:s',strtotime(Input::get('from_date')));
                $to_date = date('Y-m-d H:i:s',strtotime(Input::get('to_date')));

                if($from_date <= $to_date)
                {
                    return TRUE;
                }
                    return FALSE;

            }, trans('forms.invalid_date'));

            $validator = Validator::make($request->all(),[
                'from_date' => 'required|checkdate',
                'to_date' => 'required',
                ]);

            if($validator->fails())
            {
                return back()->withInput()->withErrors($validator);
            }
            
            $getcommissions = $getcommissions->whereBetween('created_at',[$from_date,$to_date])->paginate(20); 
        }  
        else
        {
            $getcommissions = $getcommissions->paginate(20);
        }  
         return view('admin.showearnings',[
                'earnings' => $getcommissions,
                'walletlists' => $walletlists,
            ]);
    }
}

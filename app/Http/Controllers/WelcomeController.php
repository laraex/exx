<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cookie;
use App\Models\Transaction;
use App\User;
use App\Traits\Common;
use App\Slider;
use App\CurrencyPair;
use App\Models\Sociallink;
use App\Models\News;
use App\TradeCurrencyPair;
use App\Http\Resources\CurrencyPairCollection;
use Config;

class WelcomeController extends Controller
{
    use Common;

    public function indexRedirect(){
        return Redirect::to('/trade/BTC-USD');
    }


    public function index($cpair)
    {
        $fromcurrency = CurrencyPair::where('status','active')->groupBy('from_currency_id')->get();
        //dd($fromcurrency);
        $tocurrency = CurrencyPair::where('status','active')->groupBy('to_currency_id')->get();
        //dd($currency);
        $tradepair = TradeCurrencyPair::where('status', 'active')->get()->keyby('id');
       
        $trade = new CurrencyPairCollection($tradepair);
        foreach( $trade as $key=>$value){
            if($value->currencypair==$cpair){
                $pairid =  $value->id;
                $fromtoken= $value->fromcurrency->token;
                $totoken = $value->tocurrency->token;
            }
        }
        if(\Config::get('settings.maintenance_status')==1)
        {
          return view('maintenance');
        }

       // $slider = Slider::where('active', 1)->get();
        
        $this->setSponsorCookie();
        
        return view('trade', [
            'pairid' => $pairid,
            'fromtoken' => $fromtoken,
            'totoken' => $totoken
        ]);
        // JavaScript::put([
        //     'pairid' => $pairid,
        //     'fromtoken' => $fromtoken,
        //     'totoken' => $totoken
        // ]);

        // //dd($news);
        // return view('trade');
    }

    /**
     * Undocumented function
     *
     * @return void
     * FIXME:
     */
    public function refreshcontent()
    {

        $user = User::where('id', 1)->with('useraccount')->first();

        $allUserAccount = $user->useraccount->whereIn('currency_id', [1,2,3,4,5])->pluck('id')->toarray();
        // dd($allUserAccount);
        $transactions = Transaction::where([
                        // ['action', '!=', 'NULL'],
                         ['type', '=', 'credit']
                        ])->orWhere([
                        ['action', '=', 'withdraw'],
                         ['type', '=', 'debit']
                        ])
                        ->orderBy('id', 'desc')->take(10)->get();
          //dd($transactions);
        return view('welcome.livefeed', [
                'transactions' => $transactions
            ]);
    }

    /**
     * Save Referral in cookie
     *
     * @param [type] $request
     * @return void
     */
    public function refferal($request)
    {
     
         $check = User::where('name', $request)->exists();

        if ($check) {
            Cookie::queue('sponsor', $request, 48000);

        }
        else
        {

            $this->setSponsorCookie();
            \Session::put('failmessage','Invalid Sponsor.');
        }

        return Redirect::to('/');
    }
}

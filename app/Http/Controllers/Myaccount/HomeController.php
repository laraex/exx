<?php

namespace App\Http\Controllers\Myaccount;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Usercurrencyaccount;
use App\User;
use session;
use App\Traits\Common;
use App\Models\Userpayaccounts;
use App\Language;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    use Common;

    public function __construct()
    {
        $languages = Language::where('active', 1)->get();    
        \Session::put('languageslist', $languages);  
        $this->middleware(['auth', 'member']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

   // dd("HH");
        $walletlists = Usercurrencyaccount::join('currencies', 'usercurrencyaccounts.currency_id', '=', 'currencies.id')
            ->select('usercurrencyaccounts.*', 'currencies.*')
            ->where('usercurrencyaccounts.user_id', Auth::id())
            ->where('currencies.status', 1)            
            ->orderBy('currencies.order', 'ASC')
            ->get(); 

            //dd($walletlists);

        $user = User::where('id', Auth::id())->with('userprofile')->first();
        
        if ($user->userprofile->active == 0)
        {
            //dd('dfgdfg');
            Auth::logout();
            \Session::flash('error', trans('myaccount.account_suspended_message'));
            return Redirect::back();
        }

         // dd($walletlists);
         $sponsor=array();
         $user = User::where('id', Auth::id())->with('userprofile')->first();
         if($user->sponsor_id!='NULL')
         {

                  $sponsor=User::where('id',$user->sponsor_id)->with('userprofile')->first();
         }
     
        \Session::put('profile_avatar', $user->userprofile->profile_avatar);
        
        //BTC
        $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
        $balance=0;
        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
        if(count($user_accounts)>0)
        {
            if($user_accounts->btc_address!='')
              {
                   $balance=$this->getWalletBalance($user_accounts->btc_address);
              }
        }
     
        //LTC
        $pg_ltc = $this->getPgDetailsByGatewayName('ltc_blockio');
        $balance_ltc=0;
        $user_accounts_ltc=Userpayaccounts::getAccountDetails(Auth::id(),$pg_ltc->id)->first();
        if(count($user_accounts_ltc)>0)
        {
            if($user_accounts_ltc->ltc_address!='')
              {
                   $balance_ltc=$this->getLTCWalletBalance($user_accounts_ltc->ltc_address);
              }
        }

        // //DOGE
        // $pg_doge = $this->getPgDetailsByGatewayName('dogecoin_blockio');
        // $balance_doge=0;
        // $user_accounts_doge=Userpayaccounts::getAccountDetails(Auth::id(),$pg_doge->id)->first();
        // if(count($user_accounts_doge)>0)
        // {
        //     if($user_accounts_doge->doge_address!='')
        //       {
        //            $balance_doge=$this->getDOGEWalletBalance($user_accounts_doge->doge_address);
        //       }
        // }
        $btc = $this->getCurrencyDetailsByName('BTC');
        $ltc = $this->getCurrencyDetailsByName('LTC');
       // $doge = $this->getCurrencyDetailsByName('DOGE');

        return view('home',[
                'walletlists' => $walletlists,
                'sponsor'=>$sponsor,
                'user_accounts'=>$user_accounts,
                'balance'=>$balance,
                'user_accounts_ltc'=>$user_accounts_ltc,
                'balance_ltc'=>$balance_ltc,
                //'user_accounts_doge'=>$user_accounts_doge,
                //'balance_doge'=>$balance_doge,
                'btc'=>$btc,
                'ltc'=>$ltc,
                //'doge'=>$doge,
            ]);
    }
    
    // public function getwalletaddress(Request $request)
    // {
    //     if($request->wallet=='btc')
    //     {

    //     $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
    //     $balance=0;
    //     $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
    //     if(count($user_accounts)>0)
    //     {
    //         return $user_accounts->btc_address;
              
    //     }
    //        return '';
    //     }
    //   if($request->wallet=='ltc')
    //     {
    //     //LTC
    //     $pg_ltc = $this->getPgDetailsByGatewayName('ltc_blockio');
    //     $balance_ltc=0;
    //     $user_accounts_ltc=Userpayaccounts::getAccountDetails(Auth::id(),$pg_ltc->id)->first();
    //     if(count($user_accounts_ltc)>0)
    //     {
    //         return $user_accounts_ltc->ltc_address;
             
    //     }
    //      return '';
    //   }

    //   if($request->wallet=='doge')
    //     {
    //     //DOGE
    //     $pg_doge = $this->getPgDetailsByGatewayName('dogecoin_blockio');
    //     $balance_doge=0;
    //     $user_accounts_doge=Userpayaccounts::getAccountDetails(Auth::id(),$pg_doge->id)->first();
    //     if(count($user_accounts_doge)>0)
    //     {
    //         return $user_accounts_doge->doge_address;
             
    //     }
    //      return '';
    //   }

    // }
    
}

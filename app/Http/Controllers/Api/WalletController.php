<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Usercurrencyaccount;
use App\Models\Currency;
use App\Helpers\SiteHelper;
use App\Http\Requests\ExchangeRequest;
use App\Traits\ExchangeProcess;
use App\Traits\CoinProcess;
use App\Models\Userpayaccounts;
use App\Models\Exchange;

class WalletController extends Controller
{
    use ExchangeProcess,CoinProcess;
    public function index()
    {
        $sitecurrency=\Config::get('settings.currency');   

        $currencies = Currency::where([           
            ['is_coin', '=', 0],

            ])->pluck('id')->toArray();
     

        $walletlists = Usercurrencyaccount::where([
            ['user_id' , Auth::guard('api')->id()],           
            ])->whereIn('currency_id',$currencies)->with('currency')->get();

        $walletCount = $walletlists->count();

        $currency = Currency::where('status', 1)->count();
         // dd($walletlists);


        $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
        $balance=0;
        $user_accounts=Userpayaccounts::getAccountDetails(Auth::guard('api')->id(), $pg->id)->first();
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
        $user_accounts_ltc=Userpayaccounts::getAccountDetails(Auth::guard('api')->id(), $pg_ltc->id)->first();
        if(count($user_accounts_ltc)>0)
        {
            if($user_accounts_ltc->ltc_address!='')
              {
                   $balance_ltc=$this->getLTCWalletBalance($user_accounts_ltc->ltc_address);
              }
        }

         //DOGE
        $pg_doge = $this->getPgDetailsByGatewayName('dogecoin_blockio');
        $balance_doge=0;
        $user_accounts_doge=Userpayaccounts::getAccountDetails(Auth::guard('api')->id(), $pg_doge->id)->first();
        if(count($user_accounts_doge)>0)
        {
            if($user_accounts_doge->doge_address!='')
              {
                   $balance_doge=$this->getDOGEWalletBalance($user_accounts_doge->doge_address);
              }
        }
        $btc = $this->getCurrencyDetailsByName('BTC');
        $ltc = $this->getCurrencyDetailsByName('LTC');
        $doge = $this->getCurrencyDetailsByName('DOGE');

        $balance_btc_equi=$this->getexchangerate($balance,$sitecurrency,$btc->name,'buy');
        $balance_ltc_equi=$this->getexchangerate($balance_ltc,$sitecurrency,$ltc->name,'buy');
        $balance_doge_equi=$this->getexchangerate($balance_doge,$sitecurrency,$doge->name,'buy');

        $balance_btc_equi= number_format((float)$balance_btc_equi,$btc->decimal);
        $balance_ltc_equi= number_format((float)$balance_ltc_equi,$ltc->decimal);
        $balance_doge_equi= number_format((float)$balance_doge_equi,$doge->decimal);

        foreach ($walletlists as $key => $walletlist)
         {
            $wallets[$key]['walletPaymentgatewayId'] = $walletlist->present()->getPaymentgatewayid($walletlist->currency->id);
            $wallets[$key]['walletCurrencyId'] = $walletlist->currency->id;
            $wallets[$key]['walletName'] = $walletlist->currency->name. ' Wallet';
            $wallets[$key]['walletLogo'] = url($walletlist->currency->image);
            $wallets[$key]['accountNo'] = $walletlist->account_no;
            $wallets[$key]['availableBalance'] = $walletlist->currency->name. ' '.$walletlist->present()->getBalance($walletlist->currency->id, $walletlist->user_id);     
            $wallets[$key]['pendingBalance'] = $walletlist->present()->getPendingBalance($walletlist->currency->id, $walletlist->user_id);

            $last_txn=$walletlist->present()->getLastTransaction($walletlist->id);
            $wallets[$key]['lastAction'] = '';
            if(count($last_txn)>0)
            {
                $wallets[$key]['lastAction'] = ucfirst($last_txn->action) . ' '.$last_txn->amount . ' '. $walletlist->currency->name . ' on '.$last_txn->created_at->format('d-m-Y H:i:s');
            }            
         }
         //BTC
         $crypto['btc']['imagePath'] = url($btc->image);
         $crypto['btc']['Name'] = $btc->displayname;
         $crypto['btc']['address'] = optional($user_accounts)->btc_address;
         $crypto['btc']['balance'] = $balance .' '. $btc->token .' ≈ ' .$balance_btc_equi. ' '.\Config::get('settings.currency');

        //LTC
        $crypto['ltc']['imagePath'] = url($ltc->image);
        $crypto['ltc']['name'] = $ltc->displayname;
        $crypto['ltc']['address'] = optional($user_accounts_ltc)->ltc_address;
         $crypto['ltc']['balance'] = $balance_ltc .' '. $ltc->token .' ≈ ' .$balance_ltc_equi. ' '.\Config::get('settings.currency');

         //Doge
        $crypto['doge']['imagePath'] = url($doge->image);
        $crypto['doge']['name'] = $doge->displayname;
        $crypto['doge']['address'] = optional($user_accounts_doge)->doge_address;
         $crypto['doge']['balance'] = $balance_doge .' '. $doge->token .' ≈ ' .$balance_doge_equi. ' '.\Config::get('settings.currency');

        return [
            'data' => ['fiat' => $wallets, 'crypto' => $crypto]
       ];
       
    }   

}

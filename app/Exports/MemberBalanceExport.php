<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Faq;

use App\Models\Currency;
use App\Models\Userpayaccounts;
use App\Models\Usercurrencyaccount;
use App\Traits\UserInfo;
use Illuminate\Database\Eloquent\Collection;
use App\User;
class MemberBalanceExport implements FromView
{
	use UserInfo;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
    // public function view(): View
    // {
    //     return view('admin.exports.invoice', [
    //         'faqs' => Faq::all()
    //     ]);
    // }

    public function view(): View
    {

        $id=\Session::get('userxls');

        $currency = Currency::orderBy('order', 'ASC')->get();
        $totalequ = 0;
        $i = 0;
        $balance = 0;
        $equ = 0;
        $address ="";

         $wallets =new Collection;
        // $id=8;

       
      if(count($currency) > 0)
        {
        foreach ($currency as $val) {
            $balance = 0;
            $equ = 0;
            $address ="";  
            $i++;
            try {
                $user = User::where('id', $id)->with('userprofile')->first();
                if ($val->name == "KRW") {
                  $userpay = Usercurrencyaccount::where('currency_id', $val->id)->where('user_id', $id)->first();
                   $address = $userpay->account_no;
                    $balance = $this->getUserCurrencyBalance($user, $val->id);

                    $equ = $balance;

                    $totalequ += $balance;

                } else if ($val->name == "USD") {

                  $userpay = Usercurrencyaccount::where('currency_id', $val->id)->where('user_id', $id)->first();

                    $address = $userpay->account_no;
                    $balance = $this->getUserCurrencyBalance($user, $val->id);

                    $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                    (double) $totalequ += $equ;
                } else if ($val->name == 'BTC') {
                    //BTC
                    $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');

                   // dd($pg);

                    $user_accounts = Userpayaccounts::getAccountDetails($id, $pg->id)->first();
                    if (count($user_accounts) > 0) {

                         $address = $user_accounts->btc_address;
                        if ($user_accounts->btc_address != '') {
                            $balance = $this->getWalletBalance($user_accounts->btc_address);

                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');

                            (double) $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'LTC') {
                    $pg = $this->getPgDetailsByGatewayName('ltc_blockio');

                    $user_accounts = Userpayaccounts::getAccountDetails($id, $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->ltc_address;
                        if ($user_accounts->ltc_address != '') {
                            $balance = $this->getLTCWalletBalance($user_accounts->ltc_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'ETH') {
                    $pg = $this->getPgDetailsByGatewayName('eth');

                    $user_accounts = Userpayaccounts::getAccountDetails($id, $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->eth_address;
                        if ($user_accounts->eth_address != '') {
                            $balance = $this->getETHWalletBalance($user_accounts->eth_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'BCH') {
                    $pg = $this->getPgDetailsByGatewayName('bch');

                    $user_accounts = Userpayaccounts::getAccountDetails($id, $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->bch_address;
                        if ($user_accounts->bch_address != '') {
                            $balance = $this->getBCHWalletBalance($user_accounts->bch_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                            (double) $totalequ += $equ;

                        }
                    }
                }

            } catch (Exception $e) {

                // dd($e->getMessage());
            }

            if($val->name=='KRW'){
            $wallets->push([
                "username"=>$user->name,
                "user_id"=>$user->id,
                "curname" => $val->name,
                "curname_webtype" => strtolower($val->name),
                "id" => $val->id,
                "displayname" => $val->displayname,
                "currimage" => $val->image,
                "type" => $val->type,
                "count_array" => $i,
                "curbalance" => $totalequ,
                "balance" => $balance,
                "equ" => $equ,
                "address"=>$address   
               ]);
              }else{
                  $wallets->push([
                "username"=>'',
                "user_id"=>$user->id,
                "curname" => $val->name,
                "curname_webtype" => strtolower($val->name),
                "id" => $val->id,
                "displayname" => $val->displayname,
                "currimage" => $val->image,
                "type" => $val->type,
                "count_array" => $i,
                "curbalance" => $totalequ,
                "balance" => $balance,
                "equ" => $equ,
                "address"=>$address   
               ]);
              }

            

        }
      }

        else{
            
        }

        return view('admin.exports.memberbalance', [
            'walletlists' =>$wallets
        ]);

            // dd($wallets);     
    }

}

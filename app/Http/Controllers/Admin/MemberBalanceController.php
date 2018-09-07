<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Currency;
use App\Models\Userpayaccounts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Usercurrencyaccount;
use App\Traits\UserInfo;
use Illuminate\Database\Eloquent\Collection;

class MemberBalanceController extends Controller
{
    use UserInfo;

    public function show()
    {
    	//$balance = new Collection;
    	  $balance = [];
    $user_balance = [];
    	$i=0;
	    //$user = User::ByUserType('3')->with('userprofile')->get();
      $user = User::ByUserType('3')->with('userprofile')->paginate('10');
	    //dd($user);

      $currency = Currency::where('status','1')->orderBy('id','ASC')->pluck('token');

	    foreach ($user as $key => $value) 
	    {
        
	    	$walletlists = Usercurrencyaccount::where('user_id', $value->id)->with('currency')->get();

        //dd($walletlists);
	    	
	    	//$walletbal = new Collection;

	    	/*foreach ($walletlists as $keys => $values) 
	    	{
	    		$userbal = $this->getUserCurrencyBalance($value,$values->currency_id);
	    		
	    		$walletbal->push(['balance'=>$userbal,'token'=>$values->currency->token]);
	    	}  */  
	    	
	    	//BTC 
	    	$pg_btc= $this->getPgDetailsByGatewayName('bitcoin_blockio');
	    	$user_accounts_btc = '';
            $balance_btc = 0;
            $user_accounts_btc = Userpayaccounts::getAccountDetails($value->id,$pg_btc->id)->first();
            if(count($user_accounts_btc)>0)
            {
              if($user_accounts_btc->btc_address!='')
              {
                $balance_btc = $this->getWalletBalance($user_accounts_btc->btc_address);

                $user_accounts_btc = $user_accounts_btc->btc_address;
              }
            }
              $btc_currency_details=$this->getCurrencyDetailsByName('BTC');

            //LTC
            $pg_ltc = $this->getPgDetailsByGatewayName('ltc_blockio');
            $user_accounts_ltc = '';
            $balance_ltc = 0;
            $user_accounts_ltc = Userpayaccounts::getAccountDetails($value->id,$pg_ltc->id)->first();

             
             

            if(count($user_accounts_ltc)>0)
            {
              //echo $value->id.$user_accounts_ltc->ltc_address;
                if($user_accounts_ltc->ltc_address!='')
                  {
                       $balance_ltc = $this->getLTCWalletBalance($user_accounts_ltc->ltc_address);

                       $user_accounts_ltc = $user_accounts_ltc->ltc_address;
                  }
            }
             $ltc_currency_details=$this->getCurrencyDetailsByName('LTC');

            // //DOGE
            // $pg_doge = $this->getPgDetailsByGatewayName('dogecoin_blockio');
            // $user_accounts_doge = '';
            // $balance_doge=0;
            // $user_accounts_doge=Userpayaccounts::getAccountDetails($value->id,$pg_doge->id)->first();
            // if(count($user_accounts_doge)>0)
            // {
            //   if($user_accounts_doge->doge_address!='')
            //     {
            //          $balance_doge=$this->getDOGEWalletBalance($user_accounts_doge->doge_address);
            //          $user_accounts_doge = $user_accounts_doge->doge_address;
            //     }
            // }
            // $doge_currency_details = $this->getCurrencyDetailsByName('DOGE');

           /* $balance->push(['name'=>$value->name,'btc_address'=>$user_accounts_btc,'ltc_address'=>$user_accounts_ltc,'doge_address'=>$user_accounts_doge,'btc_balance' => $balance_btc,'ltc_balance' =>$balance_ltc, 'doge_balance' => $balance_doge,'btc_token' => $btc_currency_details->token,'ltc_token' => $ltc_currency_details->token,'doge_token' => $doge_currency_details->token]);*/
        $btccurrency = Currency::where('name','BTC')->first();
        $bchcurrency = Currency::where('name','BCH')->first();
        $eth_currency = Currency::where('name','ETH')->first();
        $ltc_currency = Currency::where('name','LTC')->first();
        $xrp_currency = Currency::where('name','XRP')->first();
        $icx_currency = Currency::where('name','ICX')->first();
        $eos_currency = Currency::where('name','EOS')->first();
        $ada_currency = Currency::where('name','ADA')->first();
        $qau_currency = Currency::where('name','Qtum')->first();
        $etc_currency = Currency::where('name','ETC')->first();
         $krw_currency = Currency::where('name','KRW')->first();
         $usd_currency = Currency::where('name','USD')->first();

       //dd($bchcurrency);

           $balance[$i]['name'] = $value->name;
           $balance[$i]['btc_address'] =$this->getcurrencyBalance('BTC',$btccurrency->id,$value->id,'address');

            $balance[$i]['bch_address'] =$this->getcurrencyBalance('BCH',$bchcurrency->id,$value->id,'address');

             $balance[$i]['eth_address'] =$this->getcurrencyBalance('ETH',$eth_currency->id,$value->id,'address');

           $balance[$i]['ltc_address'] =$this->getcurrencyBalance('LTC',$ltc_currency->id,$value->id,'address');

            $balance[$i]['xrp_address'] =$this->getcurrencyBalance('XRP',$xrp_currency->id,$value->id,'address');

              $balance[$i]['icx_address'] =$this->getcurrencyBalance('ICX',$icx_currency->id,$value->id,'address');

                $balance[$i]['eos_address'] =$this->getcurrencyBalance('EOS',$eos_currency->id,$value->id,'address');

                $balance[$i]['ada_address'] =$this->getcurrencyBalance('ADA',$ada_currency->id,$value->id,'address');

                $balance[$i]['qau_address'] =$this->getcurrencyBalance('QAU',$qau_currency->id,$value->id,'address');

              $balance[$i]['etc_address'] =$this->getcurrencyBalance('ETC',$etc_currency->id,$value->id,'address');

              $balance[$i]['krw_address']='';
              $balance[$i]['usd_address']='';


          // $balance[$i]['doge_address'] = $user_accounts_doge;
              
           $balance[$i]['btc_balance'] =$this->getcurrencyBalance('BTC',$btccurrency->id,$value->id,'balance');
            $balance[$i]['bch_balance'] =$this->getcurrencyBalance('BCH',$bchcurrency->id,$value->id,'balance');
             $balance[$i]['eth_balance'] =0;

           $balance[$i]['ltc_balance'] =$this->getcurrencyBalance('LTC',$ltc_currency->id,$value->id,'balance');


            $balance[$i]['xrp_balance'] =$this->getcurrencyBalance('XRP',$xrp_currency->id,$value->id,'balance');
             $balance[$i]['icx_balance'] =$this->getcurrencyBalance('ICX',$icx_currency->id,$value->id,'balance');
             $balance[$i]['eos_balance'] =$this->getcurrencyBalance('EOS',$eos_currency->id,$value->id,'balance');
             $balance[$i]['ada_balance'] =$this->getcurrencyBalance('ADA',$ada_currency->id,$value->id,'balance');
             $balance[$i]['qau_balance'] =$this->getcurrencyBalance('QAU',$qau_currency->id,$value->id,'balance');
             $balance[$i]['etc_balance'] =$this->getcurrencyBalance('ETC',$etc_currency->id,$value->id,'balance');

          $balance[$i]['krw_balance'] =$this->getcurrencyBalance('KRW',
            $krw_currency->id,$value->id,'balance');

             $balance[$i]['usd_balance'] =$this->getcurrencyBalance('USD',
            $usd_currency->id,$value->id,'balance');

          // $balance[$i]['doge_balance'] = $balance_doge;
           $balance[$i]['btc_token'] = $btc_currency_details->token;
           $balance[$i]['bch_token'] = $bchcurrency->token;
           $balance[$i]['eth_token'] = $eth_currency->token;
           $balance[$i]['ltc_token'] = $ltc_currency->token;
           $balance[$i]['xrp_token'] = $xrp_currency->token;
           $balance[$i]['icx_token'] = $icx_currency->token;
           $balance[$i]['eos_token'] =  $eos_currency->token;
           $balance[$i]['ada_token'] = $ada_currency->token;
            $balance[$i]['qau_token'] = $qau_currency->token;
            $balance[$i]['etc_token'] = $etc_currency->token;
            $balance[$i]['krw_token'] = $krw_currency->token;
            $balance[$i]['usd_token'] = $usd_currency->token;

           //$balance[$i]['ltc_token'] = $ltc_currency_details->token;

           //$balance[$i]['doge_token'] = $doge_currency_details->token;

        foreach ($walletlists as $keys => $values) 
	    	{
	    		$userbal = $this->getUserCurrencyBalance($value,$values->currency_id);   		

	    		$balance[$i][$values->currency->token] = $userbal;
	    	} 
			$i++;

	    }

//$key = multidimensional_search($balance,balanceay('name'=>'sowmya'));
	    //$key = balanceay_search('sowmya', balanceay_column($balance, 'name'));

	    //$keys = balanceay_keys(balanceay_combine(balanceay_keys($balance), balanceay_column($balance, 'name')),'sowmya');

		//dd($keys);

//$test = array_intersect_key($balance, array(array("name" => "sowmya")));
//$key = array_search('root', $value->name);
	//$keys = $this->custom_search($balance);
//dd($key);
	    $currency = Currency::where('status','1')->orderBy('id','ASC')->pluck('token');
      $cryptocurrency = Currency::where('status','0')->orderBy('id','ASC')->pluck('token');

	    //dd($cryptocurrency);
	    return view('reports.membal',[
	    	'balance' => $balance,
	    	'currency' => $currency,
        'cryptocurrency'=>$cryptocurrency,
         'user' => $user,
	    ]);
	}

    public function index()
    {
      //$balance = new Collection;
       
      //$user = User::ByUserType('3')->with('userprofile')->get();
      $users = User::ByUserType('3')->with('userprofile')->paginate('10');
      //dd($user);

     //$users = User::ByUserType('3')->with('userprofile')->get();

        $currency = Currency::orderBy('order', 'ASC')->get();
        $totalequ = 0;
        $i = 0;
        $balance = 0;
        $equ = 0;
        $address ="";

         $wallets =new Collection;
   
      if(count($currency) > 0)
        {
            foreach ($users as $user) 
            {

         foreach ($currency as $val) {
            $balance = 0;
            $equ = 0;
            $address ="";  
            $i++;
            try {
                
                if ($val->name == "KRW") {
                  $userpay = Usercurrencyaccount::where('currency_id', $val->id)->where('user_id', $user->id)->first();
                   $address = $userpay->account_no;
                    $balance = $this->getUserCurrencyBalance($user, $val->id);

                    $equ = $balance;

                    $totalequ += $balance;

                } else if ($val->name == "USD") {

                  $userpay = Usercurrencyaccount::where('currency_id', $val->id)->where('user_id', $user->id)->first();

                    $address = $userpay->account_no;
                    $balance = $this->getUserCurrencyBalance($user, $val->id);

                    $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                    (double) $totalequ += $equ;
                } else if ($val->name == 'BTC') {
                    //BTC
                    $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');

                   // dd($pg);

                    $user_accounts = Userpayaccounts::getAccountDetails($user->id, $pg->id)->first();
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

                    $user_accounts = Userpayaccounts::getAccountDetails($user->id, $pg->id)->first();
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

                    $user_accounts = Userpayaccounts::getAccountDetails($user->id, $pg->id)->first();
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

                    $user_accounts = Userpayaccounts::getAccountDetails($user->id, $pg->id)->first();
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
      }

       //dd($wallets);

      return view('reports.membal',[
        'balance' => $wallets,
         'users' => $users,
      ]);
  }

}

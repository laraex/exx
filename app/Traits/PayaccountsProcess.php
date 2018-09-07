<?php 

namespace App\Traits;

use App\User;
use App\Models\Userpayaccounts;
use App\Models\Paymentgateway;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


trait PayaccountsProcess {

    public function bankwire($request, $current) 
    {
          
          $pay=Paymentgateway::where('id',$request->paymentid)->first();

        $user_pay = new Userpayaccounts;
        $user_pay->user_id = Auth::id();
        $user_pay->paymentgateways_id = $request->paymentid;
        $user_pay->active = 1;
        $user_pay->currency_id =$pay->currency_id;
        $user_pay->current = $current;
        $user_pay->param1 = $request->bank_name;
        $user_pay->param2 = $request->swift_code;
        $user_pay->param3 = $request->account_no;
        $user_pay->param4 = $request->account_name;
        $user_pay->param5 = $request->account_address;
        $user_pay->save();

    }
   
    public function bitcoin($request, $current) 
    {    
           $pay=Paymentgateway::where('id',$request->paymentid)->first();
    
        $user_pay = new Userpayaccounts;
        $user_pay->user_id = Auth::id();
        $user_pay->paymentgateways_id = $request->paymentid;
        $user_pay->active = 1;
        $user_pay->currency_id =$pay->currency_id;
        $user_pay->current = $current;
        $user_pay->param1 = $request->coinname;
        $user_pay->param2 = $request->coincode;
        $user_pay->save();
    }  
    public function bitcoinWallet($request,$user_id,$current,$status,$currency_id) 
    {        
        $user_pay = new Userpayaccounts;
        $user_pay->user_id = $user_id;
        $user_pay->paymentgateways_id = $request->paymentid;
        $user_pay->active = $status;
        $user_pay->current = $current;
        $user_pay->btc_label = $request->label;
        $user_pay->btc_address = $request->btc_address;
        $user_pay->currency_id =$currency_id;
        $user_pay->save();
    } 

    public function ltcWallet($request,$user_id,$current,$status,$currency_id) 
    {        
        $user_pay = new Userpayaccounts;
        $user_pay->user_id = $user_id;
        $user_pay->paymentgateways_id = $request->paymentid;
        $user_pay->active = $status;
        $user_pay->current = $current;
        $user_pay->ltc_label = $request->label;
        $user_pay->ltc_address = $request->ltc_address;
        $user_pay->currency_id =$currency_id;
        $user_pay->save();
    }                     
   public function dogeWallet($request,$user_id,$current,$status) 
    {        
        $user_pay = new Userpayaccounts;
        $user_pay->user_id = $user_id;
        $user_pay->paymentgateways_id = $request->paymentid;
        $user_pay->active = $status;
        $user_pay->currency_id =$request->currency_id;
        $user_pay->current = $current;
        $user_pay->doge_label = $request->label;
        $user_pay->doge_address = $request->doge_address;
        $user_pay->save();
    } 
     public function ethWallet($request,$user_id,$current,$status,$currency_id) 
    {        
        $user_pay = new Userpayaccounts;
        $user_pay->user_id = $user_id;
        $user_pay->paymentgateways_id = $request->paymentid;
        $user_pay->active = $status;
        $user_pay->current = $current;
        $user_pay->eth_passphrase = $request->eth_passphrase;
        $user_pay->eth_address = $request->eth_address;
         $user_pay->currency_id =$currency_id;
        $user_pay->save();
    } 
    public function bitcoincashWallet($request,$user_id,$current,$status,$currency_id) 
    {        
        $user_pay = new Userpayaccounts;
        $user_pay->user_id = $user_id;
        $user_pay->paymentgateways_id = $request->paymentid;
        $user_pay->active = $status;
        $user_pay->current = $current;
        $user_pay->bch_label = $request->label;
        $user_pay->bch_address = $request->bch_address;
         $user_pay->currency_id =$currency_id;
        $user_pay->save();
    } 
    public function xrpWallet($request,$user_id,$current,$status,$currency_id) 
    {        
        $user_pay = new Userpayaccounts;
        $user_pay->user_id = $user_id;
        $user_pay->paymentgateways_id = $request->paymentid;
        $user_pay->active = $status;
        $user_pay->current = $current;
        $user_pay->xrp_secret = $request->xrp_secret;
        $user_pay->xrp_address = $request->xrp_address;
         $user_pay->currency_id =$currency_id;
        $user_pay->save();
    } 
    public function qtumWallet($request,$user_id,$current,$status,$currency_id) 
    {        
        $user_pay = new Userpayaccounts;
        $user_pay->user_id = $user_id;
        $user_pay->paymentgateways_id = $request->paymentid;
        $user_pay->active = $status;
        $user_pay->current = $current;
        $user_pay->qtum_label = $request->label;
        $user_pay->qtum_address = $request->qtum_address;
        $user_pay->currency_id =$currency_id;
        $user_pay->save();
    } 
 }
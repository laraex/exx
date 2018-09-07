<?php

namespace App\Http\Controllers\Myaccount;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Traits\Common;
use App\Models\Userpayaccounts;
use App\Http\Requests\BitcoinSendRequest;
use App\Classes\block_io\BlockIo;
use Exception;
use App\Http\Requests\LTCSendRequest;
use App\Http\Requests\DOGESendRequest;
use App\Transfer;
use App\Http\Requests\ETHSendRequest;
use App\Http\Requests\BitcoincashSendRequest;
use App\Http\Controllers\CryptoPayment\CryptoPaymentBase;
use App\Http\Requests\WithdrawCurrencyRequest;
use App\Traits\SettlementProcess;
use App\Traits\TransactionProcess;
use App\Models\Transaction;
use App\Http\Requests\QTUMSendRequest;
use App\Http\Requests\XRPSendRequest;
class CoinController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
      use Common,SettlementProcess,TransactionProcess;
    public function __construct()
    {
        $this->middleware(['auth', 'member']);
    }
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function send_create()
    {       
      return view ('coin.btc_send');
    }

    public function receive_create()
    {
      $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
      $btc_address='';
      $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
      if(count($user_accounts)>0)
      {
        $btc_address=$user_accounts->btc_address;
      }

     return view ('coin._bitcoin_receive', [
             'btc_address'=>$btc_address,

              ]);  
    }
    public function send_store(BitcoinSendRequest $request)
    {
      $amount=sprintf("%.8f", $request->amount);
      \DB::beginTransaction();
      try
      {
        $response=[];
        $currencydetails=$this->getCurrencyDetailsByName('BTC');
        $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
        $btc_address=$user_accounts->btc_address;
                //Bitcoind   
             //Blockchain imp  
             /* $comment="Send Coin";
              $comment_to="Send Coin";         
              $send_array['amount']=$amount;
              $send_array['from_address']=$btc_address;
              $send_array['to_address']=$request->address;
              $send_array['fromaccount']=$user_accounts->btc_label;          //Bitcoind   
              $send_array['comment']=$comment;
              $send_array['comment_to']=$comment_to;
         
             $response= CryptoPaymentBase::crypto_sendBTC($send_array);
            
             
             if(count($response)>0)
             {
               $this->makeTransfer(Auth::id(),$btc_address,$request->address,$amount,$pg->currency_id,$response);
             // \Session::put('successmessage','Coin Send Successfully');
             }
            else
            {
               \Session::put('failmessage','Try after Sometime');
            }*/

            $fee=$pg->crypto_withdraw_fee;
            $base_fee=$pg->crypto_withdraw_base_fee;

            $fee_total=($amount*($fee/100))+$base_fee;

            $transaction_id=uniqid();
            $transfer=$this->makeTransfer(Auth::id(),$btc_address,$request->address,$amount,$pg->currency_id,$response,'pending',$transaction_id,$fee,$base_fee,$fee_total);
            //Transfer

            $total_amount=$amount+$fee_total;
            $comment='Transfer';
            $accounting_code=$this->getAccountingCode('transfer');
            $array=array();
            $balance_before=Transaction::BalanceBefore(Auth::id(),$currencydetails->id)->latest()->first();

        
            $balance_before= $balance_before->balance_after;
            $balance_after= $balance_before-$amount;
      
            $transaction=$this->createTransaction(Auth::id(),$currencydetails->id,$total_amount,"debit","approve","transfer",$accounting_code,$comment,'','',$transfer->id,get_class($transfer),$balance_before,$balance_after,"NULL","NULL", $array);

       
          \DB::commit();
       
       // \Session::put('successmessage','Coin Send Successfully');
        }
        catch (Exception $e) 
        { //dd($e->getMessage());
               \DB::rollBack();
          // if an exception happened in the try block above 
          \Session::put('failmessage',$e->getMessage());
        }
        $responses['status']='ok';
        $responses['message']=trans('forms.bitcoin_withdraw_success_message');
        $responses['code']='200';

        return $responses;     

        //return Redirect::to(url('/myaccount/type/btc/send'));
    }

    public function send_withdrawstore(WithdrawCurrencyRequest $request)
    {
      $amount=sprintf("%.8f", $request->amount);
      try
      {
        $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
        $btc_address=$user_accounts->btc_address;
                //Bitcoind   
               
              $comment="Send Coin";
              $comment_to="Send Coin";         
              $send_array['amount']=$amount;
              $send_array['from_address']=$btc_address;
              $send_array['to_address']=$request->btc_address;
              $send_array['fromaccount']=$user_accounts->btc_label;          //Bitcoind   
              $send_array['comment']=$comment;
              $send_array['comment_to']=$comment_to;
         
             $response= CryptoPaymentBase::crypto_sendBTC($send_array);
            
             
             if(count($response)>0)
             {
               $this->makeTransfer(Auth::id(),$btc_address,$request->btc_address,$amount,$pg->currency_id,$response);
              \Session::put('successmessage','Coin Send Successfully');
            }
            else
            {
               \Session::put('failmessage','Try after Sometime');
            }

        
       
        \Session::put('successmessage','Coin Send Successfully');
        }
        catch (Exception $e) 
        { 
          // if an exception happened in the try block above 
          \Session::put('failmessage',$e->getMessage());
        }
        
        return Redirect::to(url('/myaccount/type/btc/send'));
    }

    public function ltc_send_create()
    {       
      return view ('coin.ltc_send');
    }

   public function ltc_receive_create()
    {
      $pg = $this->getPgDetailsByGatewayName('ltc_blockio');
      $ltc_address='';
      $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
      
      if(count($user_accounts)>0)
      {
        $ltc_address=$user_accounts->ltc_address;
      }

     return view ('coin._ltc_receive', [
             'ltc_address'=>$ltc_address,
      ]);  
    }
    public function ltc_send_store(LTCSendRequest $request)
    {
      $amount=sprintf("%.8f", $request->amount);
      \DB::beginTransaction();
      try
      {
        $response=[];
        $currencydetails=$this->getCurrencyDetailsByName('LTC');
        $pg = $this->getPgDetailsByGatewayName('ltc_blockio');
        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
        $ltc_address=$user_accounts->ltc_address;
                //Bitcoind   
             //Blockchain imp  
             /* $comment="Send Coin";
              $comment_to="Send Coin";         
              $send_array['amount']=$amount;
              $send_array['from_address']=$btc_address;
              $send_array['to_address']=$request->address;
              $send_array['fromaccount']=$user_accounts->btc_label;          //Bitcoind   
              $send_array['comment']=$comment;
              $send_array['comment_to']=$comment_to;
         
             $response= CryptoPaymentBase::crypto_sendBTC($send_array);
            
             
             if(count($response)>0)
             {
               $this->makeTransfer(Auth::id(),$btc_address,$request->address,$amount,$pg->currency_id,$response);
             // \Session::put('successmessage','Coin Send Successfully');
             }
            else
            {
               \Session::put('failmessage','Try after Sometime');
            }*/

            $fee=$pg->crypto_withdraw_fee;
            $base_fee=$pg->crypto_withdraw_base_fee;

            $fee_total=($amount*($fee/100))+$base_fee;

            $transaction_id=uniqid();
            $transfer=$this->makeTransfer(Auth::id(),$ltc_address,$request->address,$amount,$pg->currency_id,$response,'pending',$transaction_id,$fee,$base_fee,$fee_total);
            //Transfer

            $total_amount=$amount+$fee_total;
            $comment='Transfer';
            $accounting_code=$this->getAccountingCode('transfer');
            $array=array();
            $balance_before=Transaction::BalanceBefore(Auth::id(),$currencydetails->id)->latest()->first();

        
            $balance_before=$balance_before->balance_after;
            $balance_after= $balance_before-$amount;
      
            $transaction=$this->createTransaction(Auth::id(),$currencydetails->id,$total_amount,"debit","approve","transfer",$accounting_code,$comment,'','',$transfer->id,get_class($transfer),$balance_before,$balance_after,"NULL","NULL", $array);

       
          \DB::commit();
       
       // \Session::put('successmessage','Coin Send Successfully');
        }
        catch (Exception $e) 
        { //dd($e->getMessage());
               \DB::rollBack();
          // if an exception happened in the try block above 
          \Session::put('failmessage',$e->getMessage());
        }
        $responses['status']='ok';
        $responses['message']=trans('forms.litecoin_withdraw_success_message');
        $responses['code']='200';

        return $responses;    
    }

    // public function ltc_send_store(LTCSendRequest $request)
    // {
    //   //$request->ltc_address=$request->address;
    //   $amount=sprintf("%.8f", $request->amount);
    //   try
    //   {
    //     $pg = $this->getPgDetailsByGatewayName('ltc_blockio');
    //     $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
    //     $ltc_address=$user_accounts->ltc_address;
 
    //       //Litecoind   
               
    //           $comment="Send Coin";
    //           $comment_to="Send Coin";         
    //           $send_array['amount']=$amount;
    //           $send_array['from_address']=$ltc_address;
    //           $send_array['to_address']=$request->address;
    //           $send_array['fromaccount']=$user_accounts->ltc_label;          //Litecoind   
    //           $send_array['comment']=$comment;
    //           $send_array['comment_to']=$comment_to;
         
    //          $response= CryptoPaymentBase::crypto_sendLTC($send_array);

       
    //      if(count($response)>0)
    //          {
    //            $this->makeTransfer(Auth::id(),$ltc_address,$request->address,$amount,$pg->currency_id,$response);
    //        //   \Session::put('successmessage','Coin Send Successfully');
    //         }
    //         else
    //         {
    //            \Session::put('failmessage','Try after Sometime');
    //         }
    
    //   }
    //   catch (Exception $e) 
    //   { 
    //     // if an exception happened in the try block above 
    //     \Session::put('failmessage',$e->getMessage());
    //   }
      
    //  // return Redirect::to(url('/myaccount/type/ltc/send'));

    //     $responses['status']='ok';
    //     $responses['message']=trans('forms.litecoin_withdraw_success_message');
    //     $responses['code']='200';

    //     return $responses;  
    // }

    public function doge_send_create()
    {       
       return view ('coin.doge_send');
    }

    public function doge_receive_create()
    {
      $pg = $this->getPgDetailsByGatewayName('dogecoin_blockio');
      $doge_address='';
      $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
      
      if(count($user_accounts)>0)
      {
        $doge_address=$user_accounts->doge_address;
      }

      return view ('coin._doge_receive', [
        'doge_address'=>$doge_address,
      ]);  
    }

    public function doge_send_store(DOGESendRequest $request)
    {
      $amount=sprintf("%.8f", $request->amount);
      try
      {
        $pg = $this->getPgDetailsByGatewayName('dogecoin_blockio');
        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
        $doge_address=$user_accounts->doge_address;
   
        $params = json_decode($pg->params, true);
        $api_key= $params['api_key'];
        $pin= $params['pin'];   
       

        $version = $params['version']; // API version
        $block_io = new BlockIo( $api_key, $pin, $version);

        $response=$block_io->withdraw_from_addresses(array('amounts' => $amount, 'from_addresses' =>$doge_address,'to_addresses' =>$request->doge_address));

        $this->makeTransfer(Auth::id(),$doge_address,$request->doge_address,$amount,$pg->currency_id,$response);
       
        \Session::put('successmessage','Coin Send Successfully');
      }
      catch (Exception $e) 
      { 
        // if an exception happened in the try block above 
        \Session::put('failmessage',$e->getMessage());
      }
        return Redirect::to(url('/myaccount/type/doge/send'));
    }

    public function makeTransfer($user_id,$from_address,$to_address,$amount,$coin_id,$response,$status,$transaction_id,$fee,$base_fee,$fee_total)
    {
      $create=[
        'user_id'=>$user_id,
        'from_address'=>$from_address,                                
        'to_address'=>$to_address,                                
        'amount'=>$amount,                                
        'coin_id'=>$coin_id,                                
       // 'response'=>json_encode($response),                                         
        'status'=>$status,                                         
        'transaction_id'=>$transaction_id,                                         
        'fee'=>$fee,                                         
        'base_fee'=>$base_fee,                                         
        'fee_total'=>$fee_total,                                         
                                         
      ];
      if(count($response)>0)
      {
        $create['response']=json_encode($response);
      }
      
     $transfer= Transfer::create($create);
      
      return $transfer;
    }

    public function show()
    {

       $transactions = Transfer::where('user_id',Auth::id())->with('currency')->orderBy('id','DESC')->paginate(10);

        return view('coin.show',[
             'transactions'=>$transactions,
        ]);
    } 
    public function eth_receive_create()
    {
      $pg = $this->getPgDetailsByGatewayName('eth');
      $eth_address='';
      $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
     
      if(count($user_accounts)>0)
      {
        $eth_address=$user_accounts->eth_address;
      }

     return view ('coin._eth_receive', [
             'eth_address'=>$eth_address,

              ]);  
    }

     public function eth_send_create()
    {       
      return view ('coin.eth_send');
    }

    // public function eth_send_store(ETHSendRequest $request)
    // {
    // //  $amount=sprintf("%.8f", $request->amount);
    //   $amount=$request->amount;
    //   try
    //   {
    //     $pg = $this->getPgDetailsByGatewayName('eth');
    //     $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
    //     $eth_address=$user_accounts->eth_address;
   
  
                       
    //           $send_array['amount']=$amount;
    //           $send_array['from_address']=$eth_address;
    //           $send_array['to_address']=$request->address;
    //           $send_array['passphrase']=$user_accounts->eth_passphrase;             
         
         
    //          $response= CryptoPaymentBase::crypto_sendETH($send_array);

       
    //      if(count($response)>0)
    //       {
    //            $this->makeTransfer(Auth::id(),$eth_address,$request->address,$amount,$pg->currency_id,$response);
    //        //   \Session::put('successmessage','Coin Send Successfully');
    //         }
    //         else
    //         {
    //            \Session::put('failmessage','Try after Sometime');
    //         }
    
    //   }
    //   catch (Exception $e) 
    //   { 
    //     // if an exception happened in the try block above 
    //     \Session::put('failmessage',$e->getMessage());
    //   }
    //    $responses['status']='ok';
    //     $responses['message']=trans('forms.ethcoin_withdraw_success_message');
    //     $responses['code']='200';
    //     return $responses;

    //   //return Redirect::to(url('/myaccount/type/eth/send'));
    // }
    public function eth_send_store(ETHSendRequest $request)
    {
      $amount=sprintf("%.8f", $request->amount);
      \DB::beginTransaction();
      try
      {
        $response=[];
        $currencydetails=$this->getCurrencyDetailsByName('ETH');
        $pg = $this->getPgDetailsByGatewayName('eth');
        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
         $eth_address=$user_accounts->eth_address;
            
            $fee=$pg->crypto_withdraw_fee;
            $base_fee=$pg->crypto_withdraw_base_fee;

            $fee_total=($amount*($fee/100))+$base_fee;

            $transaction_id=uniqid();
            $transfer=$this->makeTransfer(Auth::id(),$eth_address,$request->address,$amount,$pg->currency_id,$response,'pending',$transaction_id,$fee,$base_fee,$fee_total);
            //Transfer

            $total_amount=$amount+$fee_total;
            $comment='Transfer';
            $accounting_code=$this->getAccountingCode('transfer');
            $array=array();
            $balance_before=Transaction::BalanceBefore(Auth::id(),$currencydetails->id)->latest()->first();

        
            $balance_before=$balance_before->balance_after;
            $balance_after= $balance_before-$amount;
      
            $transaction=$this->createTransaction(Auth::id(),$currencydetails->id,$total_amount,"debit","approve","transfer",$accounting_code,$comment,'','',$transfer->id,get_class($transfer),$balance_before,$balance_after,"NULL","NULL", $array);

       
          \DB::commit();
       
       // \Session::put('successmessage','Coin Send Successfully');
        }
        catch (Exception $e) 
        { //dd($e->getMessage());
               \DB::rollBack();
          // if an exception happened in the try block above 
          \Session::put('failmessage',$e->getMessage());
        }
        $responses['status']='ok';
        $responses['message']=trans('forms.ethcoin_withdraw_success_message');
        $responses['code']='200';

        return $responses;    
    }

    public function bch_send_create()
    {       
      return view ('coin.bch_send');
    }

    public function bch_receive_create()
    {
      $pg = $this->getPgDetailsByGatewayName('bch');
      $bch_address='';
      $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
     
      if(count($user_accounts)>0)
      {
        $bch_address=$user_accounts->bch_address;
      }

     return view ('coin._bch_receive', [
             'bch_address'=>$bch_address,

              ]);  
    }
    // public function bch_send_store(BitcoincashSendRequest $request)
    // {
    //   $amount=sprintf("%.8f", $request->amount);
    //   try
    //   {
    //     $pg = $this->getPgDetailsByGatewayName('bch');
    //     $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
    //     $bch_address=$user_accounts->bch_address;
    //             //Bitcoind   
    //           $comment="Send Coin";
    //           $comment_to="Send Coin";         
    //           $send_array['amount']=$amount;
    //           $send_array['from_address']=$bch_address;
    //           $send_array['to_address']=$request->address;
    //           $send_array['fromaccount']=$user_accounts->bch_label;          //Bitcoind   
    //           $send_array['comment']=$comment;
    //           $send_array['comment_to']=$comment_to;
         
    //          $response= CryptoPaymentBase::crypto_sendBCH($send_array);
            
             
    //          if(count($response)>0)
    //          {
    //            $this->makeTransfer(Auth::id(),$bch_address,$request->address,$amount,$pg->currency_id,$response);
    //           \Session::put('successmessage','Coin Send Successfully');
    //         }
    //         else
    //         {
    //            \Session::put('failmessage','Try after Sometime');
    //         }

    //      $this->makeTransfer(Auth::id(),$bch_address,$request->address,$amount,$pg->currency_id,$response);
       
    //   //  \Session::put('successmessage','Coin Send Successfully');
    //     }
    //     catch (Exception $e) 
    //     { 
    //       // if an exception happened in the try block above 
    //       \Session::put('failmessage',$e->getMessage());
    //     }
    //     $responses['status']='ok';
    //     $responses['message']=trans('forms.bchcoin_withdraw_success_message');
    //     $responses['code']='200';
    //     return $responses;
    //    // return Redirect::to(url('/myaccount/type/bch/send'));
    // }

    public function bch_send_store(BitcoincashSendRequest $request)
    {
      $amount=sprintf("%.8f", $request->amount);
      \DB::beginTransaction();
      try
      {
        $response=[];
        $currencydetails=$this->getCurrencyDetailsByName('BCH');
        $pg = $this->getPgDetailsByGatewayName('bch');
        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
         $bch_address=$user_accounts->bch_address;
            
            $fee=$pg->crypto_withdraw_fee;
            $base_fee=$pg->crypto_withdraw_base_fee;

            $fee_total=($amount*($fee/100))+$base_fee;

            $transaction_id=uniqid();
            $transfer=$this->makeTransfer(Auth::id(),$bch_address,$request->address,$amount,$pg->currency_id,$response,'pending',$transaction_id,$fee,$base_fee,$fee_total);
            //Transfer

            $total_amount=$amount+$fee_total;
            $comment='Transfer';
            $accounting_code=$this->getAccountingCode('transfer');
            $array=array();
            $balance_before=Transaction::BalanceBefore(Auth::id(),$currencydetails->id)->latest()->first();

        
            $balance_before=$balance_before->balance_after;
            $balance_after= $balance_before-$amount;
      
            $transaction=$this->createTransaction(Auth::id(),$currencydetails->id,$total_amount,"debit","approve","transfer",$accounting_code,$comment,'','',$transfer->id,get_class($transfer),$balance_before,$balance_after,"NULL","NULL", $array);

       
          \DB::commit();
       
       // \Session::put('successmessage','Coin Send Successfully');
        }
        catch (Exception $e) 
        { //dd($e->getMessage());
               \DB::rollBack();
          // if an exception happened in the try block above 
          \Session::put('failmessage',$e->getMessage());
        }
        $responses['status']='ok';
        $responses['message']=trans('forms.bchcoin_withdraw_success_message');
        $responses['code']='200';

        return $responses;    
    }


    //Withdraw Qtum Coins
    public function send_qtumstore(QTUMSendRequest $request)
    {
      $amount=sprintf("%.8f", $request->amount);
      \DB::beginTransaction();
      try
      {
        $response=[];
        $currencydetails=$this->getCurrencyDetailsByName('QTUM');
        $pg = $this->getPgDetailsByGatewayName('qtum');
        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
        $qtum_address=$user_accounts->qtum_address;
             

            $fee=$pg->crypto_withdraw_fee;
            $base_fee=$pg->crypto_withdraw_base_fee;

            $fee_total=($amount*($fee/100))+$base_fee;

            $transaction_id=uniqid();
            $transfer=$this->makeTransfer(Auth::id(),$qtum_address,$request->address,$amount,$pg->currency_id,$response,'pending',$transaction_id,$fee,$base_fee,$fee_total);
            //Transfer

            $total_amount=$amount+$fee_total;
            $comment='Transfer';
            $accounting_code=$this->getAccountingCode('transfer');
            $array=array();
            $balance_before=Transaction::BalanceBefore(Auth::id(),$currencydetails->id)->latest()->first();

        
            $balance_before= $balance_before->balance_after;
            $balance_after= $balance_before-$amount;
      
            $transaction=$this->createTransaction(Auth::id(),$currencydetails->id,$total_amount,"debit","approve","transfer",$accounting_code,$comment,'','',$transfer->id,get_class($transfer),$balance_before,$balance_after,"NULL","NULL", $array);

       
          \DB::commit();
       
        }
        catch (Exception $e) 
        { //dd($e->getMessage());
               \DB::rollBack();
          // if an exception happened in the try block above 
          \Session::put('failmessage',$e->getMessage());
        }
        $responses['status']='ok';
        $responses['message']=trans('forms.qtum_withdraw_success_message');
        $responses['code']='200';

        return $responses;     

    }

    //Withdraw Ripple Coins
    public function send_xrpstore(XRPSendRequest $request)
    {
      $amount=$request->amount;
      \DB::beginTransaction();
      try
      {
        $response=[];
        $currencydetails=$this->getCurrencyDetailsByName('XRP');
        $pg = $this->getPgDetailsByGatewayName('xrp');
        $user_accounts=Userpayaccounts::getAccountDetails(Auth::id(),$pg->id)->first();
        $xrp_address=$user_accounts->xrp_address;
             

            $fee=$pg->crypto_withdraw_fee;
            $base_fee=$pg->crypto_withdraw_base_fee;

            $fee_total=($amount*($fee/100))+$base_fee;

            $transaction_id=uniqid();
            $transfer=$this->makeTransfer(Auth::id(),$xrp_address,$request->address,$amount,$pg->currency_id,$response,'pending',$transaction_id,$fee,$base_fee,$fee_total);
            //Transfer

            $total_amount=$amount+$fee_total;
            $comment='Transfer';
            $accounting_code=$this->getAccountingCode('transfer');
            $array=array();
            $balance_before=Transaction::BalanceBefore(Auth::id(),$currencydetails->id)->latest()->first();

        
            $balance_before= $balance_before->balance_after;
            $balance_after= $balance_before-$amount;
      
            $transaction=$this->createTransaction(Auth::id(),$currencydetails->id,$total_amount,"debit","approve","transfer",$accounting_code,$comment,'','',$transfer->id,get_class($transfer),$balance_before,$balance_after,"NULL","NULL", $array);

       
          \DB::commit();
       
        }
        catch (Exception $e) 
        { //dd($e->getMessage());
               \DB::rollBack();
          // if an exception happened in the try block above 
          \Session::put('failmessage',$e->getMessage());
        }
        $responses['status']='ok';
        $responses['message']=trans('forms.xrp_withdraw_success_message');
        $responses['code']='200';

        return $responses;     

    }


}

<?php

namespace App\Http\Controllers\Myaccount;
use App\Http\Controllers\Myaccount\CoinController;
use Illuminate\Http\Request;

class BTCController extends CoinController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WithdrawCurrencyRequest $request)
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

         $this->makeTransfer(Auth::id(),$btc_address,$request->btc_address,$amount,$pg->currency_id,$response);
       
        \Session::put('successmessage','Coin Send Successfully');
        }
        catch (Exception $e) 
        { 
          // if an exception happened in the try block above 
          \Session::put('failmessage',$e->getMessage());
        }
        
        return Redirect::to(url('/myaccount/type/btc/send'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

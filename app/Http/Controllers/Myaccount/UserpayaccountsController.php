<?php

namespace App\Http\Controllers\Myaccount;

use App\User;
use App\Models\Currency;
use App\Models\Userpayaccounts;
use App\Models\Paymentgateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Traits\PayaccountsProcess;
use App\Models\Userprofile;
use App\Http\Requests\UserPayAccountsRequest;
use App\Traits\LogActivity;

class UserpayaccountsController extends Controller
{   
    use LogActivity;
     public function __construct()
    {
        $this->middleware(['auth', 'member']);
    }
    use PayaccountsProcess;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allpayaccounts = Paymentgateway::where([['active', '=', "1"],['withdraw', '=', "1"]])->with('userpayaccounts')->get();

         //dd($allpayaccounts);

        return view('home.mypayaccounts', [
            'allpayaccounts' => $allpayaccounts,
        ]);
    }
    public function index__()
    {
        $allPayments = Paymentgateway::where([['active', '=', "1"],['withdraw', '=', "1"]])->get();
        $bitcoin_direct   = $allPayments->where('id', '1')->count();
        $bankusd  = $allPayments->where('id', '2')->count();
        $bankgbp  = $allPayments->where('id', '3')->count();
        $bankeuro  = $allPayments->where('id', '4')->count();
        $bankngn  = $allPayments->where('id', '5')->count();   

        $paymentsResult  = Userpayaccounts::where([['user_id', '=', Auth::id()],['active', '=', "1"]])->get(); 

        $bitcoin_result  = $paymentsResult->where('paymentgateways_id', '1');
        $bankwire_usd_result  = $paymentsResult->where('paymentgateways_id', '2');  
        // dd($bankwire_result);
        $bankwire_gbp_result  = $paymentsResult->where('paymentgateways_id', '3');     
        $bankwire_euro_result  = $paymentsResult->where('paymentgateways_id', '4');     
        $bankwire_ngn_result  = $paymentsResult->where('paymentgateways_id', '5');                     
        return view('home.mypayaccounts', [
            'bitcoin_direct' => $bitcoin_direct,
            'bankusd' => $bankusd,
            'bankngn' => $bankngn,
            'bankgbp' => $bankgbp,
            'bankeuro' => $bankeuro,
            'bitcoin_result' => $bitcoin_result,
            'bankwire_usd_result' => $bankwire_usd_result,
            'bankwire_ngn_result' => $bankwire_ngn_result,
            'bankwire_gbp_result' => $bankwire_gbp_result,
            'bankwire_euro_result' => $bankwire_euro_result,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $payment = Paymentgateway::where([['id', '=', $id],['active', '=', "1"],['withdraw', '=', "1"]])->first();
        return view('home.mypayaccounts_bank_create', [
            'payment' => $payment,  
        ]);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserPayAccountsRequest $request)
    {
       // dd($request);
        $result  = Userpayaccounts::where([['user_id', '=', Auth::id()],['paymentgateways_id', '=', $request->paymentid]])->exists();

        //$active = "0";
        $current = "0";
        if(!$result )
        {
            //$active = "1";
            $current = "1";
        } 
        
         //bitcoin -direct waalet
        if ($request->paymentid == 1)
        {
            $result = $this->bitcoin($request, $current);           
        }

        //Bank wire
        if ($request->paymentid > 1)
        {
            $result = $this->bankwire($request,  $current);
        }    

           //Activity Log
        $payment_details = Paymentgateway::where([['active', '=', "1"],['id', '=', $request->paymentid]])->first();

        $message=$payment_details->displayname." Pay Account Added";

        $user = User::find(Auth::id());
        $this->doActivityLog(
            $user,
            $user,
            ['ip' => request()->ip()],
            LOGNAME_PAYACCOUNT,
            $message
        );  

         $response['status']='ok';
        $response['message']='Bank details added Successfully';
        $response['code']='200';
        

        return $response;
  
        //return Redirect::to('myaccount/viewpayaccounts')->with('status', trans('forms.payaccount_added_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Userpayaccounts  $userpayaccounts
     * @return \Illuminate\Http\Response
     */
    public function show(Userpayaccounts $userpayaccounts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Userpayaccounts  $userpayaccounts
     * @return \Illuminate\Http\Response
     */
    public function edit(Userpayaccounts $userpayaccounts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Userpayaccounts  $userpayaccounts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Userpayaccounts $userpayaccounts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Userpayaccounts  $userpayaccounts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Userpayaccounts $userpayaccounts)
    {
        //
    }

     public function removeaccount ($id)
    {
        $user_pay = Userpayaccounts::where('id', $id )->first();
        $user_pay->active = '0';
        $user_pay->save(); 

        return Redirect::to('myaccount/viewpayaccounts')->with('status', trans('forms.payaccount_remove_success'));
     }

    //  public function activeaccounts($id, $paymentid, $status)
    // {

    //     $result  = Userpayaccounts::where([                                        
    //                                         ['user_id', '=', Auth::id()],
    //                                         ['paymentgateways_id', '=', $paymentid]
    //                                         ])->get();         
    //     foreach($result as $payaccounts)
    //     {          
    //         $user_pay = Userpayaccounts::where('id', $payaccounts->id )->first();
    //         $user_pay->active = '0';
    //         $user_pay->save();                                 
    //     }

    //     $user_pay = Userpayaccounts::where('id', $id )->first();
    //         $user_pay->active = '1';
    //         $user_pay->save(); 

    //     return Redirect::to('myaccount/viewpayaccounts')->with('status', trans('forms.payaccount_active_success'));
    //  }

    public function currentaccounts($id, $paymentid, $current)
    {
         $result  = Userpayaccounts::where([                                        
                                            ['user_id', '=', Auth::id()],
                                            ['paymentgateways_id', '=', $paymentid]
                                            ])->get();        
        foreach($result as $payaccounts)
        {          
            $user_pay = Userpayaccounts::where('id', $payaccounts->id )->first();
            $user_pay->current = '0';
            $user_pay->save();                                  
        }

        $user_pay = Userpayaccounts::where('id', $id )->first();
            $user_pay->current = '1';
            $user_pay->save(); 

        return Redirect::to('myaccount/viewpayaccounts')->with('status', trans('forms.payaccount_default_success'));
    }
    public function create_wallet($coinname)
    {


         $user = User::where('id', Auth::id())->with('userprofile')->first();

         if($coinname=='btc')
         {
             return view('home._mypayaccounts_btc', [
                    'user' => $user,
                    'coinname'=>$coinname
                    ]);
         }

         if($coinname=='ltc')
         {
             return view('home._mypayaccounts_ltc', [
                    'user' => $user,
                    'coinname'=>$coinname
                    ]);
         }
         if($coinname=='eth')
         {
             return view('home._mypayaccounts_eth', [
                    'user' => $user,
                    'coinname'=>$coinname
                    ]);
         }

    }
    public function store_wallet(Request $request,$coinname)
    {
        if($coinname=='btc')
        {

            $update=[
            'btc_address'=>$request->btc_address
            ];
        }

        if($coinname=='ltc')
        {

            $update=[
            'ltc_address'=>$request->ltc_address
            ];
        }
        if($coinname=='eth')
        {

            $update=[
            'eth_address'=>$request->eth_address
            ];
        }
            Userprofile::where('user_id',Auth::id())->update($update);

             \Session::put('successmessage','Save Address Successfully');
             return Redirect::to('myaccount/viewpayaccounts/type/'.$coinname);

    }
    public function bank_details($id)
    {
        $account = Userpayaccounts::where('id',$id)->first();
//dd($bankdetails);   
        return view('home.create_bank', [
            'account' => $account,
        ]);
    }

    public function getPayaccount($id)
    {
        

        $currency=Currency::where('name',$id)->first();

        $allpayaccounts = Paymentgateway::where([['active', '=', "1"],['currency_id', '=',$currency->id]])->first();

        // dd($allpayaccounts);
        // paymentgateways_id

        $account = Userpayaccounts::where('paymentgateways_id',$allpayaccounts->id)->get();

        //dd($account);

        return $account;
        
    }

}

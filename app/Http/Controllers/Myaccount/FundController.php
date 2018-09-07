<?php

namespace App\Http\Controllers\Myaccount;

use App\User;
use App\Models\Paymentgateway;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\FundRequest;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Helpers\SiteHelper;
use App\Traits\FundProcess;
use App\Models\Usercurrencyaccount;
use App\Models\Currency;
use App\Traits\UserInfo;
use PDF;
use App\Traits\LogActivity;
use App\Traits\DepositProcess;
use App\Traits\Common;
use App\Models\Userpayaccounts;
use App\Deposit;
class FundController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'member']);      
    }

    use FundProcess, UserInfo, LogActivity,DepositProcess;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function fundlist($status, $currencyid)
    {
        $currency_accounting_code = Usercurrencyaccount::where([
                ['user_id', '=', Auth::id()],
                ['currency_id', '=', $currencyid]
            ])->first();
         // dd($currency_accounting_code);

         $currencydetails = Currency::where('id', $currencyid)->first();
         //dd($currencydetails);

        $fundlists = Transaction::where([
                ['action', '=', 'deposit'],
                ['deposit_status', '=', $status],
                ['account_id', '=', $currency_accounting_code->id]
            ])->latest('updated_at')->paginate(\Config::get('settings.pagecount'));

         // dd($fundaddedlists);

        return view ('fund.myfundlist', [
                'fundlists' => $fundlists,
                'account_no' => $currency_accounting_code->account_no,
                'currencydetails' => $currencydetails,
                'currency_accounting_code' => $currency_accounting_code,
                'user_id' => Auth::id(),
                'status' => $status,
                'currencyid' => $currencyid
            ]);
    }

    public function addfundcurrency($currency)
    {
        // dd($currency);
        \Session::put('currency_id', $currency);
        return Redirect::to('myaccount/addfund');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        \Session::put('currency_id','11');


        //dd('dkjf');
        $pgs = Paymentgateway::where([['active', '=', '1'],['currency_id', '=', \Session::get('currency_id')]])->first();

        $currency_accounting_code = Usercurrencyaccount::where([['user_id', '=', Auth::id()],
                ['currency_id', '=', \Session::get('currency_id')]])->first();
       
        $currencydetails = Currency::where('id', \Session::get('currency_id'))->first();

        $user = User::where('id', Auth::id())->first();
        $isKycApproved = $this->isKycApproved($user);
        $isEmailVerified = $this->isEmailVerified($user);

        return view ('fund.create', [
                'pgs' => $pgs,
                'isKycApproved' => $isKycApproved,
                'isEmailVerified' => $isEmailVerified,
                'currencydetails' => $currencydetails,
                'currency_accounting_code' => $currency_accounting_code,
                'account_no' => $currency_accounting_code->account_no,
                'user_id' => Auth::id(),
                ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FundRequest $request)
    {
        //dd($request);
        \Session::put('currency_id',$request->currency_id);

        $paymentgateway = $request->paymentgateway;
        $amount = $request->amount;     
        $pgInfo = $this->getPgInfo($request->paymentgateway );
        $params = $pgInfo[0];
        $instructions = $pgInfo[1];       
        $user = User::where('id', Auth::id())->first();
        $pgs = Paymentgateway::where('id', $paymentgateway)->first();
             
        \Session::put('amount', $request->amount);
        \Session::put('paymentgateway', $request->paymentgateway);

        $currencydetails = Currency::where('id', \Session::get('currency_id'))->first();

        $currency_accounting_code = Usercurrencyaccount::where([
                ['user_id', '=', Auth::id()],
                ['currency_id', '=', \Session::get('currency_id')]
            ])->first();


           $tranaction_uuid = uniqid();
             \Session::put('transactionnumber', $tranaction_uuid);

        // if($request->paymentgateway == 1 )
        // { 
        //    return Redirect::to( url('/myaccount/fund/bitcoindirect'));       
        // } 

        // if($request->paymentgateway > 1)
        // { 

        //     $tranaction_uuid = uniqid();
        //     \Session::put('transactionnumber', $tranaction_uuid);

        //     return view('fund._bankwire_form', [
        //         'paymentgateway' => $paymentgateway,
        //         'amount' => $amount,
        //         'params' => $params,
        //         'request'  => $request,
        //         'transaction_id' => $tranaction_uuid,
        //         'instructions' => $instructions,
        //         'currencyname' => $currencydetails->name,
        //          'currencydetails' => $currencydetails,
        //         'currency_accounting_code' => $currency_accounting_code,
        //          'account_no' => $currency_accounting_code->account_no,
        //          'user_id' => Auth::id()
        //         ]);
        // }

               $detail=array('paymentgateway' => $paymentgateway,
                'amount' => $amount,
                'params' => $params,
                'request'  => $request,
                'transaction_id' => $tranaction_uuid,
                'instructions' => $instructions,
                'currencyname' => $currencydetails->name,
                 'currencydetails' => $currencydetails,
                'currency_accounting_code' => $currency_accounting_code,
                 'account_no' => $currency_accounting_code->account_no,
                 'user_id' => Auth::id()
                );

             //  $funddetails=json_encode($detail);
        $response['status']='ok';
        $response['message']='';
        $response['code']='200';
        $response['funddetails']=$detail;
        return $response;
          
    }  

    public function savebankwire(Request $request )
    {
          //dd($request);

        $admin = User::find(1);
        $user = Auth::user();        
       // $result = $this->makeAddFund($request);  
        $sessionarray=$this->sessionToDepositRequest();

        $request->merge(['user_id'=>Auth::id()]);
        $request->merge(['status'=>'new']);

        $request->merge($sessionarray);
        
        $result = $this->makeDeposit($request);   
            
       // $user->notify(new DepositSuccessfull($deposit_result));
       // $admin->notify(new AdminNotifyNewDeposit($deposit_result));

        // if($result)
        // {
        //     $request->session()->flash('successmessage', trans('forms.add_fund_success_msg'));
        // }
        // else
        // {
        //     $request->session()->flash('failmessage', trans('forms.add_fund_error_msg'));
        // }

         $response['status']='ok';
        $response['message']=trans('forms.add_fund_success_msg');
        $response['code']='200';
        // $response['funddetails']=$detail;

        return $response;
       // return  Redirect::to('myaccount/accounts');
    }    

    public function bitcoindirect()
    {  
            $pgInfo = $this->getPgInfo(\Session::get('paymentgateway'));
            $params = $pgInfo[0];
            $instructions = $pgInfo[1];       
            $user = User::where('id', Auth::id())->first();

            $btcamount = \Session::get('amount');           

            $tranaction_uuid = uniqid();          
            return view('fund._bitcoin_directwallet_form', [
                    'paymentgateway' => \Session::get('paymentgateway'),
                    'username' => $user->name,
                    'amount' => \Session::get('amount'),
                    'btcamount' => $btcamount,
                    'params' => $params,
                    'transaction_id' => $tranaction_uuid,
                    'instructions' => $instructions,
                ]);
    } 

    public function savebitcoindirect(Request $request)
    { 
        Validator::extend('checkbitcoinhashkey', function ($attribute, $value, $parameters, $validator) {
                 $checktxnhashkey = Transaction::where('param', Input::get('txnhashkey'))->exists();  
                // dd($checktxnhashkey);

                   if ($checktxnhashkey)
                   {
                        return FALSE;
                   }
                   return TRUE;            
        }, trans('forms.hashkey_error'));

        Validator::extend('checkvalidhashkey', function ($attribute, $value, $parameters, $validator) {
                 
                 $response_json = SiteHelper::getBitcoinWalletDetails(Input::get('txnhashkey'));

                 $response_json = json_decode($response_json, true);
                 //dd($response_json);
               if (is_null($response_json))
               {
                    return FALSE;
               }
                   return TRUE;            
        }, trans('forms.invalid_hashkey'));  

      
        $validator = Validator::make($request->all(), [
                'txnhashkey'      => 'required|checkbitcoinhashkey|checkvalidhashkey',
            ]);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }

        //dd($request);
        $admin = User::find(1);
        $user = Auth::user();        
        $result = $this->makeAddFund($request);       
       

        if($result)
        {
            $request->session()->flash('successmessage', trans('forms.add_fund_success_msg'));
        }
        else
        {
            $request->session()->flash('failmessage', trans('forms.add_fund_error_msg'));
        }
        return  Redirect::to('myaccount/accounts');

    }   


    public function printinvoice()
    {
        // dd(\Session::get());
        $data = Paymentgateway::where('id', '=', \Session::get('paymentgateway'))->first(); 
        $params = json_decode($data->params, true);

        $pdf = PDF::loadView('fund.print_invoice', [
                        'params' => $params,
                        ]);
        // return $pdf->download('invoice.pdf');
        return $pdf->stream();
    }
     public function invoice($depositid)
    {
        // dd(\Session::get());
        $deposit =  Deposit::where('id', '=', $depositid)->first(); 
        $params = json_decode($deposit->request, true);

        $pdf = PDF::loadView('fund.invoice', [
                        'params' => $params['admin'],
                        'deposit' => $deposit,
                        ]);
        // return $pdf->download('invoice.pdf');
        return $pdf->stream();
    }

    public function viewdepositsprintinvoice($depositid)
    {
        

        $deposit = Deposit::where('id', '=', $depositid)->with('paymentgateway')->first(); 

        if (is_null($deposit))
        {
            abort(404);
        }

        $transactionnumber = $this->getinvoicetransaction($deposit->transaction_id);

        $paymentgateway = Paymentgateway::where('id', '=', $deposit->paymentgateway->id)->first(); 
        $params = json_decode($paymentgateway->params, true);
      
        //dd($params);

        $pdf = PDF::loadView('home.invoiceprint', [
                        'params' => $params,
                        'transactionnumber' => $transactionnumber,
                        'amount' => $deposit->amount,
                        ]);
        // return $pdf->download('invoice.pdf');
        return $pdf->stream();

    }   

    public function getPgInfo($pgID) {
                $pg = Paymentgateway::where('id', $pgID)->first();
                $params = json_decode($pg->params, true);
                $instructions = $pg->instructions;
                $pgInfo = [$params, $instructions ];
                return $pgInfo;
    }
    public function deletebank($id)
    {
          //dd($request);
        //dd($id);
        Userpayaccounts::where('id',$id)->delete();

         $response['status']='ok';
        $response['message']=trans('forms.delete_bank_success_msg');
        $response['code']='200';
        // $response['funddetails']=$detail;
        return $response;
       // return  Redirect::to('myaccount/accounts');
    }        
}

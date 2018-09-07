<?php

namespace App\Http\Controllers\Myaccount;

use App\Http\Requests\WithdrawRequest;
use App\Mail\WithdrawSend;
use App\Models\Currency;
use App\Models\Paymentgateway;
use App\Models\Transaction;
use App\Models\Usercurrencyaccount;
use App\Models\Userpayaccounts;
use App\Models\Userprofile;
use App\Models\Withdraw;
use App\TradeCurrencyPair;
use App\Traits\UserInfo;
use App\Traits\WithdrawProcess;
use App\User;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\Models\Accountingcode;


class WithdrawController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'member']);
    }

    use WithdrawProcess, UserInfo;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status)
    {
        if (in_array($status, array('pending', 'completed', 'rejected')) == false) {
            abort(404);
        }

        $withdrawlists = Withdraw::where('status', $status)->where('user_id', Auth::id())->with(['user', 'transaction', 'userpayaccounts'])->latest('updated_at')->paginate(Config::get('settings.pagecount'));

        // dd($withdrawlists);

        $pendingsum = Withdraw::where('status', 'pending')->where('user_id', Auth::id())->sum('amount');
        $completedsum = Withdraw::where('status', 'completed')->where('user_id', Auth::id())->sum('amount');
        $lifetimesum = Withdraw::whereNotIn('status', array('rejected', 'request'))->where('user_id', Auth::id())->sum('amount');

        $currency_accounting_code = Usercurrencyaccount::where([
            ['user_id', '=', Auth::id()],
            ['currency_id', '=', \Session::get('currencyid')],
        ])->first();

        // dd(\Session::get('currencyid'));

        $currencydetails = Currency::where('id', \Session::get('currencyid'))->first();

        //dd($withdrawlists);

        return view('withdraw.show', [
            'withdrawlists' => $withdrawlists,
            'status' => $status,
            'pendingsum' => $pendingsum,
            'completedsum' => $completedsum,
            'lifetimesum' => $lifetimesum,
            'currencydetails' => $currencydetails,
            'currency_accounting_code' => $currency_accounting_code,
            'account_no' => $currency_accounting_code->account_no,
            'user_id' => Auth::id(),
        ]);
    }

    public function redirectform($paymentgatewayid)
    {
        \Session::put('paymentgatewayid', $paymentgatewayid);
        return Redirect::to('myaccount/withdraw');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd(\Session::get('paymentgatewayid'));

        $user = User::where('id', Auth::id())->with(['userprofile', 'useraccount'])->first();

        $withdraw = Withdraw::where('user_id', Auth::id())->where('autowithdraw', '0')->where('status', '!=', 'request');

        $currentMonth = date('m');
        $monthly_withdraw_count = $withdraw->whereRaw('MONTH(created_at) = ?', [$currentMonth])->get()->count();
        $monthly_remaining_withdraw_limit = \Config::get('settings.monthly_withdraw_limit') - $monthly_withdraw_count;

        $daily_withdraw_count = $withdraw
            ->whereRaw('Date(created_at) = CURDATE()')
            ->get()->count();
        $daily_remaining_withdraw_limit = \Config::get('settings.daily_withdraw_limit') - $daily_withdraw_count;

        $isKycApproved = $this->isKycApproved($user);
        $isEmailVerified = $this->isEmailVerified($user);
        //dd($isEmailVerified);

        $payaccount_result = Userpayaccounts::where([
            ['user_id', '=', Auth::id()],
            ['active', '=', "1"],
            ['paymentgateways_id', '=', \Session::get('paymentgatewayid')],
        ])->get();

        // dd($payaccount_result);
        $paymentdetails = Paymentgateway::where('id', \Session::get('paymentgatewayid'))->get(['withdraw_commission', 'displayname', 'currency_id'])->toArray();
        \Session::put('currencyid', $paymentdetails[0]['currency_id']);
        $admincommission = $paymentdetails[0]['withdraw_commission'];

        $currency_accounting_code = Usercurrencyaccount::where([
            ['user_id', '=', Auth::id()],
            ['currency_id', '=', $paymentdetails[0]['currency_id']],
        ])->first();

        $currencydetails = Currency::where('id', $paymentdetails[0]['currency_id'])->first();

        $userbalance = $this->getUserCurrencyBalance($user, $paymentdetails[0]['currency_id']);

        return view('withdraw.create',
            [
                'paymentgateway' => \Session::get('paymentgatewayid'),
                'paymentdisplayname' => $paymentdetails[0]['displayname'],
                'currency_id' => $paymentdetails[0]['currency_id'],
                'userbalance' => $userbalance,
                'user_withdraw_count' => $monthly_withdraw_count,
                'monthly_remaining_withdraw_limit' => $monthly_remaining_withdraw_limit,
                'force_withdraw_down' => \Config::get('settings.force_withdraw_down'),
                'isKycApproved' => $isKycApproved,
                'isEmailVerified' => $isEmailVerified,
                'force_email_verification_for_withdraw' => \Config::get('settings.force_email_verification_for_withdraw'),
                'force_kyc_verification_for_withdraw' => \Config::get('settings.force_kyc_verification_for_withdraw'),
                'kyc_doc' => $user->userprofile->kyc_doc,
                'daily_remaining_withdraw_limit' => $daily_remaining_withdraw_limit,
                'daily_withdraw_taken_count' => $daily_withdraw_count,
                'payaccount_result' => $payaccount_result,
                'admincommission' => $admincommission,
                'transaction_password' => $user->userprofile->transaction_password,
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
    public function store(WithdrawRequest $request)
    {

          //dd("DDD");

       // dd($request);

        $result = $this->withdrawrequest($request);
       // dd("DadddDD");

        $adminemail = User::where('id', 2)->get(['email'])->toArray();
        $adminemailid = $adminemail[0]['email'];

        $user = User::find(Auth::id());

        Mail::to($adminemailid)->send(new WithdrawSend($result, $user));

        // if ($result)
        // {

        //     $request->session()->flash('successmessage', trans('forms.withdraw_request_success_message'));
        // }
        // else
        // {
        //     $request->session()->flash('errormessage', trans('forms.withdraw_request_error_message'));
        // }
        // return Redirect::to('myaccount/withdraw/pending');

        $response['status'] = 'ok';
        $response['message'] = trans('forms.withdraw_request_success_message');
        $response['code'] = '200';

        return $response;

    }

    public function updatewithdrawdetails(WithdrawOtpRequest $request)
    {

        $result = $this->withdrawrequest($request);

        $adminemail = User::where('id', 2)->get(['email'])->toArray();
        $adminemailid = $adminemail[0]['email'];

        if ($result) {
            Mail::to($adminemailid)->queue(new WithdrawSend($result));

            $request->session()->flash('successmessage', trans('forms.withdraw_request_success_message'));
        } else {
            $request->session()->flash('errormessage', trans('forms.withdraw_request_error_message'));
        }
        return Redirect::to(url('/myaccount/withdraw/pending'));
    }

    public function userpayaccount(Request $request)
    {
        //dd($request);
        $payaccount_result = Userpayaccounts::where([
            ['user_id', '=', Auth::id()],
            ['active', '=', "1"],
            ['paymentgateways_id', '=', $request->paymentid],
        ])->get();
        $commissionvalue = Paymentgateway::where('id', $request->paymentid)->get(['withdraw_commission'])->toArray();
        $admincommission = $commissionvalue[0]['withdraw_commission'];
        //dd($admincommission);
        return view('withdraw.userpayaccount',
            [
                'payaccount_result' => $payaccount_result,
                'admincommission' => $admincommission,
            ]);
    }

    public function viewbitcoinwallet($id)
    {
        $withdraw = Withdraw::where('id', $id)->with('userpayaccounts')->first();
        //dd($withdraw->userpayaccounts->param2);

        // $curl_json = HyipHelper::getBitcoinWalletDetails($withdraw->param);

        // $curl_json = json_decode($curl_json, true);

        // $received_amount = '';
        // foreach ($curl_json['vout'] as $vout)
        //  {
        //     if ($vout['scriptPubKey']['addresses'][0] == $withdraw->userpayaccounts->param2)
        //     {
        //         $received_amount .= $vout['value'];
        //     }
        //  }

        //  $txhashid = $curl_json['txid'];
        //  $total_confirmations = $curl_json['confirmations'];
        //  $bitcoin_transaction_time = date("Y-m-d H:i:s", $curl_json['time']);
        //  $actual_withdraw_amount = HyipHelper::convertBtcAmount($withdraw->amount);

        return view('partials._withdraw_bitcoin_wallet_details', [
            'txnhashkey' => $withdraw->param,
            // 'confirmations' => $total_confirmations,
            // 'actual_withdraw_amount' => $actual_withdraw_amount,
            // 'received_amount' => $received_amount,
            // 'bitcoin_transaction_time' => $bitcoin_transaction_time,
        ]);
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
    public function savexrpBuy()
    {

        $user_id = Auth::id();

        $account_id = Usercurrencyaccount::where([
            ['user_id', '=', $user_id],
            ['currency_id', '=', 10],
        ])->get(['id'])->toArray();
        $account_id = $account_id[0]['id'];
        
        $accountcodeResult  = Accountingcode::where('active', "1"); 

        $accounting_code  = $accountcodeResult->where('accounting_code', 'withdraw-via-bitcoin')->get(['id'])->toArray();

        $accounting_code = $accounting_code[0]['id'];

        $pair_details = TradeCurrencyPair::where([['id', 5], ['status', 'active']])->first();
        $prev_details=Transaction::where([['status','approve'],['currency_id',10],['user_id',$user_id]])->latest()->first();
        $balance_before = $prev_details->balance_after; 
        $getrate = $this->getexchangerate(1, $pair_details->tocurrency->name, $pair_details->fromcurrency->name, 'buy');
        $balance_after = $balance_before - $getrate * 30;
        $transaction = new Transaction;
        $transaction->account_id = $account_id;
        $transaction->amount = $getrate * 30;
        $transaction->type = "debit";
        $transaction->status = "1";
        $transaction->status = 10;
        $transaction->action = "withdraw";
        $transaction->user_id = $user_id;
        $transaction->balance_after = $balance_after;
        $transaction->balance_before = $balance_before;
        $transaction->accounting_code_id = $accounting_code;
        // $transaction->request = json_encode($request_json);
        $transaction->save();
        $response['status'] = 'ok';
        $response['message'] = trans('forms.withdraw_request_success_message');
        $response['code'] = '200';

        return $response;

    }
}

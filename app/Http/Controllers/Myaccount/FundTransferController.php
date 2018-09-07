<?php

namespace App\Http\Controllers\Myaccount;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Fundtransfer;
use App\Models\Usercurrencyaccount;
use App\Traits\UserInfo;
use App\Http\Requests\FundTransferRequest;
use App\Traits\FundTransferProcess;
use Illuminate\Support\Facades\Redirect;
use App\Notifications\User\FundTransferReceived;
use Config;
use App\Models\Currency;
use Illuminate\Support\Facades\Mail;
use App\Mail\FundTransferReceiver;
use App\Mail\FundTransferSender;
use App\Traits\LogActivity;

class FundTransferController extends Controller
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

    use UserInfo, FundTransferProcess;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        $fundtransfer = Fundtransfer::latest('updated_at')->with('fundtransfer_to_id', 'fundtransfer_from_id');

        $currency_id = Currency::get()->pluck('id')->toarray();

          // dd($currency_id);

        $account_id = Usercurrencyaccount::where('user_id', '=', Auth::id())->whereIn('currency_id', $currency_id)->get()->pluck('id')->toArray();
        // dd($account_id);

        if ($type == 'send')
        {
            $transferlists = $fundtransfer->whereIn('from_account_id', $account_id)->paginate(Config::get('settings.pagecount'));
        }
        elseif ($type == 'received')
        {
            $transferlists = $fundtransfer->whereIn('to_account_id', $account_id)->paginate(Config::get('settings.pagecount'));
        }
        else
        {
            abort(404);
        }

        $currency_accounting_code = Usercurrencyaccount::where([
                ['user_id', '=', Auth::id()],
                ['currency_id', '=', \Session::get('currencyid')]
            ])->first();

         $currencydetails = Currency::where('id', \Session::get('currencyid'))->first();   

        //dd($transferlists);

         return view('fundtransfer.show', [
                'type' => $type,
                'transferlists' => $transferlists,
                'currencydetails' => $currencydetails,
                'currency_accounting_code' => $currency_accounting_code,
                'account_no' => $currency_accounting_code->account_no,
                'user_id' => Auth::id(),
            ]);
    }

    public function redirectform($currencyid)
    {
        \Session::put('currencyid', $currencyid);
        return Redirect::to('/myaccount/fundtransfer/send');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $user = User::where('id', Auth::id())->with(['userprofile','useraccount'])->first();

        $userbalance = $this->getUserCurrencyBalance($user, \Session::get('currencyid'));

        $isKycApproved = $this->isKycApproved($user);
        $isEmailVerified = $this->isEmailVerified($user);

        $currency_accounting_code = Usercurrencyaccount::where([
                ['user_id', '=', Auth::id()],
                ['currency_id', '=', \Session::get('currencyid')]
            ])->first();

         $currencydetails = Currency::where('id', \Session::get('currencyid'))->first();        

        return view('fundtransfer.send',[
                'userbalance' => $userbalance,
                'isKycApproved' => $isKycApproved,
                'isEmailVerified' => $isEmailVerified,
                'force_email_verification_for_fund_transfer'  => \Config::get('settings.force_email_verification_for_fund_transfer'),
                'force_kyc_verification_for_fund_transfer'  => \Config::get('settings.force_kyc_verification_for_fund_transfer'),
                'kyc_doc' => $user->userprofile->kyc_doc,
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
    public function store(FundTransferRequest $request)
    {
        $result = $this->sendFundTransfer($request);
       // dd($result->$from_account_id);
        if ($result)
        {
            $sender = User::where('id', Auth::id())->first();
           // dd($sender);
            $user = User::where('name', $request->sendto)->first();
            //dd($user->email);
            $user->notify(new FundTransferReceived);
            Mail::to($user->email)->queue(new FundTransferReceiver($result)); 
            Mail::to($sender->email)->queue(new FundTransferSender($result));  
            $request->session()->flash('successmessage', trans('forms.fund_transfer_success_message'));
        }
        else
        {
            $request->session()->flash('failmessage', trans('forms.fund_transfer_error_message'));
        }
        return Redirect::to( url('/myaccount/fundtransfer/type/send'));  
    }

    public function searchuser(Request $request) 
    {
        $query = $request->get('term','');
        
        $users=User::where('name','LIKE','%'.$query.'%')->get();
        
        $data=array();

        foreach ($users as $users) 
        {
                $data[]=array('value'=>$users->name,'id'=>$users->id);
        }
        if(count($data))
        {
             return $data;
        }
        else
        {
            return ['value'=>'No Result Found','id'=>''];
        }
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

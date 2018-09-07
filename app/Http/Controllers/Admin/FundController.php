<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Paymentgateway;
use App\Models\Usercurrencyaccount;
use App\Models\Transaction;
use Carbon\Carbon;
use App\Settings;
use App\Accountingcode;
use Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use  App\Notifications\DepositSuccessfull;
use  App\Notifications\AdminNotifyNewDeposit;
use App\Traits\FundProcess;
use App\Notifications\User\FundDepositApprove;
use App\Notifications\User\FundDepositReject;
use App\Helpers\HyipHelper;
use App\Http\Requests\FundConfirmRequest;
use App\Traits\DepositProcess;
use App\Traits\Common;
use App\Traits\TransactionProcess;
use App\Deposit;
class FundController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','admin1']);
    }
    use FundProcess,DepositProcess,Common,TransactionProcess;


    

    public function index()
    {
        //
    } 

    public function activedepositfund()
    {

       /* $activefundlists = Transaction::where([
            ['type', 'credit'],
            ['deposit_status', 'active'],
            ['action', 'deposit'],
            ])->get();*/
            $activefundlists = Deposit::where('status', 'approve')->get();

         // dd($activefundlists);

        return view('admin.depositfund.show', [
                        'activefundlists' => $activefundlists
            ]);

    }
   public function depositfundconfirm($id) {

      //  $transaction = Transaction::where('id', $id)->first();
        $transaction = Deposit::where('id', $id)->first();
          // dd($transaction);
        
        return view('admin.depositfund.confirm', [
                'transactionid' => $id,
                'transaction' => $transaction
            ]);
    }    
    public function depositfundapprove(FundConfirmRequest $request, $id) {
       
       // $transaction=$this->approveFund($id,$request);

 
        $comment="{{ trans('admin_fund.req_fund') }}".$request->depositamount;


        $request->merge(['authorised_by'=>Auth::id()]);
        $deposit=$this->approveDeposit($id,$request);
        if ( $deposit)
        {
            $request->session()->flash('successmessage',trans("admin_fund.approved_successfully"));
        }
        else
        {             
            $request->session()->flash('errormessage',trans("admin_fund.approved_failed"));
        }  

        return Redirect::to('admin/actions/fund');
    }
     /*public function depositfundreject(Request $request,$id) {
       $transaction = Transaction::where('id', $id)->first();
        $transaction->status =0;      
        $transaction->action = "deposit-reject";
        if ($transaction->save()){
            $request->session()->flash('successmessage',trans("admin_fund.rejected_successfully"));
        }
        else{             
            $request->session()->flash('errormessage',trans("admin_fund.rejected_failed"));
        }  
        return Redirect::to('admin/actions/fund');
    }*/
    public function depositfundreject(Request $request,$id) {

          
        $request->merge(['authorised_by'=>Auth::id()]);
        $deposit=$this->rejectDeposit($id,$request);
        if ($deposit){
            $request->session()->flash('successmessage',trans("admin_fund.rejected_successfully"));
        }
        else{             
            $request->session()->flash('errormessage',trans("admin_fund.rejected_failed"));
        }  
        return Redirect::to('admin/actions/fund');
    }

    
}

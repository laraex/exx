<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Transfer;
use App\Http\Requests\CryptoWithdrawApproveRequest;
use App\Http\Requests\CryptoWithdrawCancelRequest;
use App\Traits\Common;
use App\Traits\TransactionProcess;
use App\Models\Transaction;
use App\Traits\CryptoWithdrawProcess;
use Illuminate\Support\Facades\Auth;
class CryptoWithdrawController extends Controller
{
   use Common,TransactionProcess,CryptoWithdrawProcess;
   public function __construct()
    {
        $this->middleware(['auth','admin1']);
    }

    
    public function index_pending()
    {

         $lists = Transfer::Where('status','pending')->orderBy('id','DESC')->with('currency','user')->paginate(\Config::get('settings.pagecount'));
          return view ('admin.cryptowithdraw.pending',[
            'lists'=>$lists
            ]);
    }
    
     public function index_approve()
    {

         $lists = Transfer::Where('status','approve')->orderBy('id','DESC')->with('currency','user')->paginate(\Config::get('settings.pagecount'));
          return view ('admin.cryptowithdraw.approve',[
            'lists'=>$lists
            ]);
    }
     public function index_cancel()
    {

         $lists = Transfer::Where('status','cancel')->orderBy('id','DESC')->with('currency','user')->paginate(\Config::get('settings.pagecount'));
          return view ('admin.cryptowithdraw.cancel',[
            'lists'=>$lists
            ]);
    }

    public function show_approve($id)
    {

         $transfer = Transfer::Where([['status','pending'],['id',$id]])->with('currency','user')->first();
          return view ('admin.cryptowithdraw.approve_transfer',[
            'transfer'=>$transfer
            ]);
    }
    public function store_approve(CryptoWithdrawApproveRequest $request,$id)
    {
      //dd("dd");

        $request->merge(['authorised_by'=>Auth::id()]);
       
        $transfer=$this->approveWithdraw($id,$request);
        if ( $transfer)
        {
            $request->session()->flash('successmessage',trans("admin_fund.approved_successfully"));
            return Redirect::to('admin/cryptowithdraw/approve');
        }
        else
        {             
            $request->session()->flash('failmessage',trans("admin_fund.approved_failed"));
            return Redirect::to('admin/cryptowithdraw/pending');
        }  

        
    
    }
    public function show_cancel($id)
    {

         $transfer = Transfer::Where([['status','pending'],['id',$id]])->with('currency','user')->first();
          return view ('admin.cryptowithdraw.cancel_transfer',[
            'transfer'=>$transfer
            ]);
    }
    public function store_cancel(CryptoWithdrawCancelRequest $request,$id)
    {

        $request->merge(['authorised_by'=>Auth::id()]);
        $transfer=$this->cancelWithdraw($id,$request);
        if ( $transfer)
        {
            $request->session()->flash('successmessage',"Cancelled Successfully");
        }
        else
        {             
            $request->session()->flash('errormessage',"Try after sometime");
        }  

        return Redirect::to('admin/cryptowithdraw/cancel');
    
    }
}

?>
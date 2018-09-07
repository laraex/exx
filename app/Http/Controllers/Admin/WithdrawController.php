<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Withdraw;
use App\User;
use App\Models\Userpayaccounts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\Traits\WithdrawProcess;
use Illuminate\Support\Facades\Mail;
use App\Mail\WithdrawApprove;
use App\Mail\WithdrawReject;
use App\Notifications\User\WithdrawComplete;
use App\Notifications\User\WithdrawCancelled;
use Illuminate\Bus\Queueable;

class WithdrawController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','admin1']);
    }
    use WithdrawProcess;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status)
    {
       $withdrawlists = Withdraw::where('status', $status)->with(['user', 'transaction', 'userpayaccounts'])->orderBy('id', 'DESC')->get();

       // dd($withdrawlists);

        if (in_array( $status, array( 'pending', 'completed', 'rejected', 'request')) == FALSE)
        {
                    abort(404);
        }

        return view('admin.withdraw.show', [
                        'withdrawlists' => $withdrawlists,
                        'status' => $status
            ]);
    } 

    public function complete($id)
    {
        $withdrawdetail = Withdraw::where('id', $id)->with('user', 'transaction')->first();
        // dd($withdrawdetail);
        $userpayaccounts = Userpayaccounts::where('id', $withdrawdetail->payaccount_id)->first();
        //dd($withdrawdetail);
        return view('admin.withdraw.complete',[
                        'userpayaccounts' => $userpayaccounts,
                        'withdrawdetail' => $withdrawdetail,
                        'withdrawid' => $id
            ]);
    } 

    public function updatecomplete(Request $request, $id)
    {
        //dd($request);
        //$user = User::where('id', $request->userid)->first();
        //sowmi for mail
        $withdraw = Withdraw::where('id', '=', $id)->first(); 
        $user_id = $withdraw->user_id;
        $user = User::where('id',$user_id)->first();
//dd($userdetail);
        $validator = Validator::make($request->all(), [
                'transactionnumber'      => 'required',
                'comment'         => 'required'               
            ]);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }      
        //dd("JJ");  

        $result = $this->updateCompleteStatus($request, $id);

        if($result)
        {
            Mail::to($user->email)->queue(new WithdrawApprove($result,$user));
            $user->notify(new WithdrawComplete);
            $request->session()->flash('successmessage', 'Withdraw request approved successfully');
        } 
        else 
        {
            $request->session()->flash('errormessage','Withdraw request approved failed!!!.');
        }      
        return redirect(url('admin/withdraw/completed'));        
    }
    public function reject($id)
    {
        //sowmi for mail
        $withdraw = Withdraw::where('id', '=', $id)->first(); 
        $user_id = $withdraw->user_id;
        $user = User::where('id',$user_id)->first();

        $withdrawdetail = Withdraw::where('id', $id)->with('user')->first();
        $userpayaccounts = Userpayaccounts::where('id', $withdrawdetail->payaccount_id)->first();
        //dd($withdrawdetail);
        return view('admin.withdraw.reject',[
                        'userpayaccounts' => $userpayaccounts,
                        'withdrawdetail' => $withdrawdetail,
                        'withdrawid' => $id
            ]);
    }

    public function updatereject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'comment'         => 'required'               
            ]);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }
        $user = User::where('id', $request->userid)->first();
        $result = $this->updateRejectStatus($request, $id);
        Mail::to($user->email)->queue(new WithdrawReject($result,$user));
        if( $result ) 
        {
            $user->notify(new WithdrawCancelled);
            $request->session()->flash('successmessage', '{{ trans("admin_withdraw.withdraw_reject") }}');
        } 
        else 
        {
            $request->session()->flash('errormessage','{{ trans("admin_withdraw.withdraw_reject_failed") }}');
        }      

        return redirect(url('admin/withdraw/rejected'));        
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
    public function store(Request $request)
    {      
                
        //
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
        return view('admin.withdraw.update');
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
       //dd($id);
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

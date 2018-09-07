<?php

namespace App\Http\Controllers\Myaccount;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class NotificationController extends Controller
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

    public function markasread(Request $request)
    {
        
        $user = User::where('id', Auth::id())->first();
        $notification = $user->notifications()->where('id', $request->notificationid)->first();
        if ($notification)
        {
            $notification->update(['read_at' => Carbon::now()]);
        }
        else
        {
            $request->session()->flash('errormessage', trans('forms.notification_error_message'));
        }


        if ((strpos($notification->type, 'KycVerify') !== false) || (strpos($notification->type, 'KycRejected') !== false))
        {
            return Redirect::to( url('/myaccount/viewprofile')); 
        }        
       
        // elseif (strpos($notification->type, 'AutoWithdrawalSend') !== false) 
        // {
        //     return Redirect::to( url('/myaccount/withdraw/pending')); 
        // }
    }
}

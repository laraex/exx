<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TicketPriorities;
use App\Models\TicketStatus;
use App\Models\TicketAttachment;
use App\Models\TicketCategories;
use App\Models\TicketCategoriesUsers;
use App\Models\TicketComments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Ticket;
use App\User;
use App\Models\Userprofile;
use Validator;
use Config;
use App\Traits\TicketProcess;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNotifyTicketStatus;
use App\Mail\UserNotifyTicketStatus;

class TicketsController extends Controller
{
    use TicketProcess;

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','staff']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userprofile = Userprofile::where('user_id', Auth::id())->with('user')->first();  
        $result = $this->myticketlist($userprofile);        
        return view('staff.tickets.showtickets', [
                    'result' => $result,
                    'userprofile' => $userprofile                
        ]);
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
        $userprofile = Userprofile::where('user_id', Auth::id())->with('user')->first(); 
        $ticketstatus = TicketStatus::get();
        $ticketdetails = $this->getTicketdetails($id); 
        $commentlists = $this->getCommentlists($id);       

        return view('staff.tickets.viewticket', [
                    'ticketdetails' => $ticketdetails,
                    'commentlists' => $commentlists,
                    'ticketstatus' => $ticketstatus,
                    'userprofile' => $userprofile                 
        ]); 
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
    public function update(Request $request, $statusid, $id)
    {
        $statusresult = $this->updateStatus($statusid, $id);
        $admin = User::find(1);
        $user = User::where('id', $statusresult->user_id)->first();

        if($statusresult) 
        {
            Mail::to($admin->email)->queue(new AdminNotifyTicketStatus($statusresult)); 
            Mail::to($user->email)->queue(new UserNotifyTicketStatus($statusresult));
            $request->session()->flash('successmessage', trans('forms.ticket_status_success_message'));   
        } 
        else 
        {
            $request->session()->flash('failmessage', trans('forms.ticket_status_failure_message'));   
        }
        return Redirect::to('staff/ticket/'.$id);
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

    public function storecomment(Request $request)
    {
        $rules = [
           'comment' => 'required'          
        ];
        $message = [
            'comment.required' => trans('forms.commentreqmsg')           
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }
      
        $commentresult = $this->storeTicketComment($request);
        if($commentresult) 
        {
           $request->session()->flash('successmessage', trans('forms.ticket_comment_success_message'));   
        } 
        else 
        {
            $request->session()->flash('failmessage', trans('forms.ticket_comment_failure_message'));   
        }
        return back();
    }

    public function download($id, $ticketid)
    {  
        $ticketdetails = $this->getTicketdetails($ticketid); 
        if ($ticketdetails->agent_id != Auth::id())
        {
            abort(404);
        }         
        $result = $this->downloadattachments($id);
        return $result;          
    }

}

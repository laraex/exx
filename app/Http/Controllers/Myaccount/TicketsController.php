<?php

namespace App\Http\Controllers\Myaccount;

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
use App\Http\Requests\TicketRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNotifyNewTicket;
use App\Mail\StaffNotifyTicket;
use App\Mail\UserSendTicket;

class TicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'member']);
    }
    use TicketProcess;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userprofile = Userprofile::where('user_id', Auth::id())->with('user')->first();  
        $result = $this->myticketlist($userprofile);        
        return view('tickets.showtickets', [
                    'result' => $result,
                    'userprofile' => $userprofile                
        ]);
    }

    public function support()
    {
        return view('tickets.support');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $priorities = TicketPriorities::get();
        $categories = TicketCategories::get();

        return view('tickets.createticket', [
                    'priorities' => $priorities,
                    'categories' => $categories,              
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketRequest $request)
    {
        $ticket = $this->makeTicket($request); 
        $this->makeTicketattachments($request, $ticket);      

        $admin = User::find(1);
        $user = User::where('id', $ticket->user_id)->first();
        $staff = User::where('id', $ticket->agent_id)->first();

        if($ticket) 
        {
            Mail::to($admin->email)->queue(new AdminNotifyNewTicket($ticket)); 
            Mail::to($staff->email)->queue(new StaffNotifyTicket($ticket));
            Mail::to($user->email)->queue(new UserSendTicket($ticket));
            $request->session()->flash('successmessage', trans('forms.ticket_success_message'));   
        } 
        else 
        {
            $request->session()->flash('failmessage', trans('forms.ticket_failure_message'));   
        }
        return Redirect::to('myaccount/ticket');
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

        if ($ticketdetails->user_id != Auth::id())
        {
            abort(404);
        } 

        return view('tickets.viewticket', [
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
       if($statusresult) 
        {
           $request->session()->flash('successmessage', trans('forms.ticket_status_success_message'));   
        } 
        else 
        {
            $request->session()->flash('failmessage', trans('forms.ticket_status_failure_message'));   
        }
        return Redirect::to('myaccount/ticket/'.$id);
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
           'comment'      => 'required'          
           ];
        $message = [
            'comment.required'      => trans('forms.commentreqmsg')           
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

        if ($ticketdetails->user_id != Auth::id())
        {
            abort(404);
        } 

        $result = $this->downloadattachments($id);
        return $result;
    }
}

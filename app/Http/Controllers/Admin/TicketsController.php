<?php

namespace App\Http\Controllers\Admin;
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
use App\Helpers\HyipHelper;
use Illuminate\Support\Facades\Mail;
use App\Mail\StaffNotifyTicketStatus;
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
        $this->middleware(['auth','admin1']);
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
        return view('admin.tickets.showtickets', [
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
    public function store(Request $request)
    {                     
        $rules = [
           'subject' => 'required',
           'description' => 'required'
        ];

        $message = [
            'subject.required' => trans('forms.subjectreqmsg'),
            'description.required' => trans('forms.descriptionreqmsg'),
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }

        $ticket = $this->makeTicket($request); 
        $ticketattachments = $this->makeTicketattachments($request, $ticket);      
    
        if($ticket && $ticketattachments) 
        {
           $message = trans('forms.ticket_success_message');
        } 
        else 
        {
            $message = trans('forms.ticket_failure_message');
        }
        return Redirect::to('myaccount/ticket')->with('status', $message);
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

        return view('admin.tickets.viewticket', [
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
        $staff = User::where('id', $statusresult->agent_id)->first();
        $user = User::where('id', $statusresult->user_id)->first();
        if($statusresult) 
        {
            Mail::to($staff->email)->queue(new StaffNotifyTicketStatus($statusresult)); 
            Mail::to($user->email)->queue(new UserNotifyTicketStatus($statusresult));
            $request->session()->flash('successmessage', trans('forms.ticket_status_success_message'));   
        } 
        else 
        {
            $request->session()->flash('failmessage', trans('forms.ticket_status_failure_message'));   
        }
        return Redirect::to('admin/ticket/'.$id);
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

    public function download($id)
    {
        $is_admin = HyipHelper::is_admin(Auth::id());
        //dd($is_admin);
        if ($is_admin)
        {           
            $result = $this->downloadattachments($id);
            return $result;
        }
        abort(404);        
    }
    
}

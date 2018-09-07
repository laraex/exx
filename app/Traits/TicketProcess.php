<?php 

namespace App\Traits;

use App\Models\Ticket;
use App\Models\TicketComments;
use App\Models\TicketCategoriesUsers;
use App\Models\TicketAttachment;
use Config;
use Response;
use File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


trait TicketProcess {

    public function myticketlist($userprofile) 
    {
        $ticketresult = Ticket::with('category', 'status', 'agent');

        if($userprofile->usergroup_id == 2)
        {
            $ticketresult  = $ticketresult->where('agent_id', Auth::id())->get();
        }
        elseif ($userprofile->usergroup_id == 3) 
        {
            $ticketresult  = $ticketresult->where('user_id', Auth::id())->paginate(Config::get('settings.pagecount'));
        }
        else
        {
            $ticketresult = $ticketresult->get();
        } 
        return $ticketresult;      
    } 

    public function getTicketdetails($id) 
    {
        $ticketdetails = Ticket::where('id', '=', $id)->with('user', 'category', 'priority', 'status', 'agent', 'attachments')->first();
        //dd($ticketdetails);

        return $ticketdetails;
    } 

    public function downloadattachments($id) 
    {
        $attachment = TicketAttachment::where('id', '=', $id)->first();
        $path=public_path('uploads/'.$attachment->attachment_file);
        $headers = array('Content-Type' => File::mimeType($path));        
        return response()->download($path, $attachment->attachment_file, $headers);  
    }   

    public function getCommentlists($id) 
    {
         $commentlists = TicketComments::where('ticket_id', '=', $id)->with('user')->paginate(Config::get('settings.pagecount'));
        //dd($commentlists);

        return $commentlists;
    }  

    public function storeTicketComment($request) 
    {
        
        $ticketcomment = new TicketComments;
        $ticketcomment->content = $request->comment; 
        $ticketcomment->user_id = Auth::id();  
        $ticketcomment->ticket_id = $request->ticket_id;     
        //$ticketcomment->save();

        if ($ticketcomment->save())
        {
            return $ticketcomment;
        }

        return FALSE;
    } 

    public function makeTicket($request)
    {
        $agent = TicketCategoriesUsers::where('category_id', '=', $request->category)->first(); 
        $ticket = new Ticket;
        $ticket->subject = $request->subject;
        $ticket->content = $request->description;
        $ticket->status_id = 1;
        $ticket->priority_id = $request->priority;
        $ticket->user_id = Auth::id();
        $ticket->agent_id = $agent->user_id;
        $ticket->category_id = $request->category;
        $ticket->save();
        return $ticket;
    }

    public function makeTicketattachments($request, $ticket)
    {
       
        $files = $request->attachments;
        // start count how many uploaded
        $uploadcount = 0;
        if( count($files) > 0)
        {
            foreach($files as $file) {
                $destinationPath = public_path("/uploads/");
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                $filerename = $filename.'_'.time().'.'.$extension;
                $upload_success = $file->move($destinationPath, $filerename);
                 $TicketAttachment = new TicketAttachment;
                        $TicketAttachment->attachment_file = $filerename;
                        $TicketAttachment->ticket_id = $ticket->id;
                        $TicketAttachment->save();
                $uploadcount ++;
              }

              if($uploadcount != count($files))
              {
                     $request->session()->flash('failmessage', trans('forms.ticket_failure_message'));   
                    return FALSE;
              }
        }        
    }

    public function updateStatus($statusid, $id) 
    {        
        $ticketstatus = Ticket::where('id', '=', $id)->first(); 
        $ticketstatus->status_id = $statusid; 

        if ($ticketstatus->save())
        {
            return $ticketstatus;
        }

        return FALSE;
    }  

    public function pendingticketlist($userprofile) 
    {
        $ticketresult = Ticket::where('status_id', 1)->with('category', 'status', 'agent');
        //dd($ticketresult);
        if($userprofile->usergroup_id == 2)
        {
            $ticketresult  = $ticketresult->where('agent_id', Auth::id())->get();
        }
        elseif ($userprofile->usergroup_id == 3) 
        {
            $ticketresult  = $ticketresult->where('user_id', Auth::id())->get();
        }
        else
        {
            $ticketresult = $ticketresult->orderby('created_at', 'desc')->take(10)->get();
        } 
        return $ticketresult;      
    }                    

 }
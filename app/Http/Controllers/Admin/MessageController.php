<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use App\Models\Userprofile;
use App\User;
use App\Http\Requests\MessageSendRequest;
use App\Http\Requests\MessageRequest;

class MessageController extends Controller
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



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conversations = Conversation::with(['userone', 'usertwo','message'])->latest()->get();
        //dd($conversations);
        // $message = Message::groupBy('conversation_id')
        //             ->with(['user', 'conversation'])
        //             ->latest()
        //             ->get();
        //dd($message);
        return view('admin.message.show', [
                        'conversations' => $conversations,
            ]);
    }  

    public function conversation($conversationid)
    {
         // echo $conversationid;
        // dd($messageid);
        $messages = Message::where('conversation_id', $conversationid)->with('conversation')->get();
        $participants = Conversation::where('id', $conversationid)->with(['userone', 'usertwo'])->first();
        $participantDetails = Userprofile::whereIn('id', [$participants->userone->id, $participants->usertwo->id])->get();
        //dd($participantDetails);
        //dd($participants);
        //dd($messages);
        foreach ($messages as $message)
        {
            $message = Message::where('id', $message->id )->first();
            $message->is_seen = '1';
            $message->save();       
        }
        return view('admin.message.view', [
                        'message' => $messages,
                        'conversationid' => $conversationid,
                        'participants' => $participants,
                        'participantDetails' => $participantDetails,
            ]);
    }

    public function conversationsave($conversationid, MessageSendRequest $request)
    {

        $message = new Message;
        $message->message = $request->message;
        $message->user_id = Auth::id();
        $message->conversation_id = $conversationid;
        if ($message->save())
        {
            $request->session()->flash('successmessage', trans('forms.message_success'));
        }
        else
        {
            $request->session()->flash('errormessage', trans('forms.message_failure'));
        }
        return \Redirect::back();
        //return \Redirect::to('admin/message/list');

    }

   
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userlist = Userprofile::where([
                ['active', 1],
                ['usergroup_id', 3]
            ])->with('user')->get();
        return view('admin.message.send',[
                'userlists' => $userlist
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageRequest $request)
    { 
        // dd('dfgd');  
        $user_two=User::where('name',$request->send_to)->first();
        $conversation = new Conversation;
        $conversation->user_one = Auth::id();
        //$conversation->user_two = $request->users;
        $conversation->user_two = $user_two->id;
        
        if ($conversation->save())
        {
            $message = new Message;
            $message->message = $request->message;
            $message->user_id = Auth::id();
            $message->conversation_id = $conversation->id;
            if ($message->save())
            {
                $request->session()->flash('successmessage', trans('forms.message_success'));
            }
            else
            {
                $request->session()->flash('errormessage', trans('forms.message_failure'));
            }
        }
        else
        {
            $request->session()->flash('errormessage', trans('forms.message_failure'));
        }
        $redirectpath = "admin/message/conversation/".$conversation->id;
        return \Redirect::to($redirectpath);
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

    public function quickmessage(Request $request)
    {   //dd($request);
        $user_two=User::where('name',$request->send_to)->first(); 
        $conversation = new Conversation;
        $conversation->user_one = Auth::id();
       // $conversation->user_two = $request->users;
        $conversation->user_two = $user_two->id;
        if ($conversation->save())
        {
            $message = new Message;
            $message->message = $request->message;
            $message->user_id = Auth::id();
            $message->conversation_id = $conversation->id;
            if ($message->save())
            {
                $request->session()->flash('success', trans('forms.message_view'));
            }
        }
        else
        {
            $request->session()->flash('error', trans('forms.message_failure'));
        }
        $redirectpath = "admin/dashboard";
        return \Redirect::to($redirectpath);
    }
   
}

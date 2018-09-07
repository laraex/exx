<?php

namespace App\Http\Controllers\Myaccount;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Userprofile;
use Gate;
use App\Http\Requests\MessageSendRequest;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'member']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $message = Message::join('conversations', 'messages.conversation_id', '=', 'conversations.id')
        //     ->select('messages.*', 'conversations.*')
        //     ->where('conversations.user_one', Auth::id())
        //     ->orWhere('conversations.user_two', Auth::id())
        //     ->groupBy('conversation_id')
        //     ->paginate(\Config::get('settings.pagecount')); 
       
        $message = Conversation::where('user_two', Auth::id())->orWhere('user_one', Auth::id())->with(['userone', 'usertwo','message'])->latest()->get();  
        //dd($message);
        return view('message.show', [
                'messages' => $message,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('message.send');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageSendRequest $request)
    {
        $conversation = new Conversation;
        $conversation->user_one = Auth::id();
        $conversation->user_two = 1;
        $conversation->status = 0;
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
                $request->session()->flash('failmessage', trans('forms.message_failure'));
            }
        }
        else
        {
            $request->session()->flash('failmessage', trans('forms.message_failure'));
        }
        return \Redirect::to('myaccount/message/list');
    }

    public function conversation($conversationid)
    {
        //dd($conversationid);

        $messages = Message::where('conversation_id', $conversationid)->with('conversation')->get();
        $participants = Conversation::where('id', $conversationid)->with(['userone', 'usertwo'])->first();

        $conversations = Conversation::find($conversationid);
        
        if(count($conversations)==0)
        {
            abort(403);
        }

         if (Gate::denies('view-messages',$conversations)) {
            abort(403);
        }

        foreach ($messages as $message)
        {
            $message = Message::where('id', $message->id )->first();
            $message->is_seen = '1';
            $message->save();       
        }

        return view('message.view', [
                        'message' => $messages,
                        'conversationid' => $conversationid,
                        'participants' => $participants,
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
            $request->session()->flash('failmessage', trans('forms.message_failure'));
        }
        return \Redirect::to('myaccount/message/list');

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

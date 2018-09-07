 @if (count($message))
 <div class="bgd-box-round message-box">
        @foreach($message as $data)
         
         @if ($data->conversation->user_one == $data['user_id'])
         <p class={{ $data['user_id']==1 ? "message-bubble-text-left" : "message-bubble-text-right"}}><small><strong>{{ ucfirst($participants->userone->name) }}</strong></small>: <br/> {{ $data->message }} <br/><small>{{ $data->created_at->diffForHumans() }}</small></p><br/>
         @endif

        @if ($data->conversation->user_two == $data['user_id'])
         <p class={{ $data['user_id']==1 ? "message-bubble-text-left" : "message-bubble-text-right"}}><small><strong>{{ ucfirst($participants->usertwo->name) }}</strong></small>: <br/>{{ $data->message }} <br/><small>{{ $data->created_at->diffForHumans() }}</small></p><br/>
         @endif

         @endforeach
</div>
<div class="bgd-box-round p-20">
         @include('message.conversation_form')
 </div>
@endif   
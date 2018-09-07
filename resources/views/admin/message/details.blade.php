 @if (count($message))
 	<div class="conversation-flex">
 		<div class="converstaion-area">
        @foreach($message as $data)
         
         @if ($data->conversation->user_one == $data['user_id'])
         <p class={{ $data['user_id']==1 ? "message-bubble-text-right" : "message-bubble-text-left"}}><small><strong>{{ ucfirst($participants->userone->name) }}</strong></small>: <br/> {!! $data['message'] !!} <br/><small>{{ $data->created_at->diffForHumans() }}</small></p><br/>
         @endif

        @if ($data->conversation->user_two == $data['user_id'])
         <p class={{ $data['user_id']==1 ? "message-bubble-text-right" : "message-bubble-text-left"}}><small><strong>{{ ucfirst($participants->usertwo->name) }}</strong></small>: <br/>{!! $data['message'] !!} <br/><small>{{ $data->created_at->diffForHumans() }}</small></p><br/>
         @endif

         @endforeach
     	</div>
     	<div class="converstaion-form-area">
         @include('partials.message')
         @include('admin.message.conversation_form')
     	</div>
    </div>
@endif   
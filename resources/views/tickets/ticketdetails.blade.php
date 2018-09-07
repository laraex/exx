<div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
<p> <strong>{{ trans('forms.owner') }}</strong>: 
                    {{ $ticketdetails->user->name }}</p>
 <p> <strong>{{ trans('forms.status') }}</strong>: 
                    <span style="color:  {{ $ticketdetails->status->color }} ">{{ $ticketdetails->status->name }}</span> </p>
 <p><strong>{{ trans('forms.priority') }}</strong>: 
                       <span style="color: {{ $ticketdetails->priority->color }}">{{ $ticketdetails->priority->name }}    </span></p>
<p> <strong>{{ trans('forms.responsible') }}</strong>: 
            {{ $ticketdetails->agent->name }}</p>
<p> <strong>{{ trans('forms.category') }}</strong>: 
              <span style="color: {{ $ticketdetails->category->color }}">  {{ $ticketdetails->category->name }}</span></p>
 <p> <strong>{{ trans('forms.created') }}</strong>: {{ $ticketdetails->created_at->diffForHumans() }}</p> 
 <p> <strong>{{ trans('forms.lastupdated') }}</strong>: {{ $ticketdetails->updated_at->diffForHumans() }}</p>          
</div>

<div class="attachments">
            @if (count($ticketdetails->attachments))
             <div class="panel well well-sm">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <p> {{ trans('forms.attachments') }}:
                            </p>
                        </div>
                        <div class="col-md-9">
                        @foreach ($ticketdetails->attachments as $data)
                            <p>
                            @if ( $userprofile->usergroup_id == 3 )
                            <a href="{{ url('/myaccount/ticket/download/'.$data['id'].'/'.$data['ticket_id']) }}">{{ $data['attachment_file'] }}</a>
                            @elseif ( $userprofile->usergroup_id == 2 )
                            <a href="{{ url('/staff/ticket/download/'.$data['id'].'/'.$data['ticket_id']) }}">{{ $data['attachment_file'] }}</a>
                            @elseif ( $userprofile->usergroup_id == 1 )
                            <a href="{{ url('/admin/ticket/download/'.$data['id']) }}">{{ $data['attachment_file'] }}</a>
                            @endif
                            </p>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
</div>

<div class="ticket-message mt-20 mb-20">
<h3>{{ $ticketdetails->subject }}</h3>
<p>{!! $ticketdetails->content !!}</p> 
</div>
<hr>
<div class="ticket-comments">
<h4>Comments</h4>
        @if (count($commentlists))
                @include('tickets.commentslist')
        @endif   
</div>
<hr>
<div class="ticket-reply-form">
           @include('tickets.replyform')
</div>

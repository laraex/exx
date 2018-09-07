<div class="panel-body">
        <div class="content">
 
            <div class="panel well well-sm">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <p> <strong>{{ trans('forms.owner') }}</strong>: {{ $ticketdetails->user->name }}</p>
                            <p>
                                <strong>{{ trans('forms.status') }}</strong>: 
                                                                    <span style="color:  {{ $ticketdetails->status->color }} ">{{ $ticketdetails->status->name }}</span>
                                
                            </p>
                            <p>
                                <strong>{{ trans('forms.priority') }}</strong>: 
                                <span style="color: {{ $ticketdetails->priority->color }}">
                                    {{ $ticketdetails->priority->name }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p> <strong>{{ trans('forms.responsible') }}</strong>: {{ $ticketdetails->agent->name }}</p>
                            <p>
                                <strong>{{ trans('forms.category') }}</strong>: 
                                <span style="color: {{ $ticketdetails->category->color }}">
                                    {{ $ticketdetails->category->name }}
                                </span>
                            </p>
                            <p> <strong>{{ trans('forms.created') }}</strong>: {{ $ticketdetails->created_at->diffForHumans() }}</p>
                            <p> <strong>{{ trans('forms.lastupdated') }}</strong>: {{ $ticketdetails->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>

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
                            <a href="{{ url('/staff/ticket/download/'.$data['id'].'/'.$data['ticket_id']) }}">{{ $data['attachment_file'] }}</a>                            
                            </p>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="col-md-12">
                <p>{{ rawurldecode($ticketdetails->content) }}</p> 
            </div>
        </div>        
    </div>

@if (count($commentlists))
<div class="panel-heading">Comments</div>

 @include('tickets.commentslist')

@endif   

    <div class="panel-body">

           @include('tickets.replyform')
       
    </div>

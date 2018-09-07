<div class="p-20">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>{{ trans('forms.from') }}</th>
            <th>{{ trans('forms.to') }}</th>
            <th>{{ trans('forms.message') }}</th>
            <th>{{ trans('forms.createdon') }}</th> 
            <th>{{ trans('forms.lastreplyby') }}</th>   
            <th>{{ trans('forms.lastreplyon') }}</th>  
        </tr>
    </thead>
    @if (count($messages))
        @foreach($messages as $data)
        <tbody>
            <td>{{ $data->userone->name }}</td>
            <td>{{ $data->usertwo->name }}</td>
            <td> 
                <a href="{{ url('myaccount/message/conversation/'.$data['id']) }}">
                    <p> {!! $data->message->first()->message !!}  
                        <span class="label label-info"> - {{ $data->message->count() }}</span>
                        @if( $data->message->last()->is_seen == 0 )
                            <span class="label label-success"> New </span>
                        @endif
                    </p>
                </a> 
            </td>
            <td>{{ $data->created_at->diffForHumans() }}</td>
            <td>{{ $data->message->last()->user->name }}</td>
            <td>{{ $data->message->last()->created_at->diffForHumans() }}</td>
        </tbody>
        @endforeach
    @else
    <tbody>
        <td colspan="6">
            {{ trans('forms.nomessagefound') }}
        </td>
    </tbody>
    @endif
</table>
 </div>
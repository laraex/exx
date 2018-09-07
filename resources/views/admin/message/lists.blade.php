<table class="table table-bordered" id="messagelist">
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
    
        @foreach($conversations as $data)
         <tbody>
            <td><a href="{{ url('admin/users/'.$data->user_one) }}">{{ $data->userone->name }}</a></td>
            <td>
                  <a href="{{ url('admin/users/'.$data->user_two) }}"> {{ $data->usertwo->name }}</a>
            </td>
            <td>
                <a href="{{ url('admin/message/conversation/'.$data['id']) }}">
                   <p> {!! $data->message->first()->message !!} 
                    <span class="label label-info"> {{ $data->message->count() }}</span>
                      @if( $data->message->last()->is_seen == 0 )   <span class="label label-success"> New </span>
                     @endif
                    </p>
                </a>
              

            </td>
            <td>{{ $data->created_at->diffForHumans() }}</td>
            <td>
                <a href="{{ url('admin/users/'.$data->message->last()->user_id) }}">
                {{ $data->message->last()->user->name }}</a>
            </td>
            <td>{{ $data->message->last()->created_at->diffForHumans() }}</td>
            
        </tbody>
         @endforeach
    

 </table>

@include('admin.datatable')

  @push('scripts')
<script>
    $(document).ready(function(){
        $('#messagelist').DataTable();

          
    });

</script>
@endpush

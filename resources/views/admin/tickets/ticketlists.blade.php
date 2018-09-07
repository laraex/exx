<table class="table table-bordered" id="ticketdatatable">
    <thead>
        <tr>
             <th>Owner</th> 
            <th>Subject</th>
            <th>Status</th> 
            <th>Agent</th>
            <th>Created On</th>   
            <th>Last Updated On</th> 
        </tr>
    </thead>
    
     @if (count($result))
        @foreach($result as $data)
         <tbody>
            <td width="7%">            
            
                @if (is_null($data->user))
                {{ 'system' }}
                @else
                <a href="{{ url('admin/users/'.$data->user->id) }}">{{ $data->user->name }}</a>
                @endif

            </td>           
            <td width="50%">               
                <a href="{{ url('admin/ticket/'.$data['id']) }}">               
                    {{ $data['subject'] }}
                </a>
            </td>           
            <td width="13%">{{ $data->status->name }}</td>
            @if ($userprofile->usergroup_id != 3) 
            <td width="10%">{{ $data->agent->name }}</td>
            @endif
            <td width="10%">{{ $data->created_at->format('d/m/Y H:i:s') }}</td>
            <td width="10%">{{ $data->updated_at->format('d/m/Y H:i:s') }}</td>
        </tbody>
         @endforeach
    @else
     <tbody>
        <td colspan="6">
            {{ trans('forms.noticketsfound') }}
        </td>
    </tbody>
    @endif

 </table>


 @include('admin.datatable')

 @push('scripts')
<script>
    $(document).ready(function(){
        $('#ticketdatatable').DataTable();
    });
</script>
@endpush
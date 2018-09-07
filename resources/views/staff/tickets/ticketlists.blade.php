<table class="table table-bordered" id="ticketdatatable">
    <thead>
    <tr>
         <th>{{ trans('forms.owner') }}</th> 
        <th>{{ trans('forms.subject') }}</th>
        <th>{{ trans('forms.status') }}</th>       
        <th>{{ trans('forms.createdon') }}</th> 
        <th>{{ trans('forms.lastupdated') }}</th>      
              
       
    </tr>
    </thead>
        @foreach($result as $data)
         <tbody>        
            <td> 
            {{ $data->user->name }}            
            </td>
            <td>               
                <a href="{{ url('staff/ticket/'.$data['id']) }}">               
                    {{ $data['subject'] }}
                </a>
            </td>           
            <td>{{ $data->status->name }}</td>
             <td>{{ $data->created_at->format('d/m/Y H:i:s') }}</td>
            <td>{{ $data->updated_at->format('d/m/Y H:i:s') }}</td>
        </tbody>
         @endforeach  

 </table>
 @push('scripts')
<script>
    $(document).ready(function(){
        $('#ticketdatatable').DataTable();
    });
</script>
@endpush
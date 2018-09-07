<table class="table table-bordered">
    <thead>
    <tr>  
        <th>{{ trans('forms.subject') }}</th>
        <th>{{ trans('forms.status') }}</th> 
        <th>{{ trans('forms.agent') }}</th>
        <th>{{ trans('forms.createdon') }}</th> 
        <th>{{ trans('forms.lastupdated') }}</th>           
    </tr>
    </thead>
    
     @if (count($result))
        @foreach($result as $data)
         <tbody>          
            <td width="50%">
               <a href="{{ url('myaccount/ticket/'.$data['id']) }}">              
                    {{ $data['subject'] }}
                </a>
            </td>           
            <td>{{ $data->status->name }}</td>
            <td>{{ $data->agent->name }}</td>
             <td>{{ $data->created_at->format('d/m/Y H:i:s') }}</td>
            <td>{{ $data->updated_at->format('d/m/Y H:i:s') }}</td>
        </tbody>
         @endforeach
    @else
     <tbody>
        <td colspan="5">
            {{ trans('forms.noticketsfound') }}
        </td>
    </tbody>
    @endif

 </table>
 {{ $result->links() }}
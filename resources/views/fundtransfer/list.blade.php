<table class="table table-bordered">
    <thead>
    <tr>
        @if ($type == 'send')
            <th>{{ trans('myaccount.receiver') }}</th> 
        @elseif ($type == 'received') 
            <th>{{ trans('myaccount.sender') }}</th>
        @endif    
            <th>{{ trans('myaccount.amount') }} </th>  
            <th>{{ trans('myaccount.transaction_id') }}</th>       
            <th>{{ trans('myaccount.send_date') }}</th>
        
               
    </tr>
    </thead>
    <tbody>
    @if (count($transferlists) > 0)
        @foreach($transferlists as $data)

        <tr>
            @if ($type == 'send')
            <td>{{ $data->present()->getUsername($data->fundtransfer_to_id->user_id) }}</td>
             @elseif ($type == 'received') 
             <td>{{ $data->present()->getUsername($data->fundtransfer_from_id->user_id) }}</td>
             @endif 
            <td>{{ $data->amount }} </td> 
            <td>{{ $data->transaction_id }} </td> 
            <td>{{ $data->created_at->format('d/m/Y H:i:s') }}</td>           
            
        </tr>

         @endforeach
     @else
        <tr>
                
            <td colspan="6">{{ trans('forms.no_fundtransfer_found') }}</td>
               
       </tr>
    @endif
    </tbody>

 </table>

 {{ $transferlists->links() }}

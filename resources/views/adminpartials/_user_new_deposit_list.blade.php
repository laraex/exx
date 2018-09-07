<div class="tab-container">
<h3>{{ trans('admin_user.new_deposit') }} </h3>
<table class="table table-bordered" id="newdepositdatatable">
    <thead>
    <tr>
        <th>{{ trans('admin_user.amt') }}</th>
        <th>{{ trans('admin_user.account_id') }}</th> 
        <th>{{ trans('admin_user.payment') }}</th>
        <th>{{ trans('admin_user.transaction_id') }}</th>    
        <th>{{ trans('admin_user.date') }}</th>       
    </tr>
    </thead>
    <tbody>
        @foreach($newdepositlist as $data)  
        @php 
            $request = json_decode($data['request'], true); 
            $response = json_decode($data['response'], true); 
        @endphp       
        <tr>
            <td>{{ $data->amount }} {{ $data->present()->getCurrencyName($data->account_id) }}</td>
            <td>{{ $data->present()->getTransactionAccountName($data->account_id) }}</td>
            <td>
            {{ $data->present()->getTransactionPaymentName($request['payment_id']) }}
            </td>
            <td>{{ $response['transaction_number'] }}</td>
            <td>{{ $data->created_at->format('d/m/Y H:i:s') }}</td>
        </tr>
         @endforeach
    </tbody>
</table>
 </div>

 @push('scripts')
<script>
    $(document).ready(function()
    {
        $('#newdepositdatatable').DataTable();

    });
     
</script>
@endpush
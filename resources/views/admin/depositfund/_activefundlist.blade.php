<a href="{{ url('admin/exportfund') }}" class="btn btn-success pull-right">{{ trans('export.exports') }}</a>
<br>
<div class="mt-20 mb-20">
<table class="table table-bordered table-striped dataTable"  id="logdatatable">
<thead>
    <tr>        
        <th>{{ trans('admin_fund.username') }}</th>
        <th>{{ trans('admin_fund.amt') }}</th> 
        <th>{{ trans('admin_fund.ac_name') }}</th>       
        <th>{{ trans('admin_fund.payment_method') }}</th> 
        <th>{{ trans('admin_fund.transaction_id') }}</th>                          
        <th>{{ trans('admin_fund.date') }}</th>
    </tr>
</thead>
<tbody>
@foreach($activefundlists as $data)
@php 
    $request = json_decode($data['request'], true); 
    $response = json_decode($data['response'], true); 

@endphp
    <tr>
        <td>
          <a href="{{ url('admin/users/'.$data->user_id) }}">
          {{ $data->user->name }}
            </a>
        </td>
        <td>{{ $data->amount }} {{ $data->currency->token }}</td>
        <td>{{ $data->present()->getAccountNo($data->user_id,$data->currency_id) }}</td>
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

@include('admin.datatable')

@push('scripts')
<script>
    $(document).ready(function(){
        $('#logdatatable').DataTable();
    });
</script>
@endpush
<div class="mt-20 mb-20">
<table class="table table-bordered table-striped dataTable"  id="addedfunddatatable">
<thead>
    <tr>
        <th>{{ trans('admin_action.username') }}</th>
        <th>{{ trans('admin_action.amt') }}</th> 
        <th>{{ trans('admin_action.from_account') }}</th> 
        <th>{{ trans('admin_action.payment_method') }}</th>
        <th>{{ trans('admin_action.to_account') }} </th>
        <th>{{ trans('admin_action.transaction_id') }}</th>                   
        <th>{{ trans('admin_action.date') }}</th>
        <th>{{ trans('admin_action.action') }}</th>
    </tr>
</thead>
<tbody>
@foreach($pendingdepositfunds as $data)
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
        <td>{!! $data->present()->getDepositDetails($data) !!}</td>
        <td>
        {{ $data->present()->getTransactionPaymentName($request['user']['payment_id']) }}
        </td>
         @if(count($request)>2)
         <td>
         Bank Name: {{ $request['bank_name'] }} <br/>
         Account No: {{ $request['account_no'] }} <br/>
         Swift Code: {{ $request['swift_code'] }} <br/>
         Account Type: {{ $request['account_type'] }} <br/>
         Bank Address: {{ $request['bank_address'] }} <br/>
        </td>
        @else
        <td>--</td>
        @endif

        <td>{{ $response['transaction_number'] }}</td>
        <td>{{ $data->created_at->format('d/m/Y H:i:s') }}</td>
        <td>
            <a href="{{ url('admin/depositfund/confirm/'.$data->id) }}" class="btn btn-success btn-xs flex-button" onclick="return (confirm('{{ trans("admin_action.approve_deposit")}}'))">{{ trans('admin_action.confirm') }}</a>
            <a href="{{ url('admin/depositfund/reject/'.$data->id) }}" class="btn btn-info btn-xs flex-button" onclick="return (confirm('{{ trans("admin_action.approve_reject")}}'))">{{ trans('admin_action.reject') }}</a>                          
        </td>
    </tr>

 @endforeach
</tbody>
</table>

</div>

@include('admin.datatable')

@push('scripts')
<script>
    $(document).ready(function(){
        $('#addedfunddatatable').DataTable();
    });
</script>
@endpush
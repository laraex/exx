<table class="table table-bordered table-striped dataTable"  id="exchangedatatable">
<thead>
     <tr>
        <th>{{ trans('admin_exchange.username') }}</th>
        <th>{{ trans('admin_exchange.from_ac') }}</th>
        <th>{{ trans('admin_exchange.from_amt') }}</th>
        <th>{{ trans('admin_exchange.ex_ac') }}</th>
        <th>{{ trans('admin_exchange.ex_amt') }}</th>
        <th>{{ trans('admin_exchange.created_on') }}</th>
    </tr>
</thead>
<tbody>
 @foreach($exchanges as $exchange)
    <tr>
        <td>
            <a href="{{ url('admin/users/'.$exchange->user->id) }}">{{ $exchange->user->name }}</a>
        </td>

         <td>{{ $exchange->exchange_from_account->account_no }}</td>

         <td>{{ $exchange->from_amount }} {{ $exchange->present()->getCurrencyName($exchange->from_currency_account) }}</td>

         <td>{{ $exchange->exchange_to_account->account_no }}</td>

         <td>{{ $exchange->to_amount }} {{ $exchange->present()->getCurrencyName($exchange->to_currency_account) }}</td>
      
        <td>{{ $exchange->created_at }}</td>
        
    </tr>
      
    
    @endforeach
</tbody>
</table>

@include('admin.datatable')



@push('scripts')
<script>
$(document).ready(function(){
        $('#exchangedatatable').DataTable();    

});
</script>
@endpush
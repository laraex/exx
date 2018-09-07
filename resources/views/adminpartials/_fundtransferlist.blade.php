
<table class="table table-bordered table-striped dataTable"  id="funddatatable">
<thead>
    <tr>        
        <th>{{ trans('admin_fundtransfer.amt') }}</th>
        <th>{{ trans('admin_fundtransfer.send') }}</th>
        <th>{{ trans('admin_fundtransfer.receive') }}</th>
        <th>{{ trans('admin_fundtransfer.transaction_id') }}</th> 
        <th>{{ trans('admin_fundtransfer.date') }}</th>      
    </tr>
</thead>
<tbody>
@foreach($fundtransfer as $data)

    <tr>
        <td>
            {{ $data->amount }} {{ $data->present()->getCurrencyName($data->to_account_id) }}
        </td>
        <td>
            <a href="{{ url('admin/users/'.$data->fundtransfer_from_id->user_id) }}">{{ ucfirst($data->present()->getUsername($data->fundtransfer_from_id->user_id)) }}</a>
        </td>
        <td>
            <a href="{{ url('admin/users/'.$data->fundtransfer_to_id->user_id) }}">{{ ucfirst($data->present()->getUsername($data->fundtransfer_to_id->user_id)) }}</a>
        </td>
        <td> {{ $data->transaction_id }} </td>
        <td>
            {{ $data->created_at->format('d/m/Y H:i:s') }}
        </td>       
    </tr>
 @endforeach
</tbody>
</table>

@include('admin.datatable')

@push('scripts')
<script>
    $(document).ready(function(){
        $('#funddatatable').DataTable();
    });
</script>
@endpush
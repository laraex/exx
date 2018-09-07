<table class="table table-bordered" id="pendingdatatable">
    <thead>
    <tr>
        <th>{{ trans('admin_withdraw.username') }}</th> 
        <th>{{ trans('admin_withdraw.amount') }} ({{ config::get('settings.currency') }})</th> 
        <th>{{ trans('admin_withdraw.payment') }}</th>
        <th>{{ trans('admin_withdraw.request_date') }}</th>
        <th>{{ trans('admin_withdraw.action') }}</th>  
       
    </tr>
    </thead>
    <tbody>
        @foreach($withdrawlists as $data)           
        <tr>
            <td><a href="{{ url('admin/users/'.$data->user->id) }}">{{ $data->user->name }}</a></td>
            <td>{{ $data->amount }} {{ $data->userpayaccounts->paymentgateways->currency->name}}</td>
            <td>@include('adminpartials._popoveruserpayaccounts')</td>
            <td>{{ $data->created_at->format('d/m/Y H:i:s') }}</td>
            <td>
                 <a id="completed" href="{{ url('admin/withdraw/complete/'.$data['id'].'') }}" class="btn btn-success btn-xs" onclick="return (confirm('{{ trans("admin_withdraw.approve_withdraw")}}'))">{{ trans('admin_withdraw.approve') }}</a>
                 
                <a id="rejected" href="{{ url('admin/withdraw/reject/'.$data['id'].'') }}" class="btn btn-danger btn-xs" onclick="return (confirm('{{ trans("admin_withdraw.reject_withdraw")}}'))">{{ trans('admin_withdraw.reject') }}</a>
            </td>            
        </tr>
         @endforeach
    </tbody>

 </table>

 @include('admin.datatable')

 @push('scripts')
<script>
    $(document).ready(function(){
        $('#pendingdatatable').DataTable();

          $('[data-toggle="popover"]').popover({
        placement : 'top',
        trigger : 'hover'
    });
    });
   
</script>
@endpush
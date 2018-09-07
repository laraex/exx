<div class="tab-container">
<h3>{{ trans('admin_user.withdraw_list') }}</h3>
<table class="table table-bordered" id="pendingdatatable">
    <thead>
    <tr>
        <th>{{ trans('admin_user.amt') }}</th> 
        <th>{{ trans('admin_user.payment') }}</th>
        <th>{{ trans('admin_user.req_date') }}</th>
        <th>{{ trans('admin_user.action') }}</th>  
       
    </tr>
    </thead>
    <tbody>
        @foreach($pendingwithdraws as $data)         
        <tr>
            <td>{{ $data->amount }} {{ $data->userpayaccounts->paymentgateways->currency->name}}</td>
            <td>@include('adminpartials._popoveruserpayaccounts')</td>
            <td>{{ $data->created_at->format('d/m/Y H:i:s') }}</td>
            <td>
                 <a id="completed" href="{{ url('admin/withdraw/complete/'.$data['id'].'') }}" class="btn btn-success btn-xs">{{ trans('admin_user.complete') }}</a>
                 
                <a id="rejected" href="{{ url('admin/withdraw/reject/'.$data['id'].'') }}" class="btn btn-danger btn-xs">{{ trans('admin_user.reject') }}</a>
            </td>            
        </tr>
         @endforeach
    </tbody>
</table>
 </div>

 @push('scripts')
<script>
    $(document).ready(function(){
        $('#pendingdatatable').DataTable();

    });
     $("#completed").on("click", function()
     {
        return confirm("{{ trans('admin_user.complete_withdraw') }}");
    });
     $("#rejected").on("click", function()
     {
        return confirm("{{ trans('admin_user.reject_withdraw') }}");
    });
</script>
@endpush
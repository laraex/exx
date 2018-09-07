<div class="tab-container">
<h3>{{ trans('admin_user.withdraw_complete_list') }}</h3>
<table class="table table-bordered" id="completeddatatable">
    <thead>
    <tr>
        <th>{{ trans('admin_user.amt') }}</th> 
        <th>{{ trans('admin_user.payment') }}</th>
        <th>{{ trans('admin_user.comments') }}</th>
        <th>{{ trans('admin_user.complete_date') }}</th>      
    </tr>
    </thead>
    
        @foreach($completedwithdraws as $data)         
        <tr>
            <td>{{ $data->amount }} {{ $data->userpayaccounts->paymentgateways->currency->name}}</td>
            <td>@include('adminpartials._popoveruserpayaccounts')</span></td>
            <td>{{ $data->comments_on_complete }}</td>
            <td>{{ $data->completed_on }}</td>            
        </tr>
         @endforeach

 </table>
</div>
 @push('scripts')
<script>
    $(document).ready(function()
    {
        $('#completeddatatable').DataTable();    
});
</script>
@endpush
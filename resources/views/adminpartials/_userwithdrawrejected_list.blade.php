<div class="tab-container">
<h3>{{ trans('admin_user.withdraw_reject_list') }}</h3>
<table class="table table-bordered" id="rejecteddatatable">
    <thead>
    <tr>
        <th>{{ trans('admin_user.amt') }}</th> 
        <th>{{ trans('admin_user.payment') }}</th>
        <th>{{ trans('admin_user.comments') }}</th>
        <th>{{ trans('admin_user.complete_date') }}</th>
      
    </tr>
    </thead>
    
        @foreach($rejectedwithdraws as $data)             
        <tr>
            <td>{{ $data->amount }} {{ $data->userpayaccounts->paymentgateways->currency->name}}</td>
            <td>@include('adminpartials._popoveruserpayaccounts')</td>
            <td>{{ $data->comments_on_rejected }}</td>  
            <td>{{ $data->rejected_on }}</td>
                      
        </tr>
         @endforeach
  

 </table>
</div>
 @push('scripts')
<script>
    $(document).ready(function(){
        $('#rejecteddatatable').DataTable();

    });
</script>
@endpush
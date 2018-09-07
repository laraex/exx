<table class="table table-bordered" id="completeddatatable">
    <thead>
    <tr>
         <th>{{ trans('admin_withdraw.username') }}</th> 
        <th>{{ trans('admin_withdraw.amount') }}</th> 
        <th>{{ trans('admin_withdraw.payment') }}</th>
        <th>{{ trans('admin_withdraw.comments') }}</th> 
        <th>{{ trans('admin_withdraw.completed_date') }}</th>      
       
    </tr>
    </thead>
    
        @foreach($withdrawlists as $data)       
        <tr>
            <td><a href="{{ url('admin/users/'.$data->user->id) }}">{{ $data->user->name }}</a></td>
            <td>{{ $data->amount }} {{ $data->userpayaccounts->paymentgateways->currency->name}}
           </td>
            <td>@include('adminpartials._popoveruserpayaccounts')</td>
            <td>{{ $data->comments_on_complete }}</td>
            <td>{{ $data->completed_on->format('d/m/Y H:i:s') }}</td>            
        </tr>
         @endforeach

 </table>

 @include('admin.datatable')

 @push('scripts')
<script>
    $(document).ready(function(){
        $('#completeddatatable').DataTable();

          $('[data-toggle="popover"]').popover({
        placement : 'top',
        trigger : 'hover'
    });
    });

</script>
@endpush
<table class="table table-bordered">
    <thead>
    <tr>
        <th>{{ trans('myaccount.amount') }}</th>     
        <th>{{ trans('myaccount.payment') }}</th>        
        <th>{{ trans('myaccount.request_date') }}</th>  
        
    </tr>
    </thead>
    <tbody>
    @if (count($withdrawlists) > 0)
        @foreach($withdrawlists as $data)        
        <tr>
            <td>{{ $data->amount }} 
            @unless(is_null($data->transaction))
            {{ $data->transaction->present()->getCurrencyName($data->transaction->account_id) }}
            @endunless
            </td> 
            <td>@include('withdraw.popoveruserpayaccounts')</td>            
            <td>{{ $data->created_at->format('d/m/Y H:i:s') }}</td> 
        </tr>
         @endforeach
 @else
    <tr>
     
            <td colspan="4">{{ trans('myaccount.nowithdraws') }}</td>
   </tr>
@endif
    </tbody>

 </table>
{{ $withdrawlists->links() }}
@push('bottomscripts')
<script>
  $(document).ready(function(){
    $('[data-toggle="popover"]').popover({
        placement : 'top',
        trigger : 'hover'
    });
});
</script>
@endpush
<table class="table table-bordered">
    <thead>
    <tr>
        <th>{{ trans('myaccount.amount') }} </th> 
        <th>{{ trans('myaccount.request_date') }}</th>    
        <th>{{ trans('myaccount.payment') }}</th>   
        <th>{{ trans('myaccount.comments') }} ({{ trans('myaccount.hover_content') }})</th>
        <th>{{ trans('myaccount.rejected_date') }}</th>        
    </tr>
    </thead>
    <tbody>
    @if (count($withdrawlists) > 0)
        @foreach($withdrawlists as $data)        
        <tr>
            <td>{{ $data->amount }} {{ $data->transaction->present()->getCurrencyName($data->transaction->account_id) }}</td>
            <td>{{ $data->created_at->format('d/m/Y H:i:s') }}</td> 
            <td>@include('withdraw.popoveruserpayaccounts')</td>          
            <td><span data-html="true" data-toggle="comment-popover"  data-content="{{ $data->comments_on_rejected }}">{{  substr($data->comments_on_rejected, 0, 15) }}...</span></td>  
            <td>{{ $data->rejected_on }}</td>          

        </tr>
         @endforeach
 @else
    <tr>
            <td colspan="5">{{ trans('myaccount.nowithdraws') }}</td>  
          
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

    $('[data-toggle="comment-popover"]').popover({
        placement : 'top',
        trigger : 'hover'
    });
});
</script>
@endpush
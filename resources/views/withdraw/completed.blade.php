<table class="table table-bordered">
    <thead>
    <tr>
        <th>{{ trans('myaccount.amount') }} </th>
        <th>{{ trans('myaccount.request_date') }}</th>      
        <th>{{ trans('myaccount.payment') }}</th>  
        <th>{{ trans('myaccount.bitcoin_details') }}</th>    
        <th>{{ trans('myaccount.transaction_number') }}</th>
        <th>{{ trans('myaccount.comments') }} ({{ trans('myaccount.hover_content') }})</th>
        <th>{{ trans('myaccount.completed_date') }}</th>          
               
    </tr>
    </thead>
    <tbody>
    @if (count($withdrawlists) > 0)
        @foreach($withdrawlists as $data)
        @php
        $response = json_decode($data->transaction->response, true);
        @endphp
        <tr>
            <td>{{ $data->amount }} {{ $data->transaction->present()->getCurrencyName($data->transaction->account_id) }}</td> 
            <td>{{ $data->created_at->format('d/m/Y H:i:s') }}</td>
            <td>@include('withdraw.popoveruserpayaccounts')</td>
            @if ($data->userpayaccounts->paymentgateways_id == 9)
            <td><a class='bitcoin' href="#" data-toggle='modal' data-target1='{{ $data->id }}'>View Details</a></td>
            @else
            <td>-</td>
            @endif            
            <td>{{ $response['transaction_number'] }}</td>
            <td><span data-html="true" data-toggle="comment-popover"  data-content="{{ $data->comments_on_complete }}">{{  substr($data->comments_on_complete, 0, 15) }}...</span></td>
            <td>{{ $data->completed_on }}</td>
        </tr>
         @endforeach
 @else
    <tr>
            
                <td colspan="7">{{ trans('myaccount.nowithdraws') }}</td>
           
   </tr>
@endif
    </tbody>
 </table>
 <div class="modal fade" id="bitcoin-modals" role="dialog"></div>
{{ $withdrawlists->links() }}
@push('bottomscripts')
<script>
$('.bitcoin').on('click', function () {
            var $this = $(this).data('target1');

            $('#bitcoin-modals').load('viewbitcoinwallet/' + $this, function (response, status, xhr) {

                if (status == "success") {
                    $(response).modal('show');
                }
            });
        });

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
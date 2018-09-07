<div class="mt-20 mb-20">
    <table class="table table-bordered table-striped dataTable" id="walletdatatable">
        <thead>
            <tr>                
                <th>{{ trans('order.amt') }}</th>
                <th>{{ trans('order.gift_name') }}</th>
                <th>{{ trans('order.date') }}</th>
            </tr>
        </thead>
        <tbody>
        @if(count($walletlists) > 0)
           @foreach($walletlists as $walletlist)
                <tr>
                    <td>{{ $walletlist['amount'] }} {{ USER_BUY_GIFTCARD_CURRENCY }}</td>   
                    <td><a href="{{ url('myaccount/orderhistory/giftcard/wallet/'.$walletlist->id) }}">{{ $walletlist['giftcard']['name'] }}</a></td>   
                    <td>{{ $walletlist->created_at->format('d/m/Y H:i:s') }}</td>                       
                </tr>
            @endforeach
        @else
            <td colspan="12">{{ trans('myaccount.nogiftcard') }}</td>
        @endif
        </tbody>
    </table>
</div>
{{ $walletlists->links('vendor.pagination.bootstrap-4') }}
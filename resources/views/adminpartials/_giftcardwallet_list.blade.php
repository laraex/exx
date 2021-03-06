<div class="mt-20 mb-20">
    <table class="table table-bordered table-striped dataTable" id="walletdatatable">
        <thead>
            <tr>                
                <th>{{ trans('admin_user.amt') }}</th> 
                <th>{{ trans('admin_user.gift_name') }}</th> 
                <th>{{ trans('admin_user.date') }}</th> 
            </tr>
        </thead>
        <tbody>
        @if(count($giftwalletlists) > 0)
           @foreach($giftwalletlists as $walletlist)
                <tr>
                    <td>{{ $walletlist['amount'] }} {{ USER_BUY_GIFTCARD_CURRENCY }}</td>   
                    <td><a href="#">{{ $walletlist['giftcard']['name'] }}</a></td>   
                    <td>{{ $walletlist->created_at->format('d/m/Y H:i:s') }}</td>                       
                </tr>
            @endforeach
        @else
            <td colspan="12">{{ trans('myaccount.nogiftcard') }}</td>
        @endif
        </tbody>
    </table>
</div>
{{ $giftwalletlists->links('vendor.pagination.bootstrap-4') }}
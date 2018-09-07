<div class="mt-20 mb-20">
    <table class="table table-bordered table-striped dataTable"  id="approvedatatable">
        <thead>
            <tr>                
                <th>{{ trans('order.amt') }}</th>
                <th>{{ trans('order.gift_name') }}</th>
                <th>{{ trans('order.approve') }}</th>
            </tr>
        </thead>
        <tbody>
        @if(count($approvelists) > 0)
           @foreach($approvelists as $approvelist)
                <tr>
                    <td>{{ $approvelist['amount'] }} {{ USER_BUY_GIFTCARD_CURRENCY }}</td>   
                    <td><a href="{{ url('myaccount/orderhistory/giftcard/approve/'.$approvelist->id) }}">{{ $approvelist['giftcard']['name'] }}</a></td>   
                    <td>{{ $approvelist->created_at->format('d/m/Y H:i:s') }}</td>                       
				</tr>
            @endforeach
        @else
        	<td colspan="12">{{ trans('myaccount.nogiftcard') }}</td>
        @endif
        </tbody>
    </table>
</div>
{{ $approvelists->links('vendor.pagination.bootstrap-4') }}
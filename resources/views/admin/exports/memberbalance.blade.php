 <table class="table table-bordered table-striped dataTable" id="walletlistsdatatable">
        <thead>
    
            <tr>
                <th>{{ trans('admin_memberbalance.name') }}</th>
                <th>Coin Name</th>
                <th>{{ trans('admin_memberbalance.wallet_name') }}</th>
                <th>{{ trans('admin_memberbalance.address') }}</th>
                <th>{{ trans('admin_memberbalance.balance') }}</th> 
                <th>{{ trans('admin_memberbalance.balance') }}(KRW)</th>         
            </tr>
        </thead>
        <tbody>
               @if(count($walletlists)>0)
           @foreach($walletlists as $walletlist)
                <tr>
                   <td> <p class="trim"> 
                  <strong>{{ ucfirst($walletlist['username']) }}</strong>    
                        </p> </td> 
                    <td>{{ $walletlist['displayname'] }}</td> 
                    <td>{{ $walletlist['curname'] }}</td>
                    <td>{{ $walletlist['address'] }}</td>                       
                    <td>{{ $walletlist['balance'] }}</td> 
                    <td>{{ $walletlist['equ'] }} </td> 
                </tr>
            @endforeach
            @endif
        </tbody>
    </table>
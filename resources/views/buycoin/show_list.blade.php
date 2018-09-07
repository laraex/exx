<div class="d-card mt-20 mb-20">
    <table class="table table-bordered table-striped dataTable" >
        <thead>
            <tr>                
                <th>Request Coin</th>
                <th>From Wallet </th>                                        
                <th>Date</th>
                <th>Transaction Hash ID</th>            
            </tr>
        </thead>
            <tbody>
                @if(count($transactions) > 0)
                    @foreach($transactions as $transaction)
                        @php
                            $response=json_decode($transaction['response'],true);
                        @endphp
                        <tr>          
                            <td>{{ number_format((float)$transaction->amount,8) }} {{$transaction->tocurrency->token}}</td>                       
                            <td>{{ number_format((float)$transaction->order_amount,2) }} {{$transaction->fromcurrency->token}}</td> 
        					<td>{{ $transaction->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>
                                @if(!is_null($transaction['response'])&&(count($response['data'])>0))
                                    <a  href="{{$transaction->present()->getTxn($response['data']['network'],$response['data']['txid'])}}" target="_blank" class="btn btn-success btn-sm flex-button">{{$response['data']['txid']}}</a>                      
                                @endif
                            </td>    
                        </tr>
                    @endforeach
                @else
                	<td colspan="12">{{ trans('myaccount.norecords') }}</td>
                @endif
            </tbody>
    </table>
</div>
{{$transactions->links()}}
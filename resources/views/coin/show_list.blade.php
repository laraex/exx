<div class="d-card mt-20 mb-20">
    <table class="table table-bordered table-striped dataTable" >
        <thead>
            <tr>                
                <th>Amount</th>
                <th>To Address </th>                                        
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
                                  
                                       
                    <td>{{ number_format((float)$transaction->amount,5) }} {{$transaction->currency->token}}</td> 
                    <td>{{$transaction->to_address}}</td> 
					<td>{{ $transaction->created_at->format('d/m/Y H:i:s') }}</td> 
                    
                   <td>@if(!is_null($transaction['response'])&&(count($response['data'])>0))
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
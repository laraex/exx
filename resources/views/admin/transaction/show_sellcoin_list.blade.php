    <table class="table table-bordered table-striped dataTable" >
        <thead>
            <tr>                
                <th>{{ trans('transaction.username') }}</th>
                <th>{{ trans('transaction.amt') }}</th>
                <th>{{ trans('transaction.to_address') }}</th>                                        
                <th>{{ trans('transaction.date') }}</th>
                <th>{{ trans('transaction.hash_id') }}</th>
            </tr>
        </thead>
        <tbody>
        @if(count($transactions) > 0)
           @foreach($transactions as $transaction)
            @php
                $response=json_decode($transaction['response'],true);
            @endphp
                <tr>
                                  
                    <td><a href="{{ url('admin/users/'.$transaction->user_id) }}">{{ $transaction->user->name }}</a></td>         
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
    <table class="table table-bordered table-striped dataTable" >
        <thead>
            <tr>                              
                <th>{{ trans('admin_user.amt') }}</th>
                <th>{{ trans('admin_user.to_address') }}</th>
                <th>{{ trans('admin_user.date') }}</th>  
                <th>{{ trans('admin_user.hash_id') }}</th>
 
              
            </tr>
        </thead>
        <tbody>
        @if(count($sellcoinTransactions) > 0)
           @foreach($sellcoinTransactions as $sellcoinTransaction)
            @php
                $response=json_decode($sellcoinTransaction['response'],true);
            @endphp
                <tr>
                                  
                                       
                    <td>{{ number_format((float)$sellcoinTransaction->amount,5) }} {{$sellcoinTransaction->currency->token}}</td> 
                    <td>{{$sellcoinTransaction->to_address}}</td> 
                    <td>{{ $sellcoinTransaction->created_at->format('d/m/Y H:i:s') }}</td> 
                    
                   <td>@if(!is_null($sellcoinTransaction['response'])&&isset($response['data'])&&(count($response['data'])>0))
                             <a  href="{{$sellcoinTransaction->present()->getTxn($response['data']['network'],$response['data']['txid'])}}" target="_blank" class="btn btn-success btn-sm flex-button">{{$response['data']['txid']}}</a>
                   

                      
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

 {{$sellcoinTransactions->links()}}
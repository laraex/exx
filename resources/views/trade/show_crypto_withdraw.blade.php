<div class="mt-20 mb-20">
    <table class="table table-bordered table-striped dataTable"  id="userdatatable">
        <thead>
            <tr>                
              
                <th>{{ trans('myaccount.amount') }}</th>
                <th>{{ trans('myaccount.address') }}</th>
                <th>{{ trans('myaccount.status') }}</th>
                <th>{{ trans('myaccount.transaction_id') }}</th>  
                <th>{{ trans('myaccount.request_date') }}</th>              
                <th>{{ trans('myaccount.comments') }}</th>              
                <th>{{ trans('myaccount.approvecancel') }}</th>              
 
            </tr>
        </thead>
        <tbody>
        @if(count($lists) > 0)
           @foreach($lists as $transfer)
          
                <tr>
                    <td>{{sprintf('%0.8f',$transfer->amount) }}
                    
                         {{$transfer->currency->token }}
                     
                    </td>
                    <td>{{$transfer->to_address }}</td>
                    <td>{{trans('myaccount.'.$transfer->status) }}</td>
                    <td>{{$transfer->transaction_id }}</td>
                    <td>{{ $transfer->created_at->format('d/m/Y H:i:s') }}</td> 


                    <td>
                      @if($transfer->status!='pending')
                         {{$transfer->comment }}
                      @else
                         -
                      @endif
                  

                    </td>
                
                    <td>

                      @if($transfer->status!='pending')
                         {{ $transfer->updated_at->format('d/m/Y H:i:s') }}
                      @else
                         -
                      @endif
                    </td> 
                               
                </tr>
            @endforeach
        @else
            <td colspan="12">{{ trans('myaccount.norecords')}}</td>
        @endif
        </tbody>
    </table>
</div>
 {{ $lists->links('vendor.pagination.bootstrap-4') }}
 

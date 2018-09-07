<div class="mt-20 mb-20">
    <table class="table table-bordered table-striped dataTable"  id="userdatatable">
        <thead>
            <tr>                
              
                <th>{{ trans('myaccount.amount') }}</th>
                <th>{{ trans('myaccount.payment') }}</th>
                <th>{{ trans('myaccount.transaction_id') }}</th> 
                <th>{{ trans('myaccount.date') }}</th> 
                <th>{{ trans('myaccount.comments') }}</th>  
                 <th>{{ trans('myaccount.status') }}</th>            
                       
 
            </tr>
        </thead>
        <tbody>
        @if(count($lists) > 0)
           @foreach($lists as $withdraw)
                <tr>
                    <td>{{sprintf('%0.8f',$withdraw->amount) }}
                    
                         {{$withdraw->currency->token }}
                     
                    </td>
                    <td>@include('trade._popoveruserpayaccounts')</td>
                   
                    <td>#{{$withdraw->transaction_id }}</td>
                    <td>{{ $withdraw->updated_at->format('d/m/Y H:i:s') }}</td> 
                    <td>
                      @if($withdraw->status!='pending')
                         {{$withdraw->comments_on_complete }}
                      @else
                         -
                      @endif
                    </td>
                     <td>{{trans('myaccount.'.$withdraw->status) }}</td>
                                  
                </tr>
            @endforeach
        @else
            <td colspan="12">{{ trans('myaccount.norecords')}}</td>
        @endif
        </tbody>
    </table>
</div>
 {{ $lists->links('vendor.pagination.bootstrap-4') }}
 

<div class="mt-20 mb-20">
    <table class="table table-bordered table-striped dataTable"  id="userdatatable">
        <thead>
            <tr>                
                <th>{{ trans('myaccount.time') }} </th>
                <th>{{ trans('myaccount.marketname') }}</th>
                <th>{{ trans('myaccount.transaction_type') }}</th>
                <th>{{ trans('myaccount.order_price') }}</th>
                <th>{{ trans('myaccount.order_quantity') }}</th>  
                <th>{{ trans('myaccount.clamping_quantity') }}</th>              
                <th>{{ trans('myaccount.unfinished') }}</th>
            </tr>
        </thead>
    	<tbody>
    	@if(count($lists) > 0)
           @foreach($lists as $list)
                <tr>
                    <td>{{$list->created_at }}</td> 
                    <td>{{ $list->fromcurrency->name }} </td>
                    <td>{{ ucfirst($list->type) }}</td>
                    <td>{{ $list->amount }}
                     @if($list->type=='buy')
                         {{$list->tocurrency->name }}
                     @endif
                    @if($list->type=='sell')
                         {{$list->fromcurrency->name }}    
                     @endif
                      @if($list->type=='order')
                         {{$list->fromcurrency->name }}
                     @endif
                    </td>                       
                    <td>{{ $list->quantity }}</td> 
                    <td>----</td> 
                    @if($list->status=='pending')
                    <td> <a  href="javascript:Cancel({{ $list->id }});" class="btn btn-danger btn-xs">Cancel</a> </td>
                    @else
                     <td> -- </td>

                     @endif
       
				</tr>
            @endforeach
        @else
        	<td colspan="12">{{ trans('myaccount.nolist')}}</td>
        @endif
        </tbody>
    </table>
</div>
 {{ $lists->links('vendor.pagination.bootstrap-4') }}

 @push('bottomscripts')

<script>

function Cancel($val){

      var r = confirm("Do you want to Cancel this Order.?");
            if (r == true) {
              window.location.href="/myaccount/cancelorder/"+$val;
            } else {
               
            }

}

</script>
@endpush
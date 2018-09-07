<div class="mt-20 mb-20">
    <table class="table table-bordered table-striped dataTable"  id="userdatatable">
        <thead>
            <tr>  
          
                <th>{{ trans('myaccount.holdcoin') }}</th>
                <th>{{ trans('myaccount.possession') }}</th>
                <th>{{ trans('myaccount.avgsellprice') }}</th>
                <th>{{ trans('myaccount.purchase_amount') }}</th>
                <th>{{ trans('myaccount.valuation_gain') }}</th>  
              
              
             
            </tr>
        </thead>
    	<tbody>
    	@if(count($lists) > 0)
           @foreach($lists as $list)
                <tr>
                   @if($list->type=='buy')
                    <td>{{ $list->fromcurrency->name }}</td>
                    @else
                    <td>{{ $list->tocurrency->name }}</td>
                    @endif
                    <td>{{ $list->quantity }}</td>                       
                    <td>{{ $list->amount }}</td> 

                    <td>{{ $list->total_amount }} {{ $list->tocurrency->name }}</td> 
                    
                    <td>---</td> 
    
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
$(document).ready(function(){
        $("#cancel").on("click", function(){
        return confirm("Do you want to Cancel this Order.?");
    });

    
});
</script>
@endpush
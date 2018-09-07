<div class="mt-20 mb-20">
    <table class="table table-bordered table-striped dataTable"  id="userdatatable">
        <thead>
            <tr>  
               <th>{{ trans('myaccount.sno') }}</th>
                <th>{{ trans('myaccount.amount') }}</th>
                <th>{{ trans('forms.quantity') }}</th>
                <th>{{ trans('forms.total_amount') }}</th>
                <th>{{ trans('forms.date') }}</th>  
             </tr>
        </thead>
    	<tbody>
    	@if(count($tradelists) > 0)
           @foreach($tradelists as $openlist)
                <tr>
                    
                     <td>{{ $loop->iteration }}</td>      
                    <td>{{ $openlist->amount }}</td>                       
                    <td>{{ $openlist->quantity }}</td>
                     @if($status=='order') 
                    <td>{{ $openlist->buyorder->total_amount }}</td> 
                    @else 
                   <td>{{ $openlist->total_amount }}</td> 
                     @endif
                   @if($status=='order') 
                    <td>{{ $openlist->order_at }}</td> 
                    @else
                     <td>{{ $openlist->created_at }}</td> 
                    @endif
                
				</tr>
            @endforeach
        @else
        	<td colspan="12">{{ trans('myaccount.noopenlist')}}</td>
        @endif
        </tbody>
    </table>
</div>
 @push('bottomscripts')
<script>
$(document).ready(function(){
        $("#cancel").on("click", function(){
        return confirm("Do you want to Cancel this Order.?");
    });

    
});
</script>
@endpush
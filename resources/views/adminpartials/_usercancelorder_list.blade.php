<div class="tab-container">
	<h3>{{ trans('admin_user.cancel_order_list') }}</h3>
	<table class="table table-bordered" id="cancelorderlistsdatatable">
	    <thead>
		    <tr>

		        <th>{{ trans('myaccount.time') }} </th>
                <th>{{ trans('myaccount.marketname') }}</th>
             <th>{{ trans('myaccount.transaction_type') }}</th> 
                <th>{{ trans('myaccount.order_price') }}</th>
                <th>{{ trans('myaccount.order_quantity') }}</th> 
                <th>{{ trans('myaccount.fee') }}</th>

                  <th>{{ trans('myaccount.totalamount') }}</th>  
                <th>{{ trans('myaccount.status') }}</th>              
                
		    </tr>
	    </thead>
	    <tbody>
		       	@if(count($cancelorderlists) > 0)
           @foreach($cancelorderlists as $buyorder)
                <tr>
                    <td>{{ $buyorder->created_at }}</td> 

                    <td>{{ $buyorder->fromcurrency->name }}</td>
                    <td>{{ $buyorder->type }}</td>

                    <td>{{ $buyorder->amount }}
                       @if($buyorder->type=="buy")
                         {{$buyorder->tocurrency->name }}
                       @else
                        {{$buyorder->fromcurrency->name }}
                       @endif
                    
                    </td>                       
                    <td>{{ $buyorder->quantity }} 
                     @if($buyorder->type=="buy")
                         {{$buyorder->fromcurrency->name }}
                       @else
                        {{$buyorder->tocurrency->name }}
                       @endif


                    </td> 
                    <td>{{ $buyorder->fee_total }}</td> 

                    <td>{{ $buyorder->total_amount }}</td> 


                    <td>{{ ucfirst($buyorder->status) }}</td> 
    
       
				</tr>
            @endforeach
	     	@endif
	    </tbody>
	</table>
 </div>
 
 @push('scripts')
<script>
    $(document).ready(function(){
        $('#cancelorderlistsdatatable').DataTable();

    });
</script>
@endpush
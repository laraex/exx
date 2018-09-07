<div class="mt-20 mb-20">
    <table class="table table-bordered table-striped dataTable"  id="userdatatable">
        <thead>
            <tr>                
                <th>Currency Name</th>
                <th>Current Price</th>
                <th>Day before</th>
                <th>Transaction Price</th>
    
            </tr>
           
        </thead>
    	<tbody>
    	@if(count($traderates) > 0)
           @foreach($traderates as $rates)
                <tr>
                    <td>
                     <p>{{$rates->tocurrencyname}}</p>
                     <p>{{$rates->currencypair}}

                    </td>
                    <td>
                     {{$rates->exchangerate}}
                     </td>                       
                    <td>---</td> 
                 
                    <td>
                  
                       --------
                    </td> 
                    
                  


                   
				</tr>
            @endforeach
        @else
        	<td colspan="12">{{ trans('myaccount.noclosedlist')}}</td>
        @endif
        </tbody>
    </table>
</div>
 
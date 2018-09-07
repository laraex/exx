 <div class="mt-20 mb-20" style="overflow-x:scroll;">
       <table class="table table-bordered table-striped dataTable"  id="userdatatable">
        <thead>
            <tr>                
               
                <th>User</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Price</th>
                         
                <th>Total Pay/Receive Amount</th>              
                <th>Order At</th>
            
               
              
             
            </tr>
        </thead>
        <tbody>
        @if(count($openlists) > 0)
           @foreach($openlists as $openlist)
                <tr>
                 <td>
                            <a href="{{ url('admin/users') }}/{{ $openlist->user_id }} ">
                            <strong>{{ $openlist->user->name }}</strong>
                            </a>                       
                        </td>
                    <td>{{ ucfirst($openlist->type) }}</td>
                     <td>
                    {{ $openlist->quantity }}
                    @if($openlist->type=='buy')
                         {{$openlist->fromcurrency->token }}

                     @endif
                     @if($openlist->type=='sell')
                         {{$openlist->tocurrency->token }}
                        
                     @endif

                    </td> 
                    <td>{{sprintf('%0.8f',$openlist->amount) }}
                     @if($openlist->type=='buy')
                         {{$openlist->tocurrency->token }}

                     @endif
                    @if($openlist->type=='sell')
                         {{$openlist->fromcurrency->token }}
                        
                     @endif
                    </td>                     
                   
                 
                
                    
                     <td> 
                  
                     @if($openlist->type=='buy')
                         {{sprintf('%0.8f', $openlist->total_amount )}}{{$openlist->tocurrency->token }}
                   
                     @else
                      {{sprintf('%0.8f', $openlist->total_amount )}}{{$openlist->fromcurrency->token }}
                     @endif

                     </td> 
                    <td>{{ $openlist->order_at->format('d/m/Y H:i:s') }}</td> 
                  
                   
                  


                   
                </tr>
            @endforeach
        @else
            <td colspan="12">No Orders found</td>
        @endif
        </tbody>
    </table>

         </div>
{{ $openlists->links('vendor.pagination.bootstrap-4') }}
 @push('scripts')


<script>
$(document).ready(function(){
        $("#cancel").on("click", function(){
        return confirm("Do you want to Cancel this Order.?");
    });

    
});
</script>
@endpush




 <div class="mt-20 mb-20" style="overflow-x:scroll;">
       <table class="table table-bordered table-striped dataTable"  id="userdatatable">
        <thead>
            <tr>                
               
                <th>User</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Price</th>
                <th>Status</th>
       
                <th>Total Pay/Receive Amount</th>              
                <th>Order At</th>
                <th>Complete/Cancel At</th>
    
              
             
            </tr>
        </thead>
       <tbody>
        @if(count($closedlists) > 0)
           @foreach($closedlists as $closedlist)
                <tr>
                   <td>
                            <a href="{{ url('admin/users') }}/{{ $closedlist->user_id }} ">
                            <strong>{{ $closedlist->user->name }}</strong>
                            </a>                       
                        </td>
                    <td>
                    @if(count($closedlist->order)>0)
                    {{ ucfirst($closedlist->order->type) }}-
                     @endif
                    {{ ucfirst($closedlist->type) }}

                    </td>
                     <td>{{ $closedlist->quantity }}

                       
                    @if($closedlist->type=='buy')
                         {{$closedlist->fromcurrency->token }}

                     @endif
                     @if($closedlist->type=='sell')
                         {{$closedlist->tocurrency->token }}
                        
                     @endif
                  
                     </td> 
                    <td>

                      {{sprintf('%0.8f',$closedlist->amount) }}
                    @if(count($closedlist->order)>0)
                    @if($closedlist->order->type=='buy')
                         {{$closedlist->fromcurrency->token }}

                    @endif
                    @if($closedlist->order->type=='sell')
                         {{$closedlist->fromcurrency->token }}
                        
                    @endif
                    @else
                    @if($closedlist->type=='buy')
                         {{$closedlist->tocurrency->token }}

                    @endif
                    @if($closedlist->type=='sell')
                         {{$closedlist->fromcurrency->token }}
                        
                    @endif

                    @endif
                     </td>                       
                   
                 
                    <td>
                    @if($closedlist->type=='order')
                         Complete

                    @endif{{ ucfirst($closedlist->status) }}
                    </td>  
                   
                    <td>
                  {{sprintf('%0.8f',$closedlist->total_amount) }}
                    @if(count($closedlist->order)>0)
                    @if($closedlist->order->type=='buy')
                         {{$closedlist->tocurrency->token }}

                    @endif
                    @if($closedlist->order->type=='sell')
                         {{$closedlist->tocurrency->token }}
                        
                    @endif
                    @else
                    @if($closedlist->type=='buy')
                         {{$closedlist->tocurrency->token }}

                    @endif
                    @if($closedlist->type=='sell')
                         {{$closedlist->fromcurrency->token }}
                        
                    @endif

                    @endif
                    

                    </td> 
                    <td>
                    @unless(is_null($closedlist->order_at))
                    {{ $closedlist->order_at->format('d/m/Y H:i:s') }}
                    @endunless
                    </td> 
                    <td>{{ $closedlist->created_at->format('d/m/Y H:i:s') }}</td> 
                  


                   
                </tr>
            @endforeach
        @else
            <td colspan="12">No Orders found</td>
        @endif
        </tbody>
    </table>

         </div>
{{ $closedlists->links('vendor.pagination.bootstrap-4') }}





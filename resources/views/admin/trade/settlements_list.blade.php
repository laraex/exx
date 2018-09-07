 <div class="mt-20 mb-20" style="overflow-x:scroll;">
       <table class="table table-bordered table-striped dataTable"  id="userdatatable">
        <thead>
            <tr>                
               
                <th>User</th>
                <th>To</th>
                <th>Amount</th>
                <th>Order Type</th>
                <th>Payment Via</th>
                <th>Status</th>
                <th>Date</th>
             
    
              
             
            </tr>
        </thead>
       <tbody>
        @if(count($settlementslists) > 0)
           @foreach($settlementslists as $list)
                <tr>
                   <td>
                            <a href="{{ url('admin/users') }}/{{ $list->user_id }} ">
                            <strong>{{ optional($list->user)->name }}</strong>
                            </a>                       
                   </td>
                  
                    <td>{{ $list->to }}

                                     
                    </td> 
                    <td>
                        {{sprintf('%0.8f',$list->amount) }}
                    </td>                       
                   <td>
                   @if(count($list->orderref)>0)
                    {{ ucfirst(optional($list->orderref)->type) }}
                    @else
                    Withdraw
                    @endif
                    </td>
                    <td>
                    {{ $list->type }}
                    </td> 
                    <td>
                    {{ ucfirst($list->status) }}
                    </td>  
                    <td>{{ $list->created_at->format('d/m/Y H:i:s') }}</td> 
                  


                   
                </tr>
            @endforeach
        @else
            <td colspan="12">No Orders found</td>
        @endif
        </tbody>
    </table>

         </div>
{{ $settlementslists->links('vendor.pagination.bootstrap-4') }}





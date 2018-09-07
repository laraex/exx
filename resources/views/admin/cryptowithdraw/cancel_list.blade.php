 <div class="mt-20 mb-20" style="overflow-x:scroll;">
       <table class="table table-bordered table-striped dataTable"  id="userdatatable">
        <thead>
            <tr>                
               
                <th>User</th>
                <th>Amount</th>                         
                <th>To Address</th>              
                <th>Comment</th>              
                <th>Cancel At</th>
           
            
               
              
             
            </tr>
        </thead>
        <tbody>
        @if(count($lists) > 0)
           @foreach($lists as $list)
                <tr>
                    <td>
                            <a href="{{ url('admin/users') }}/{{ $list->user_id }} ">
                            <strong>{{ $list->user->name }}</strong>
                            </a>                       
                    </td>
                   
                    <td>{{sprintf('%0.8f',$list->amount) }}
                    
                         {{$list->currency->token }}
                        
                   
                    </td>                     
                   
                    <td>{{$list->to_address }}</td>
                    <td>{{$list->comment }}</td>
                
                    <td>{{ $list->updated_at->format('d/m/Y H:i:s') }}</td> 
                               
                </tr>
            @endforeach
        @else
            <td colspan="12">No Records found</td>
        @endif
        </tbody>
    </table>

         </div>
{{ $lists->links('vendor.pagination.bootstrap-4') }}
 



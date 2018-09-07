 <div class="mt-20 mb-20" style="overflow-x:scroll;">
       <table class="table table-bordered table-striped dataTable"  id="userdatatable">
        <thead>
            <tr>                
               
                <th>User</th>
                <th>Amount</th>                         
                <th>To Address</th>              
                <th>Request At</th>
                <th>Action</th>
            
               
              
             
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
                
                    <td>{{ $list->created_at->format('d/m/Y H:i:s') }}</td> 
                    <td>

                    <a id="approve" href="{{ url('admin/cryptowithdraw/approve/'.$list->id) }}" class="btn btn-success btn-xs">Approve</a>
                    <a id="cancel" href="{{ url('admin/cryptowithdraw/cancel/'.$list->id) }}" class="btn btn-danger btn-xs">Cancel</a>

                     </td>              
                </tr>
            @endforeach
        @else
            <td colspan="12">No Records found</td>
        @endif
        </tbody>
    </table>

         </div>
{{ $lists->links('vendor.pagination.bootstrap-4') }}
 @push('scripts')


<script>
$(document).ready(function(){
        $("#cancel").on("click", function(){
        return confirm("Do you want to Cancel this Withdraw.?");
    });

     $("#approve").on("click", function(){
        return confirm("Do you want to Approve this withdraw.?");
    });
});
</script>
@endpush




 <div class="mt-20 mb-20">
        <table class="table table-bordered table-striped dataTable"  id="usertable">
        <thead>
            <tr>                
                <th>Name</th>
                <th>Date of Join</th>
       
            </tr>
        </thead>
        <tbody>
            @foreach($adminlist as $admin)
                  <tr>
                        <td width="220px">
                                    <p class="trim">
                                     
                                        <strong>{{ $admin->name }}</strong>
                                    
                                    </p>
                       
                        </td>
                        <td><span title="{{ $admin->created_at }}">{{ $admin->created_at->format('d-m-Y H:i:s') }}</span></td> 
                                         
                       
                    </tr>
            @endforeach
        </tbody>
        </table>

         </div>

 <table class="table table-bordered table-striped dataTable" >
        <thead>
    
            <tr>
                <th>{{ trans('admin_user.username') }}</th>
                <th>{{ trans('admin_user.email') }}</th>
                <th>{{ trans('admin_user.first_names') }}</th>
                <th>{{ trans('admin_user.last_names') }}</th> 
                <th>{{ trans('admin_user.countrys') }}</th>         
            </tr>
        </thead>
        <tbody>
               @if(count($memberlists)>0)
           @foreach($memberlists as $memberlist)
                <tr>
                   <td> <p class="trim"> 
                  <strong>{{ ucfirst($memberlist['username']) }}</strong>    
                        </p> </td> 
                    <td>{{ $memberlist['email'] }}</td> 
                    <td>{{ $memberlist['firstname'] }}</td>
                    <td>{{ $memberlist['lastname'] }}</td>                       
                    <td>{{ $memberlist['country'] }}</td> 
                </tr>
            @endforeach
            @endif
        </tbody>
    </table>
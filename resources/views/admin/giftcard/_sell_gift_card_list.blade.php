 <div class="mt-20 mb-20" style="overflow-x:scroll;">
        <table class="table table-bordered table-striped dataTable"  id="userdatatable">
        <thead>
            <tr>                
                <th>{{ trans('admin_sellgift.name') }}</th>
                <th>{{ trans('admin_sellgift.title') }}</th>
                <th>{{ trans('admin_sellgift.description') }}</th>
                <th>{{ trans('admin_sellgift.amt') }}</th>
                <th>{{ trans('admin_sellgift.sell_amt') }}</th> 
                <th>{{ trans('admin_sellgift.date') }}</th>
                <th>{{ trans('admin_sellgift.img') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($list as $selllist)
                  <tr>
                        <td>
                            <a href="{{ url('admin/users') }}/{{ $selllist['user_id'] }} ">
                            <strong>{{ $selllist->present()->getUsername($selllist['user_id']) }}</strong>
                            </a>                       
                        </td>

                        <td>{{ $selllist['name']}}</td>   
                        <td>{{ $selllist['description']}}</td>   
                        <td>{{ $selllist['valueprice'] }}</td>
                        <td>{{ $selllist['sellprice'] }}</td> 
                        <td>{{ $selllist->created_at->format('d/m/Y H:i:s') }}</td> 
                        <td><img src="{{ url($selllist['image']) }}" width='10%'></td>  
                        
                     
                        

                    </tr>
            @endforeach
        </tbody>
        </table>

         </div>
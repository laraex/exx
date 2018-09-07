 <div class="mt-20 mb-20" style="overflow-x:scroll;">
     <div class="dropdown pull-right">
    <button class="btn btn btn-success dropdown-toggle " type="button" data-toggle="dropdown">{{ trans('export.exports') }}
    <span class="caret"></span></button>
    <ul class="dropdown-menu">
      <li><a href="{{ url('admin/exportmemberwallet') }}">CSV</a></li>
      <li><a href="{{ url('admin/exportallmemberxls') }}">XLS</a></li>
     
    </ul>
  </div><br><br>
        <form  method="POST" role="search">
          {{ csrf_field() }}
            <div class="input-group">
              <input type="text" class="form-control" name="q" placeholder="Search Logname or Description"> 
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                  </button>
                </span>
            </div>
        </form>
    <br>

    <table class="table table-bordered table-striped dataTable" id="walletlistsdatatable">
        <thead>
      <!--   <tr>
            <th rowspan="2">{{ trans('admin_memberbalance.name') }}</th>
            <th colspan="3"><center>{{ trans('admin_memberbalance.wallet') }}</center></th>
        </tr> -->
            <tr>
                <th>{{ trans('admin_memberbalance.name') }}</th>
                <th>Coin Name</th>
                <th>{{ trans('admin_memberbalance.wallet_name') }}</th>
                <th>{{ trans('admin_memberbalance.address') }}</th>
                <th>{{ trans('admin_memberbalance.balance') }}</th> 
                <th>{{ trans('admin_memberbalance.balance') }}(KRW)</th>         
            </tr>
        </thead>
        <tbody>
               @if(count($balance)>0)
           @foreach($balance as $walletlist)
                <tr>
                   <td> <p class="trim">
                            <a href="{{url('/admin/users/'.$walletlist['user_id'])}} ">
                                <strong>{{ ucfirst($walletlist['username']) }}</strong>
                            </a>
                        </p> </td> 
                    <td>{{ $walletlist['displayname'] }}</td> 
                    <td>{{ $walletlist['curname'] }}</td>
                    <td>{{ $walletlist['address'] }}</td>                       
                    <td>{{ $walletlist['balance'] }}</td> 
                    <td>{{ $walletlist['equ'] }} </td> 
                </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    
 </div>
  {{ $users->links() }}
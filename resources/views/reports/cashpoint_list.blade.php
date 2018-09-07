 <div class="mt-20 mb-20" style="overflow-x:scroll;">
   
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
               @if(count($users)>0)
           @foreach($users as $key=>$user)

                @foreach($currency as $k=>$v)
                <tr>
                   <td> 
                   @if($k==1)
                   <p class="trim">
                            <a href="{{url('/admin/users/'.$user->id)}} ">
                                <strong>{{ ucfirst($user->name) }}</strong>
                            </a>
                        </p>
                        @endif
                    </td> 
                    <td>{{ $v->displayname }}</td> 
                    <td>{{ $v->token }}</td>
                     <td> 
                     @if($v->type=='fiat')
                     {{ $user->present()->getAccountNo($user->id,$v->id)}}
                     @endif
                     </td>                     
                    <td>{{optional($user->UserBalance)[$k]}}</td> 
                    <td>
                    @if($v->name!='KRW')

                    {{ $user->present()->getexchangerate(optional($user->UserBalance)[$k],'KRW',$v->name,'buy')}} 

                    @else
                        {{optional($user->UserBalance)[$k]}}
                    @endif

                    </td> 
                </tr>
            @endforeach
            @endforeach
            @endif
        </tbody>
    </table>
    
 </div>
  {{ $users->links() }}
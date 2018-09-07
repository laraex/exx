<!-- <div class="row">
    <div class="flex wallet-box">
        @foreach ($walletlists as $walletlist)
            <div class="wallet-balance-box">
             
        
            </div>
        @endforeach
   
        </div>
</div> -->
<div class="tab-container">
    <h3>{{ trans('admin_user.wallet_list') }} </h3>
      <div class="dropdown pull-right">
    <button class="btn btn btn-success dropdown-toggle " type="button" data-toggle="dropdown">{{ trans('export.exports') }}
    <span class="caret"></span></button>
    <ul class="dropdown-menu">
      <li><a href="{{ url('admin/exportwallet/'.$user->id) }}">CSV</a></li>
      <li><a href="{{ url('admin/exportmemberxls/'.$user->id) }}">XLS</a></li> 
    </ul>
  </div><br><br>
    <table class="table table-bordered" id="walletlistsdatatable">
        <thead>
            <tr>

                <th>{{ trans('forms.coinname') }}</th>
                <th>{{ trans('admin_memberbalance.tokenname') }}</th>
                <th>{{ trans('admin_memberbalance.address') }}</th>
                <th>{{ trans('admin_memberbalance.balance') }}</th> 
                <th>{{ trans('admin_memberbalance.balance') }}(KRW)</th>             
                
            </tr>
        </thead>
        <tbody>

                @if(count($walletlists) > 0)
           @foreach($walletlists as $walletlist)
                <tr>
                    <td>{{ $walletlist['displayname'] }}</td> 

                    <td>{{ $walletlist['curname'] }}</td>

                    <td>{{ $walletlist['address']  }}

                    </td>                       
                    <td>{{ $walletlist['balance']  }}</td> 
                    <td>{{ $walletlist['equ'] }}</td> 

                </tr>
            @endforeach
            @endif
        </tbody>
    </table>
 </div>
 
 @push('scripts')
<script>
    $(document).ready(function(){
        $('#walletlistsdatatable').DataTable();

    });
</script>
@endpush
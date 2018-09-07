<div class="mt-20 mb-20">
    <table class="table table-bordered table-striped dataTable"  id="tranlists">
        <thead>
            <tr>                
                 <th>{{ trans('wallet.datetime') }} </th>
                <th>{{ trans('myaccount.coin') }}</th>
                <th>{{ trans('wallet.fromaddress') }}</th>
                <th>{{ trans('wallet.toaddress') }}</th>
                <th>{{ trans('myaccount.amount') }}</th>              
                <th>{{ trans('wallet.action') }}</th> 
             
            </tr>
        </thead>
        <tbody>
        @if(count($tranlists) > 0)
           @foreach($tranlists as $translist)
            <tr>
            @if($translist['time_stamp']!=null)
            <td>{{$translist['time_stamp']}}</td>
            @else
             <td>---</td>
            @endif
              <td>{{$translist['curname']}}</td>
                <td>{{$translist['from_address']}}</td>
                  <td>{{$translist['to_address']}}</td>
                    <td>{{$translist['amount']}} {{$translist['curname']}}</td>
                    <td><a href="{{$translist['txurl']}}" class="btn btn-sm btn-success mb-10" title="{{$translist['txid']}}" target="_blank">{{ trans('wallet.viewtrans') }} </a></td>
            </tr>

              
            @endforeach
        @else
           <tr>
            <td colspan="12">{{ trans('myaccount.noopenlist')}}</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
 
{{ $coin_details->links() }}

 @push('bottomscripts')

<script>

function ChangeStatus(val){
alert(val);
  window.location.href ="/myaccount/tradehistory/show/transhistory/"+$val;
}


</script>
@endpush
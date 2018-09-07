<div class="mt-20 mb-20">
        <div style="float:right">
     <!--    <form method="POST">
          <select name="trans" id="trans" >
            <option value="{{url('/myaccount/tradehistory/show/transhistory/all')}}">Whole Transaction</option>
            <option value="{{url('/myaccount/tradehistory/show/transhistory/buy')}}">Buy</option>
            <option value="sell">Sell</option>
            <option value="deposit">Deposit</option>
            <option value="withdraw">Withdraw</option> 
        </select>
 </form> -->
 
 <div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select
  <span class="caret"></span></button>
        <ul class="dropdown-menu">
         <li class="active"><a href="{{url('/myaccount/tradehistory/show/transhistory/all')}}">Whole Transaction</a></li>
        <li class="active"><a href="{{url('/myaccount/tradehistory/show/transhistory/buy')}}"> Buy</a></li>
         <li > <a href="{{url('/myaccount/tradehistory/show/transhistory/deposit')}}">Deposit </a></li>
         <li > <a href="{{url('/myaccount/tradehistory/show/transhistory/sell')}}">Sell </a></li>
        </ul>
        </div>
       
    </div>
    <table class="table table-bordered table-striped dataTable"  id="userdatatable">
        <thead>
            <tr>                
                 <th>{{ trans('myaccount.order_time') }} </th>
                <th>{{ trans('myaccount.coin') }}</th>
                <th>{{ trans('myaccount.transaction_type') }}</th>
                <th>{{ trans('myaccount.trans_quantity') }}</th>
                <th>{{ trans('myaccount.unit_price') }}</th>  
                <th>{{ trans('myaccount.amount') }}</th>              
                <th>{{ trans('myaccount.fee') }}</th>
                <th>{{ trans('myaccount.settle_amount') }}
                ({{ trans('myaccount.reflect') }})</th>
              
             
            </tr>
        </thead>
        <tbody>
        @if(count($lists) > 0)
           @foreach($lists as $list)

        @php
        $tran_details=json_decode($list->request,true);

         if($list->action=="buytrade"){
            if($tran_details['buy_amount']){
                $buyamount=$tran_details['buy_amount'];
             }
             $settlement_amount=($tran_details['volume']-$tran_details['fee_total']);
        }
        if($list->action=="selltrade"){

             $settlement_amount=$tran_details['net_amount'];
        }
        

        
         @endphp 

                <tr>
                     <td>   {{ $list->created_at }}</td> 
                     <td>
                       
                       {{$list->currency->token}}
                     </td>
                       {{-- @if($list->action=="buytrade")
                      <td>{{$tran_details['from_currency'] }}
                      </td>
                      @else
                      <td> 
                    @foreach($list->currency as $cur)
                           {{$cur->name}}
                       @endforeach 

                       </td> 
               @endif  --}}

                        

                    <td>{{$list->action}} - {{$list->type}}</td>

               @if($list->action=="buytrade") 
                    <td> {{$tran_details['volume'] }} {{$tran_details['from_currency'] }} </td> 
                @elseif($list->action=="selltrade")
                <td> {{$tran_details['volume'] }} {{$tran_details['to_currency'] }} </td> 
               @else
               <td> - </td> 
               @endif

               @if($list->action=="buytrade" )
                    <td> {{$tran_details['amount'] }} {{$tran_details['to_currency'] }} </td> 
              @elseif($list->action=="selltrade" ) 
               <td> {{$tran_details['amount'] }} {{$tran_details['from_currency'] }} </td>  
               @else
               <td> - </td> 
               @endif

                @if($list->action=="buytrade" )
                    <td> {{$tran_details['buy_amount'] }} {{$tran_details['to_currency'] }} </td> 
              @elseif($list->action=="selltrade")
              <td> {{$tran_details['buy_amount'] }} {{$tran_details['from_currency'] }} </td> 
               @else
               <td> {{ $list->amount }} </td> 
               @endif

                @if($list->action=="buytrade" || $list->action=="selltrade")
                    <td> {{$tran_details['fee_total'] }} {{$tran_details['from_currency'] }}</td> 
               @else
               <td> -- </td> 
               @endif

        
               @if($list->action=="buytrade"  || $list->action=="selltrade")
                    <td>{{$settlement_amount }} {{$tran_details['from_currency'] }}  </td> 
               @else
               <td> {{ $list->amount }} </td> 
               @endif

                  <!--   <td>{{ $list->order_at }}</td> 
                    <td>{{ $list->created_at }}</td> 
                    <td><a id="cancel" href="#" class="btn btn-danger btn-xs">Cancel</a> </td> -->
       
                </tr>
            @endforeach
        @else
            <td colspan="12">{{ trans('myaccount.nolist')}}</td>
        @endif
        </tbody>
    </table>

   
</div>
 {{ $lists->links('vendor.pagination.bootstrap-4') }}
 @push('bottomscripts')


<script>

function ChangeStatus(val){
alert(val);
  window.location.href ="/myaccount/tradehistory/show/transhistory/"+$val;
}


</script>
@endpush
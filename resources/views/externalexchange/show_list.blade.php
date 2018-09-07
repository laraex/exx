@foreach($transactions as $transaction)
	@php
       $response=json_decode($transaction['response'],true);
       $to_response = json_decode($transaction['to_response'],true);
    @endphp
  	<div class="row">
	    <div class="col-md-1">
	  	    <h3>{{strtoupper($transaction->created_at->format('M'))}}</h3>
	  	 		<p>{{$transaction->created_at->format('d')}}</p>
	  	</div>
  		<div class="col-md-11">
			<div class="row">
	  			<div class="col-md-12">
					<div class="pull-right">
						<label class="btn btn-info"> - {{$transaction->amount}} {{ $transaction->from_currency->token }}</label><br>
						<label class="btn btn-success"> + {{$transaction->total_exchange_amount}} {{ $transaction->to_currency->token }}</label>
		 			</div> 			
					<span><strong>{{trans('myaccount.transaction_id')}} </strong></span> <span class="label label-info">{{$transaction->transaction_id}}</span><br>

					{{trans('myaccount.exchange_rate_variant',['fromcurrency'=>$transaction->from_currency->token])}}  {{$transaction->exchangerate_variant}} {{$transaction->to_currency->token}} <br>

					{{trans('myaccount.exchange_fee_total')}} ({{$transaction->fee}} % +{{$transaction->base_fee}}) = {{$transaction->fee_total}} {{$transaction->to_currency->token}}<br>

					<small>{{$transaction->created_at->format('d-m-Y H:i:s')}}</small>
					<br>

					<label>{{ $transaction->from_currency->token }}</label>
 					@if(!is_null($transaction['response'])&&(count($response['data'])>0))
                 		<a  href="{{$transaction->present()->getTxn($response['data']['network'],$response['data']['txid'])}}" target="_blank" class="btn btn-success btn-sm flex-button">{{$response['data']['txid']}}</a>
       				@endif
       			<br>

           			@if($transaction->type == 'crypto')
	         			@if(!is_null($transaction['to_response'])&&(count($to_response['data'])>0))
	                    	<label>{{ $transaction->to_currency->token }}</label>
	                    	<a  href="{{$transaction->present()->getTxn($to_response['data']['network'],$to_response['data']['txid'])}}" target="_blank" class="btn btn-success btn-sm flex-button">{{$to_response['data']['txid']}}</a>
	               		@endif
	               	@endif
	 			</div>
	 		</div>
  		</div>
	</div>
	<hr>
@endforeach
{{$transactions->links()}}
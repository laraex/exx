
@if(count($transactions))
<h2>{{trans('myaccount.transactions')}}</h2>
@endif

	@foreach($transactions as $transaction)
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
		  </div>
		 
		</div>
	  </div>
	</div>
	<hr>
	@endforeach


<hr>
<div class="w-full">
<h1 class="page-title">{{ trans('myaccount.my_fiat_wallets') }}</h1>
<div class="grid grid-2  gc-20 mt-20 mb-20" >

		 @if (count($walletlists) > 0)
        	@foreach ($walletlists as $walletlist)
			<div class="grid widget-card">
				<div>
					<div class="flex">
						<div>
						<p><img src="{{ url($walletlist->currency->image) }}" class="dashlet-flag"></p>
						</div>
						<div>
						<p><strong> {{ $walletlist->currency->name }} Wallet</strong><br/>
						<small>{{ $walletlist->account_no }}</small></p>
						</div>
					</div>
				 </div>
				 <div>
				 	<p>Balance<br/>
				 		<strong> {{ $walletlist->currency->name }}  {{ $walletlist->present()->getBalance($walletlist->currency->id, $walletlist->user_id) }}</strong>
					<!-- <br/><small>≈ USD 1,002,00</small>  -->
					</p>

				 </div>
				{{-- <div>
				 	<p>Last Action<br/>

					 Deposit of {{ $walletlist->present()->getLastDepositAmount($walletlist->id) }} {{ $walletlist->currency->name }}  <br/>

					@if ($walletlist->present()->getLastDepositDateTime($walletlist->id) != '')
					<small>on {{ $walletlist->present()->getLastDepositDateTime($walletlist->id) }} </small>
					@endif

					</p>
				 </div>--}}

				 <div>
				 	<p>Last Action<br/>

				 	@php
				 		$last_txn=$walletlist->present()->getLastTransaction($walletlist->id);
				 	@endphp

				 	@if(count($last_txn)>0)

					{{ucfirst($last_txn->action)}} {{ $last_txn->amount }} {{ $walletlist->currency->name }}  <br/>

					
					<small>on {{ $last_txn->created_at->format('d-m-Y H:i:s') }} </small>
					@else
					  -
					@endif

					</p>
				 </div>
				 <div>
				 	<p>
				 		<div class="grid-2"> 
				 			<div class="grid grid-2 gc-10 mb-10">
				 			<a class="btn btn-secondary" href="{{ url('myaccount/fund/list/new/'.$walletlist->currency->id) }}">View Pending Transactions</a>  
				 			<a class="btn btn-secondary" href="{{ url('myaccount/fund/list/active/'.$walletlist->currency->id) }}">View Completed Transactions</a>
				 			</div>
				 			<div class="grid grid-3 gc-10 mt-10">    
						    <a class="btn btn-secondary" href="{{ url('myaccount/addfundcurrency/'.$walletlist->currency->id) }}">{{ trans('myaccount.add_fund') }}</a>						  
						    <a class="btn btn-secondary" href="{{ url('myaccount/fundtransfer/redirectform/'.$walletlist->currency->id) }}">{{ trans('myaccount.transfer_fund') }}</a>
						    <a class="btn btn-secondary" href="{{ url('myaccount/withdraw/redirectform/'.$walletlist->present()->getPaymentgatewayid($walletlist->currency->id)) }}">{{ trans('myaccount.withdraw_fund') }}</a>
						    </div>
						  </div>
				 	</p>
				 </div>
			</div>
			 @endforeach
		@endif
</div>
</div>
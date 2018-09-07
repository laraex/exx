<div class="container">
<h1 class="page-title">{{ trans('myaccount.my_crypto_wallets') }}</h1>
<div class="grid grid-3 gc-20 mt-20 mb-20">
			<div class="grid widget-card">
				<div class="grid-col-1">
					<div class="flex">
						<div>
						<p><img src="{{ url($btc->image) }}" class="dashlet-flag"></p>
						</div>
						<div>
						<p><strong> {{ $btc->displayname }} Wallet</strong><br/>
						<small>{{ optional($user_accounts)->btc_address }}</small>
						</p>
						</div>
					</div>
				 </div>
				 <div class="grid-col-2">
					<p>
						
						<b> {{$balance}} {{$btc->token}} </b> ≈ {{$balance_btc_equi}}{{\Config::get('settings.currency')}}
					</p>

				 </div>
				 
				 <div class="grid-col-3">
				 	<p>
				 		<div class="btn-group btn-group-sm" role="group" aria-label="Default button group"> 
				 							  
						    <a class="btn btn-secondary" href="{{url('myaccount/type/btc/send')}}">{{trans('myaccount.sendcoin')}}</a>
						    <a class="btn btn-secondary" href="{{url('myaccount/type/btc/receive')}}">{{trans('myaccount.receivecoin')}}</a>
						    <a href="{{ url('myaccount/buy/setcoin/'.$btc->id) }}" class="btn btn-secondary">Buy {{$btc->displayname}}</a>
						   
						  </div>
				 	</p>
				 </div>
			</div>
			

		<div class="grid widget-card">
				<div class="grid-col-1">
					<div class="flex">
						<div>
						<p><img src="{{ url($ltc->image) }}" class="dashlet-flag"></p>
						</div>
						<div>
						<p><strong> {{ $ltc->displayname }}Wallet</strong><br/>
					    <small>{{ optional($user_accounts_ltc)->ltc_address }}</small> 
					    </p>
						</div>
					</div>
				 </div>
				 <div class="grid-col-2">
					<p>
					
						 <b> {{$balance_ltc}} {{$ltc->token}} </b>  ≈ {{$balance_ltc_equi}} {{\Config::get('settings.currency')}}
					</p>

				 </div>
				 
				 <div class="grid-col-3">
				 	<p>
				 		<div class="btn-group btn-group-sm" role="group" aria-label="Default button group"> 
				 							  
						    <a class="btn btn-secondary" href="{{url('myaccount/type/ltc/send')}}">{{trans('myaccount.sendcoin')}}</a>
						    <a class="btn btn-secondary" href="{{url('myaccount/type/ltc/receive')}}">{{trans('myaccount.receivecoin')}}</a>

						 <a href="{{ url('myaccount/buy/setcoin/'.$ltc->id) }}" class="btn btn-secondary">Buy {{$ltc->displayname}}</a>
						   
						  </div>
				 	</p>
				 </div>
		</div>

	
</div>
</div>
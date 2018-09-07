<div class="table-wrapper mt-4 mb-4">
<table class="table table-striped table-responsive">
	<thead>
		<th>Date</th>
		<th>Transaction Id</th>
		<th>Transaction Type</th>
		<th>Sender </th>
		<th>Receiver</th>
		<th>Amount</th> 		
	</thead>
	<tbody>
	@if (count($transactions) > 0)
		@foreach ($transactions as $data)
			@php
				$reponse = json_decode($data['response'], true);
				$request = json_decode($data['request'], true);
				$transaction_number = '';
				  if ( isset($reponse['transaction_number']))
				  {
				        $transaction_number = $reponse['transaction_number'];
				  }
			@endphp
			<tr>
				<td>{{ $data->created_at->format('d/m/Y H:i:s') }}</td>
				<td class="align-middle">{{ $transaction_number }}</td>
				<td class="align-middle">
				@if ($data['action'] == 'deposit')
					Fund Deposited
				@elseif ($data['action'] == 'withdraw')
					Withdraw
				@elseif ($data['action'] == 'transfer')
					Fund Transfer
				@elseif ($data['action'] == 'exchange')
					Exchange
				@elseif ($data['action'] == '')
					{{ $reponse['comment'] }}
				@endif
				</td>
				<td class="align-middle">

					@if ($data['action'] == 'deposit')
						{{ $data->present()->getFundDepositSendername($data['account_id']) }}
					@elseif ($data['action'] == 'withdraw')
						{{ $data->present()->getTransactionWithdrawAccountName($data['account_id']) }}
					@elseif ($data['action'] == 'transfer')
						{{ $data->present()->getTransactionFundtransferName($data['id']) }}
					@elseif ($data['action'] == 'exchange')
						{{ $data->present()->getExchangeSenderAccountName($data['account_id']) }}
					@elseif ($data['action'] == '')

						{{ $data->present()->getAdminSenderAccountName($data['account_id'], $request['userid']) }}
					
					@endif

				 </td>
				<td class="align-middle">

					@if ($data['action'] == 'deposit')
						{{ $data->present()->getFundDepositReceivername($data['account_id']) }}
					@elseif ($data['action'] == 'withdraw')
						{{ $data->present()->getTransactionAccountName($data['account_id']) }}
					@elseif ($data['action'] == 'transfer')
						{{ $data->present()->getFundtransferReceiverName($data['id']) }}
					@elseif ($data['action'] == 'exchange')
						{{ $data->present()->getExchangeReceiverAccountName($data['account_id']) }}
					@elseif ($data['action'] == '')
						{{ $data->present()->getExchangeSenderAccountName($data['account_id']) }}

					@endif
				 </td>
				<td>{{ $data->present()->getCurrencyCode($data['account_id']) }} {{ $data['amount'] }}</td>
			</tr>
		@endforeach
	@else
		<tr><td colspan="6">{{ trans('forms.notransactionfound') }}</td></tr>
	@endif
	
	</tbody>
</table>
<!-- <div class="feed-bar">
	<div class="row">
		<div class="col">
			<p class="text-center"><a href="#" class="btn btn-default btn-primary">View All Data</a></p>
		</div>
		<div class="col">
			<p class="text-center"><a href="#" class="btn btn-default btn-primary">Search a Data</a></p>
		</div>
	</div>
</div> -->
</div>
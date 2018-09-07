@extends('layouts.app')
@section('content')
<div class="container">
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
	@foreach($transactions as $data)
		@php
			$reponse = json_decode($data['response'], true);
			$transaction_number = '';
			if ( isset($reponse['transaction_number']))
			{
			    $transaction_number = $reponse['transaction_number'];
			}
			else
			{
				$transaction_number = '-';
			}
		@endphp
		<tr>
			<td>{{ $data['created_at']->format('d/m/Y H:i:s') }}</td>
			<td class="transactionnumber">{{ $transaction_number }}</td>
			<td>
				@if ($data['action'] == 'deposit')
					Fund Deposited
				@elseif ($data['action'] == 'withdraw')
					Withdraw
				@elseif ($data['action'] == 'transfer')
					Fund Transfer
				@elseif ($data['action'] == 'exchange')
					Exchange
				@elseif ($data['action'] == 'NULL')
					{{ $reponse['comment'] }}
				@endif
			</td>
			<td>
				@if ($data['action'] == 'deposit')
						{{ $data->present()->getFundDepositSendername($data['account_id']) }}
					@elseif ($data['action'] == 'withdraw')
						{{ $data->present()->getTransactionWithdrawAccountName($data['account_id']) }}
					@elseif ($data['action'] == 'transfer')
						{{ $data->present()->getTransactionFundtransferName($data['id']) }}
					@elseif ($data['action'] == 'exchange')
						{{ $data->present()->getExchangeSenderAccountName($data['account_id']) }}
					@elseif ($data['action'] == 'NULL')
						{{ $data->present()->getAdminSenderAccountName($data['account_id'], $request['userid']) }}
				@endif
			</td>
			<td>
				@if ($data['action'] == 'deposit')
						{{ $data->present()->getFundDepositReceivername($data['account_id']) }}
					@elseif ($data['action'] == 'withdraw')
						{{ $data->present()->getTransactionAccountName($data['account_id']) }}
					@elseif ($data['action'] == 'transfer')
						{{ $data->present()->getFundtransferReceiverName($data['id']) }}
					@elseif ($data['action'] == 'exchange')
						{{ $data->present()->getExchangeReceiverAccountName($data['account_id']) }}
					@elseif ($data['action'] == 'NULL')
						{{ $data->present()->getExchangeSenderAccountName($data['account_id']) }}
				@endif
			</td>
			<td>{{ $data->present()->getCurrencyCode($data['account_id']) }} {{ $data['amount'] }}</td>
		</tr>
	@endforeach
	</tbody>
</table>
</div>
</div>
@endsection
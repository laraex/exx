<div class="flex wallet-table-container">
	<table class="table table-striped">
		<thead>
			<th>{{ trans('myaccount.amount') }} </th>
			<th>{{ trans('myaccount.payment_method') }}</th>
			<th>{{ trans('myaccount.created_on') }}</th>
			@if ($currencyid > 1 && $status == 'new')
		        <th>{{ trans('myaccount.invoice') }}</th>
	        @endif
		</thead>
		<tbody>

		 @if (count($fundlists) > 0)
        	@foreach($fundlists as $data)
				@php 
				  $request = json_decode($data['request'], true); 
				@endphp
				    <tr>
				       
				        <td>{{ $data->amount }} {{ $currencydetails->name }}</td>
				        <td>
				        {{ $data->present()->getTransactionPaymentName($request['payment_id']) }}
				        </td>
				        <td>{{ $data->created_at->format('d/m/Y H:i:s') }}</td>
				        @if ($request['payment_id'] > 1 && $status == 'new')
				        <td> <a href="{{ url('myaccount/bankwire/printinvoice') }}" class="btn btn-info" target="_blank">{{ trans('forms.printinvoice') }}</a></td>
				        @endif
				       
				    </tr>

				 @endforeach
		@else

		<tr><td colspan="4">{{ trans('myaccount.nofundfound') }}</td></tr>

		@endif	
		</tbody>
		
	</table>

</div>
{{ $fundlists->links() }}
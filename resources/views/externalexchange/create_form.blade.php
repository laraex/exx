<div class="grid grid-300-auto">
	<div class="widget-card">
		<div class="grid">
			<p>
			    <label>{{ trans('forms.exchange_rate_lbl',['fromcurrency'=>$pair_details->fromcurrency->name]) }}</label>
			    <label>{{  number_format((float)$total_amount,3) }} {{$pair_details->tocurrency->name}}</label>
			</p>

			<p>
			    <label>{{ trans('forms.exchange_rate_min_amount_lbl') }}</label>
			    <label>{{ $pair_details->min_amount }} {{$pair_details->fromcurrency->name}}</label>
			</p>

			<p>
			    <label>{{ trans('forms.exchange_rate_max_amount_lbl') }}</label>
			    <label>{{ $pair_details->max_amount }} {{$pair_details->fromcurrency->name}}</label>
			</p>
		</div>
	</div>
	<div class="widget-card">
 		<form method="post" action="" class="form-horizontal">
 			{{ csrf_field() }}
 			
		    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
			    <label>{{ trans('forms.exchange_amount_lbl') }} {{$pair_details->fromcurrency->name}}</label>
			    <input type="text" name="amount" id="amount" class='form-control' value="{{ old('amount') }}" onkeyup="getExchangeValue();">
			    <small class="text-danger">{{ $errors->first('amount') }}</small>
			</div> 
	
			<div class="form-group{{ $errors->has('fee_amount') ? ' has-error' : '' }}">
			    <label>{{ trans('forms.exchange_fee_lbl') }}  {{$pair_details->tocurrency->name}}</label>
			    <input type="text" name="fee_amount" id="fee_amount" class='form-control' value="{{ old('fee_amount') }}" readonly>
			  	<small class="text-danger">{{ $errors->first('fee_amount') }}</small>
			</div>

			<div class="form-group{{ $errors->has('exchange_amount') ? ' has-error' : '' }}">
			    <label>{{ trans('forms.exchange_to_amount_lbl') }} {{$pair_details->tocurrency->name}}</label>
			    <input type="text" name="exchange_amount" id="exchange_amount" class='form-control' value="{{ old('exchange_amount') }}" readonly>
			    <small class="text-danger">{{ $errors->first('exchange_amount') }}</small>
			</div>

			<div class="form-group">    
				<input value="{{ trans('forms.submit_btn') }}" class="btn btn-success" type="submit" onclick="this.disabled=true;this.form.submit();"> 	
				<a href="{{ url('myaccount/externalexchange/create') }}" class="btn btn-primary">{{ trans('forms.reset') }}</a>
			</div>
		</form>
	</div>
</div>
@push('bottomscripts')
	<script type="text/javascript">
		$.ajaxSetup({
			headers: 
			{
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		function getExchangeValue(val)
		{
			$('#exchange_amount').val('');

			var amount = $('#amount').val();

			if(amount>0)
			{
				$.post("{{url("myaccount/externalexchange/getexchange")}}", { amount: amount})
			      .done(function( data ) 
			    {
			        $('#exchange_amount').val(data.final_amount);
			        $('#fee_amount').val(data.fee_total);
			    });
			}
		}
	</script>
@endpush


<div class="col-md-12">


 <form method="post" action="{{ url('myaccount/buycoin')}}" class="form-horizontal">
 {{ csrf_field() }}

    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
	    <label>{{ trans('forms.buy_amount_lbl') }}</label>
	    <input type="text" name="amount" id="amount" class='form-control' value="{{ old('amount') }}" onkeyup="getCurrencyValue(this.val);">
	    <small class="text-danger">{{ $errors->first('amount') }}</small>
	  
	</div>
	
    <div class="form-group{{ $errors->has('fromcurrency') ? ' has-error' : '' }}">
	    <label>{{ trans('forms.fromcurrency_wallet_lbl') }}</label>
         <select class="form-control" id="fromcurrency" name="from_currency" onchange="getCurrencyValue(this.val)">
				@foreach ($currency as $data)
				<option value="{{ $data->currency_id }}" {{ (Form::old("from_currency") == $data->currency_id ? "selected":"") }}>{{ $data->name }}</option>
				@endforeach
		</select>
    </div>


	<div class="form-group">
	    <label>{{ trans('forms.order_amount_lbl') }}</label>
	    <input type="text" name="order_amount" id="order_amount" class='form-control' value="{{old('order_amount')}}" readonly>
	   
	  
	</div>

    <div class="form-group">    
    	<input value="{{ trans('forms.submit_btn') }}" class="btn btn-success" type="submit"> 	
    	<a href="{{ url('myaccount/buycoin') }}" class="btn btn-primary">{{ trans('forms.reset') }}</a>
    	<a href="{{ url('myaccount/buysell') }}" class="btn btn-info">{{ trans('forms.back') }}</a>
    </div>

</form>




</div>
@push('bottomscripts')
<script type="text/javascript">
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

$("#coin").on("change", function(){

	var amount = $('#amount').val();
	var fromcurrency = $('#fromcurrency').val();
	var tocurrency = {{ session('coin_currency_id') }};

	if(amount>0)
	{
		$.post("buy/exchangerate", { amount: amount, fromcurrency: fromcurrency, tocurrency:tocurrency })
	      .done(function( data ) {
	        $('#order_amount').val(data);
	   });
    }

});

function getCurrencyValue(val)
{

	$('#order_amount').val('');
	$('#display_amount').html(val);

	var amount = $('#amount').val();
	var fromcurrency = $('#fromcurrency').val();
	var tocurrency = {{ session('coin_currency_id') }};
	if(amount>0)
	{
		$.post( "buy/exchangerate", { amount: amount, fromcurrency: fromcurrency, tocurrency:tocurrency })
	      .done(function( data ) {
	        $('#order_amount').val(data);
	   });
    }
}



</script>
@endpush


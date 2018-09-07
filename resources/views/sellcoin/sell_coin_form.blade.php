<div class="col-md-12">


 <form method="post" action="{{ url('myaccount/sellcoin')}}" class="form-horizontal">
 {{ csrf_field() }}


	<!-- <div class="form-group {{ $errors->has('amount') ? ' has-error' : '' }}">
	    <label>{{ trans('forms.sell_amount_lbl') }}</label>
    
	   <input id="amount" name="amount" type="range"  min="1" max="100" step="5" class="form-control" onchange="getCurrencyValue(this.value);">

	   <span id="display_amount"></span><br>
	   <small class="text-danger">{{ $errors->first('amount') }}</small>
	</div> -->
	


    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
	    <label>{{ trans('forms.sell_amount_lbl') }}</label>
	    <input type="text" name="amount" id="amount" class='form-control' value="{{ old('amount') }}" onkeyup="getCurrencyValue();">
	    <small class="text-danger">{{ $errors->first('amount') }}</small>
	     <span id="display_amount"></span><br>
	  
	</div>





     <div class="form-group">
	    <label for="fromCurrency">{{ trans('forms.buy_coin_lbl') }}</label>
	 
	    <select class="form-control" id="coin" name="coin">		    
	    	@foreach ($paymentlist as $payment)
	    		<option value="{{ $payment->id }}" {{ (Form::old("coin") == $payment->id ? "selected":"") }}>{{ $payment->displayname }}</option>
	    	@endforeach
	    </select>
	</div>


	

	<div class="form-group">
	    <label>{{ trans('forms.order_amount_lbl') }}</label>
	    <input type="text" name="order_amount" id="order_amount" class='form-control' value="" readonly>
	   
	  
	</div>

	
	

    <div class="form-group">    
    	<input value="{{ trans('forms.submit_btn') }}" class="btn btn-success" type="submit"> 	
    	<a href="{{ url('myaccount/sellcoin') }}" class="btn btn-primary">{{ trans('forms.reset') }}</a>
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
	var fromcurrency = $('#coin').val();
	var tocurrency = {{ session('coin_currency_id') }};

	if(amount>0)
	{
		$.post("sell/exchangerate", { amount: amount, fromcurrency: fromcurrency, tocurrency:tocurrency })
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
	var fromcurrency = $('#coin').val();
	var tocurrency = {{ session('coin_currency_id') }};
	if(amount>0)
	{
		$.post( "sell/exchangerate", { amount: amount, fromcurrency: fromcurrency, tocurrency:tocurrency })
	      .done(function( data ) {
	        $('#order_amount').val(data);
	   });
    }
}


</script>
@endpush


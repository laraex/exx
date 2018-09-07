<div class="grid">
	<form action="{{ url('myaccount/exchange/save') }}" method="post">
	 {{ csrf_field() }}
	 		<div class="grid grid-3 gc-20">
				<div class="form-group">
				    <label for="fromCurrency">You Send</label>
				    <select class="form-control" id="fromcurrency" name="fromcurrency">		    
				    	@foreach ($currency as $data)
				    		<option value="{{ $data->currency_id }}" {{ (Form::old("fromcurrency") == $data->currency_id ? "selected":"") }}>{{ $data->name }}</option>
				    	@endforeach
				    </select>
 			 	</div>
 			 	

				<div class="form-group">
				    <label for="exampleSelect1">You Receive</label>

				     <select class="form-control" id="tocurrency" name="tocurrency" required="required">
				    	<option value="">Select</option>
				    	@foreach ($currency as $data)
				    		<option value="{{ $data->currency_id }}" {{ (Form::old("tocurrency") == $data->currency_id ? "selected":"") }}>{{ $data->name }}</option>
				    	@endforeach
				    </select>
 			 	</div>
 			 	<div class="form-group">
				    <label for="fromCurrencyAmount">Amount</label>
				    <input type="numeric" class="form-control" id="fromcurrencyamount"  placeholder="Enter amount" name="fromamount" required="required" value="{{ old('fromamount') }}"  onkeyup="getCurrencyValue();">
				     <small class="text-danger">{{ $errors->first('fromamount') }}</small>
				  </div>
 			 	<div class="form-group">
				    <label for="toCurrencyAmount">Amount</label>
				    <input type="text" class="form-control" id="tocurrencyamount" readonly name="toamount" required="required" value="{{ old('toamount') }}">

				 </div>
		
				 <div class="form-group">
				    <label for="toCurrencyAmount">Transaction Password</label>
				   <input type="password" name="transaction_password" id="transaction_password" class='form-control' value="" required="required">
       				 <small class="text-danger">{{ $errors->first('transaction_password') }}</small>

				 </div>
				<div class="form-group">
				</div>
				<div class="form-group">
				   <button>Submit</button>
				  </div>
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

$("#tocurrency").on("change", function(){

	var fromcurrencyamount = $('#fromcurrencyamount').val();
	var fromcurrency = $('#fromcurrency').val();
	var tocurrency = $('#tocurrency').val();
	$.post( "exchange/changecurrencyvalue", { fromcurrencyamount: fromcurrencyamount, fromcurrency: fromcurrency, tocurrency:tocurrency })
      .done(function( data ) {
        $('#tocurrencyamount').val(data);
   });

});

function getCurrencyValue()
{
	var fromcurrencyamount = $('#fromcurrencyamount').val();
	var fromcurrency = $('#fromcurrency').val();
	var tocurrency = $('#tocurrency').val();
	$.post( "exchange/changecurrencyvalue", { fromcurrencyamount: fromcurrencyamount, fromcurrency: fromcurrency, tocurrency:tocurrency })
      .done(function( data ) {
        $('#tocurrencyamount').val(data);
   });
}

$("#fromcurrency").on("change", function(){
	
 var x = document.getElementById("tocurrency");

  var from=$(this).val();
  for (var i=0; i<x.length; i++){
  if (x.options[i].value == from )
     x.remove(i);
  }
});

</script>
@endpush
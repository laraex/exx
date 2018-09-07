<div class="col-md-10 col-md-offset-1">
    <form method="post" action="{{ url('myaccount/withdraw')}}" class="form-horizontal">
    {{ csrf_field() }}
	<div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
	    <label>{{ trans('forms.deposit_amount_lbl') }}</label>
	    <input type="text" name="amount" id="amount" class='form-control' value="{{ old('amount') }}">
	    <small class="text-danger">{{ $errors->first('amount') }}</small>
	    <small class="plan_amount"></small>
	</div>

    <div class="form-group{{ $errors->has('transaction_password') ? ' has-error' : '' }}">
        <label>{{ trans('forms.transaction_password_lbl') }}</label>
        <input type="password" name="transaction_password" id="transaction_password" class='form-control' value="">
        <small class="text-danger">{{ $errors->first('transaction_password') }}</small>
    </div>

    @if(Config::get('settings.twofactor_auth_status') == '1')
    <div class="form-group{{ $errors->has('totp') ? ' has-error' : '' }}">
        <label>{{ trans('forms.one_time_password') }}</label>
        <input type="number" class="form-control" name="totp">
        <small class="text-danger">{{ $errors->first('totp') }}</small>
    </div>  
    @endif
    
	<div class="form-group{{ $errors->has('paymentgateway') ? ' has-error' : '' }}">
	    <label>{{ trans('forms.deposit_payment_lbl') }}</label> : 
	    <label>{{ $paymentdisplayname }}</label>
	</div>	
	
	@include('withdraw.userpayaccount')

    <div class="form-group">  
        <input type="hidden" name="paymentgateway" id="paymentgateway" class='form-control' value="{{ $paymentgateway }}"> 
        <input type="hidden" name="currency_id" id="currency_id" class='form-control' value="{{ $currency_id }}">   
    	<input value="{{ trans('forms.submit_btn') }}" class="btn btn-success btn-deposit-success" type="submit"> 	
    	<a href="{{ url('myaccount/withdraw') }}" class="btn btn-default btn-deposit-res">{{ trans('forms.reset') }}</a>
    </div>  

</form>
</div>



@push('bottomscripts')
<script>
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
function userpayaccount(paymentid)
{ 
     $.post( "withdraw/userpayaccount", { paymentid: paymentid })
      .done(function( data ) {
        $('#userpayaccount').html(data);
   });
}

</script>
@endpush


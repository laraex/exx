<div class="col-md-10 col-md-offset-1">
    <form method="post" action="{{ url('myaccount/fundtransfer/store')}}" class="form-horizontal">
    {{ csrf_field() }}
     
    <p>{{ trans('forms.minamount') }}{{ Config::get('settings.fundtransfer_min_amount') }} {{ $currencydetails->name }}</p>
    <p>{{ trans('forms.maxamount') }}{{ Config::get('settings.fundtransfer_max_amount') }} {{ $currencydetails->name }}</p>
    <p>{{ trans('forms.balance') }} : {{ $userbalance }} {{ $currencydetails->name }}</p>

    <div class="form-group{{ $errors->has('sendto') ? ' has-error' : '' }}">
        <label>{{ trans('forms.send_to_user') }}</label>
        <input type="text" name="sendto" id="sendto" class='form-control' value="{{ old('sendto') }}">
        <small class="text-danger">{{ $errors->first('sendto') }}</small>
    </div>

	<div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
	    <label>{{ trans('forms.deposit_amount_lbl') }}</label>
	    <input type="text" name="amount" id="amount" class='form-control' value="{{ old('amount') }}">
	    <small class="text-danger">{{ $errors->first('amount') }}</small>
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

    <div class="form-group">    
    	<input value="{{ trans('forms.submit_btn') }}" class="btn btn-success btn-deposit-success" type="submit"> 	
    	<a href="" class="btn btn-default btn-deposit-res">{{ trans('forms.reset') }}</a>
    </div>  
</form>
</div>

@push('bottomscripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
<script>
$(document).ready(function() {
    src = "{{ url('/myaccount/fundtransfer/searchuser') }}";
    $("#sendto").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term
                },
                success: function(data) {
                    response(data);
                   
                }
            });
        },
        minLength: 2,
       
    });
});
</script>
@endpush


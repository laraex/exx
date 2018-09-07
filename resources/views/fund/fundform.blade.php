<div class="col-md-12">
<div id="depositfrm">

 <form method="post" action="{{ url('myaccount/addfund')}}" class="form-horizontal">
 {{ csrf_field() }}

 	 <input type="hidden" name="paymentgateway" id="paymentgateway" class='form-control' value="{{ $pgs->id }}">

	<div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
	    <label>{{ trans('forms.deposit_amount_lbl') }}</label>
	    <input type="text" name="amount" id="amount" class='form-control' value="{{ old('amount') }}">
	    <small class="text-danger">{{ $errors->first('amount') }}</small>
	    <small class="plan_amount"></small>
	</div>

	

    <div class="form-group">    
    	<input value="{{ trans('forms.submit_btn') }}" class="btn btn-success" type="submit"> 	
    	<a href="{{ url('myaccount/addfund') }}" class="btn btn-primary">{{ trans('forms.reset') }}</a>
    	 <a href="{{ url('myaccount/accounts') }}" class="btn btn-info">{{ trans('forms.backtomywallet') }}</a>
    </div>

</form>

</div>


</div>


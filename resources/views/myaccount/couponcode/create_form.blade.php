<div class="form-control">
	<form method="post" action="" class="form-horizontal">
 		{{ csrf_field() }}

	    <div class="form-group{{ $errors->has('coupon_code') ? ' has-error' : '' }}">
	        <label>{{ trans('admin_coupon.coupon_code') }}</label>
	        <input type="text" name="coupon_code" value="{{ old('coupon_code') }}" class="form-control">
	        <small class="text-danger">{{ $errors->first('coupon_code') }}</small>
	    </div>

	    <div class="form-group">
	        <input value="Submit" class="btn btn-primary" type="submit"> 
	         <input type="reset" class='btn btn-primary'></a>
	    </div>
	</form>
</div>


@push('bottomscripts')

@endpush


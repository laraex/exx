<form method="post" action="{{ url('myaccount/type/bch/send')}}" class="form-horizontal">
{{ csrf_field() }}
    <div class="form-group{{ $errors->has('bch_address') ? ' has-error' : '' }}">
        <label>{{ trans('forms.bch_address_lbl') }}</label>
        <input name="bch_address" class="form-control" value="{{ old('bch_address') }}" id="bch_address" type="text">
        <small class="text-danger">{{ $errors->first('bch_address') }}</small>
    </div>    

    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
        <label>{{ trans('forms.send_amount_lbl') }} (BCH)</label>
        <input name="amount" class="form-control" value="{{  old('amount') }}" id="amount" type="text">
        <small class="text-danger">{{ $errors->first('amount') }}</small>
    </div>      

    <div class="form-group">
   

        <input value="{{ trans('forms.submit_btn') }}" class="btn btn-primary" type="submit" id="myBtn"> 
        <a href="" class='btn btn-default'>{{ trans('forms.reset') }}</a>
    </div>

</form>



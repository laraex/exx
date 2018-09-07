<form method="post" action="{{ url('myaccount/update_transaction_password')}}" class="form-horizontal" id="transaction_password">
{{ csrf_field() }}

    @if ($transactionpassword)
    <div class="form-group{{ $errors->has('old_trans_password') ? ' has-error' : '' }}">
        <label>{{ trans('forms.old_trans_password_lbl') }}</label>
        <input name="old_trans_password" class="form-control" value="{{ old('old_trans_password') }}" type="password">
        <small class="text-danger">{{ $errors->first('old_trans_password') }}</small>
    </div> 
    @endif

    <div class="form-group{{ $errors->has('new_trans_password') ? ' has-error' : '' }}">
        <label>{{ trans('forms.new_trans_password_lbl') }}</label>
        <input name="new_trans_password" class="form-control" value="{{ old('new_trans_password') }}" type="password">
        <small class="text-danger">{{ $errors->first('new_trans_password') }}</small>
    </div>    

    <div class="form-group{{ $errors->has('confirm_trans_password') ? ' has-error' : '' }}">
        <label>{{ trans('forms.confirm_trans_password_lbl') }}</label>
        <input name="confirm_trans_password" class="form-control" value="{{ old('confirm_trans_password') }}" type="password">
        <small class="text-danger">{{ $errors->first('confirm_trans_password') }}</small>
    </div>       

    @if($transactionpassword && Config::get('settings.twofactor_auth_status') == '1')
        <div class="form-group{{ $errors->has('totp') ? ' has-error' : '' }}">
            <label>{{ trans('forms.one_time_password') }}</label>
            <input type="number" class="form-control" name="totp">
            <small class="text-danger">{{ $errors->first('totp') }}</small>
        </div>
    @endif

    <div class="form-group">
        {!! Form::submit(trans('forms.submit_btn'), ['class' => 'btn btn-primary']) !!}
        <a href="" class='btn btn-default'>{{ trans('forms.reset') }}</a>
    </div>
</form>
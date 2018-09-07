<div class="col-md-10 col-md-offset-1">

<form method="post" action="{{ url('myaccount/update_change_password')}}" class="form-horizontal" id="change_password">

{{ csrf_field() }}

    <div class="form-group{{ $errors->has('oldpassword') ? ' has-error' : '' }}">
        <label>{{ trans('forms.oldpassword_lbl') }}</label>
        <input name="oldpassword" class="form-control" value="" type="password">
        <small class="text-danger">{{ $errors->first('oldpassword') }}</small>
    </div> 

    <div class="form-group{{ $errors->has('newpassword') ? ' has-error' : '' }}">
        <label>{{ trans('forms.newpassword_lbl') }}</label>
        <input name="newpassword" class="form-control" value="" type="password">
        <small class="text-danger">{{ $errors->first('newpassword') }}</small>
    </div>

    <div class="form-group{{ $errors->has('confirmpassword') ? ' has-error' : '' }}">
        <label>{{ trans('forms.confirmpassword_lbl') }}</label>
        <input name="confirmpassword" class="form-control" value="" type="password">        
        <small class="text-danger">{{ $errors->first('confirmpassword') }}</small>
    </div>

    <div class="form-group">
        {!! Form::submit(trans('forms.submit_btn'), ['class' => 'btn btn-primary']) !!}
        <a href="" class='btn btn-default'>{{ trans('forms.reset') }}</a>
    </div>

</form>
</div>
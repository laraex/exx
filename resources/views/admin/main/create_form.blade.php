
<div class="col-md-12 ">
<form method="post" action="{{ url('admin/create')}}" class="form-horizontal" id="contact">
{{ csrf_field() }}    
    

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <input name="name" class="form-control" value="{{ old('name') }}" type="text" placeholder="Username">
        <small class="text-danger">{{ $errors->first('name') }}</small>
    </div> 

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <input name="email" class="form-control" value="{{ old('email') }}" type="text" placeholder="Email-id">
        <small class="text-danger">{{ $errors->first('email') }}</small>
    </div>  

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <input name="password" class="form-control" value="{{ old('password') }}" type="password" placeholder="Password">
        <small class="text-danger">{{ $errors->first('password') }}</small>
    </div>

    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <input name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" type="password" placeholder="Confirm Password">
        <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
    </div>

    <!-- <div class="form-group{{ $errors->has('cpassword') ? ' has-error' : '' }}">
        <input name="cpassword" class="form-control" value="{{ old('cpassword') }}" type="password" placeholder="Confirm Password">
        <small class="text-danger">{{ $errors->first('cpassword') }}</small>
    </div>  -->
    
    <div class="form-group">
        {!! Form::submit(trans('forms.submit_btn'), ['class' => 'btn btn-primary']) !!}
        <a href=" " class='btn btn-default'>{{ trans('forms.reset') }}</a>
    </div>
</form>
</div>

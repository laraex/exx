<div class="col-md-12 ">
<form method="post" action="{{ url('admin/users/create/new')}}" class="form-horizontal" id="contact">
{{ csrf_field() }}    
    

    <div class="form-group{{ $errors->has('usergroup') ? ' has-error' : '' }}">
        <select class="form-control" id="usergroup" name="usergroup">
        <option value="">Select User Group</option>
            @foreach ($usergroup as $key=>$usergroup)
                <option value="{{ $key }}" {{ (Form::old("usergroup") == $key ? "selected":"") }}>{{ $usergroup }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('usergroup') }}</small>
    </div>


    {{--<div class="form-group{{ $errors->has('account_type') ? ' has-error' : '' }}">
        <select class="form-control" id="account_type" name="account_type">
        <option value="">Select User Account Type</option>
            @foreach ($account_type as $key=>$account_type)
                <option value="{{ $key }}" {{ (Form::old("account_type") == $key ? "selected":"") }}>{{ $account_type }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('account_type') }}</small>
    </div>--}}

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

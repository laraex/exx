@extends('backpack::layout')

@section('content')
<div class="container mt-40">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
            	@if (session('success'))
                    <div class="alert alert-success">
                     	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('errormessage'))
                    <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session('errormessage') }}
                    </div>
                @endif
                <div class="panel-heading">{{ trans('admin_changepwd.changepass') }}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/changepassword') }}">
                        {{ csrf_field() }}
                         <div class="form-group{{ $errors->has('oldpassword') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">{{ trans('admin_changepwd.oldpwd') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="oldpassword" required>
                                @if ($errors->has('oldpassword'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('oldpassword') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('newpassword') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">{{ trans('admin_changepwd.newpwd') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="newpassword" required>
                                @if ($errors->has('newpassword'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('newpassword') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('confirmpassword') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">{{ trans('admin_changepwd.confirmpwd') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="confirmpassword" required>
                                @if ($errors->has('confirmpassword'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('confirmpassword') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ trans('admin_changepwd.submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
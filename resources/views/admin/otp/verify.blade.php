@extends('layouts.app')

@section('content')
<div class="container mt-40 mb-40">
    <div class="w-480 m-auto">
        <div class="bgd-box-round p-20">
                <h2 class="">{{ trans('admin_otp.verify_otp') }} </h2>
                <div class="">
                   @include('layouts.message')
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/verifyotp') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('otp') ? ' has-error' : '' }}">
                        <label for="otp" class="control-label">{{ trans('admin_otp.enter_otp') }}</label>
                        <div class="">
                            <input id="otp" type="text" class="form-control" name="otp" value="{{ old('otp') }}" >
                            @if ($errors->has('otp'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('otp') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="">
                            <button type="submit" class="btn btn-primary">
                               {{ trans('admin_otp.verify') }} 
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

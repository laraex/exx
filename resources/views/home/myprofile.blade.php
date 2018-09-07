@extends('layouts.app')
@section('content')
<div class="flex container mt-40 mb-40">
          <div class="col col-md-3">
                  @include('home.partials.settingsmenu')
          </div>
        <div class="col col-md-9">
            <h1 class="page-title">{{ trans('myprofile.create_profile') }}</h1>
                        <div class="panel-body">
                           @if (session('mobilecodeerror'))
                            <div class="alert alert-danger">
                             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ session('mobilecodeerror') }}
                            </div>
                            @endif
                            <div class="row bgd-box-round">
                              @include('home.profileform')
                            </div>
        </div>
      </div>
</div>
@endsection

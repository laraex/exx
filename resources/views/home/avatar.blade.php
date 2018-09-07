@extends('layouts.app')

@section('content')
<div class="flex container mt-40 mb-40">
          <div class="col col-md-3">
                  @include('home.partials.settingsmenu')
          </div>
        <div class="col col-md-9">
            <h1 class="page-title">{{ trans('forms.changeavatar') }}</h1>
                        <div class="panel-body bgd-box-round">
                         @if (session('status'))
                                <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session('status') }}
                                </div>
                            @endif  
                            <div class="">
                                @include('home.avatarform')
                            </div>
         
        </div>
      </div>
</div>
            
@endsection

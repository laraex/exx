@extends('layouts.app') 
@section('content')
<div class="flex container mt-40 mb-40">
          <div class="col col-md-3">
                  @include('home.partials.settingsmenu')
          </div>
        <div class="col col-md-9">
            <h1 class="page-title">{{ trans('forms.messageform') }}</h1>
                @include('message.sendform')
            </div>
</div>
    
@endsection


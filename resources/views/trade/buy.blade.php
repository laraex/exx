@extends('layouts.app')
@section('content')
<h1 class="page-title mb-20 dark-text">{{trans('trade.buy_heading')}}</h1>
<div class="d-card w-600">
                @include('partials.message')
                                  
                @include('trade.buy_form')
</div>
@endsection


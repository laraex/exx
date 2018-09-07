@extends('layouts.myaccount')
@section('content')
<h1 class="page-title mb-20 dark-text">{{trans('trade.sell_heading')}}</h1>
<div class="d-card w-600">
                @include('partials.message')
                                  
                @include('trade.sell_form')
</div>
@endsection


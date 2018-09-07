@extends('layouts.myaccount')

@section('content')

<div class="flex flex-c mt-40 mb-40">
    <h1 class="page-title">{{ trans('myaccount.send_bch_to_wallet') }}</h1>
        <div class="bcx-container">

                               @include('partials.message')
                               @include('coin.bch_send_form')
                 
       </div>
</div>
@endsection


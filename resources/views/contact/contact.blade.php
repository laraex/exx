@extends('layouts.app') 

@section('content')
<div class="container">
<h3 class="page-title mb-40 mt-40">{{ trans('forms.contactus_head') }}</h3>
<div class="grid mb-40" style="grid-template-columns: 2fr 1fr; grid-gap:20px;">
    <div class="bgd-box-round ">
        @include('partials.message')
        @include('contact.contactform')
    </div>
    <div class="bgd-box-round p-20">
    <h4>{{ trans('forms.contact_address_head') }}</h4>
    {!! $contactaddress !!}
    </div>
 </div>
</div>              
@endsection


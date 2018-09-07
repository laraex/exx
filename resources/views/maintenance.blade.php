@extends('layouts.app')
@push('additionalstyles')
<style type="text/css">
.otpbox {
    border: 1px solid #000;
    max-width: 420px;
    min-width: 300px;
    background-color: #282828;
    border-radius: 6px;
    padding: 20px 40px;
    color:#fff;
}
.btn-full {
    width: 100%;
}
h1,h2,h3,h4,h5,h6,p{
color:#fff;
    
}
</style>
@endpush
@section('content')
<div class="container">
<center>
<div class="otpbox">
	{!! \Config::get('settings.maintenance_message') !!}
</div>
</center>
@endsection

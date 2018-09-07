@extends('layouts.app')
@section('content')
<div class="flex container mt-40 mb-40">
    <div class="col col-md-3">
        @include('home.partials.settingsmenu')
    </div>
    <div class="col col-md-9">
        <h1 class="page-title">{{ trans('forms.2fa_secret_key') }} </h1>
            @if (session('errormessage'))
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('errormessage') }}
                </div>
            @endif
            @if (session('successmessage'))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('successmessage') }}
                </div>
            @endif
        <div class="panel panel-default">
            <div class="panel-body">
                {{ trans('forms.2fa_qr_code_text') }}
                <br />
                <img alt="Image of QR barcode" src="{{ $image }}" />
                <br />
                {{ trans('forms.2fa_qr_code_content') }}<code>{{ $secret }}</code>
                <br /><br />
                <a href="{{ url('/myaccount/2fa/validate') }}">{{ trans('forms.next_btn') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('transaction.transaction') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('transaction.transaction') }}</li>
      </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ trans('forms.external_exchange_transactions') }}</div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                  @include('admin.exchange.tabs')
                  @include('partials.message')
                  @include('admin.transaction.show_crypto_list')
   
                </div>
            </div>
        </div>
    </div>
@endsection

   
        












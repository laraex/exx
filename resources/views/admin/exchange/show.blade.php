@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>{{ trans('admin_exchange.exchange_list') }}</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('admin_exchange.exchange_list') }}</li>
      </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ trans('admin_exchange.user_exchange') }}</div>
                      <a href="{{ url('admin/exportexchange') }}" class="btn btn-success pull-right">{{ trans('export.exports') }}</a>
                </div>
                <div class="row">
                     <div class="col-md-12">
                            </div>
                  <div class="col-sm-12">
                            @include('admin.exchange.list')
                         
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection


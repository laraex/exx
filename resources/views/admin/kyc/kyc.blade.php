@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('admin_kyc.security_list') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('admin_kyc.security_list') }}</li>
      </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ trans('admin_kyc.security_list') }}</div>
                </div>
                <div class="row">
                     <div class="col-md-12">
                                @include('partials.message')
                            </div>
                  <div class="col-sm-12">
                         
                        @include('admin.kyc.kyc_list')
                        
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection








@extends('backpack::layout')
    @section('header')
        <section class="content-header">
          <h3>{{ trans('admin_fundtransfer.fundtransfer') }}</h3> 
          <a href="{{ url('admin/exportfundtrans') }}" class="btn btn-success pull-right">{{ trans('export.exports') }}</a>  
          <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">{{ trans('admin_fundtransfer.fundtransfer') }}</li>
          </ol>
        </section>
    @endsection

    @section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <div class="box-title">
                          {{ trans('admin_fundtransfer.fund_list') }}
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                      @include('partials.message')
                      @include('adminpartials._fundtransferlist')
                    </div>
                </div>
            </div>
        </div>
    @endsection

   
        


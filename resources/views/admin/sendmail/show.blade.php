@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('mail.send_mail') }} 
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('mail.send_mail') }}</li>
      </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ trans('mail.send_mail_list') }}</div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                  @include('partials.message')
                  @include('admin.sendmail.send_list')
   
                </div>
            </div>
        </div>
    </div>
@endsection



        


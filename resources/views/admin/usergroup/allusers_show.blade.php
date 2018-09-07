@extends('backpack::layout')
    @section('header')
        <section class="content-header">
          <h1>{{ trans('admin_usergroup.usergroup') }}</h1>
          <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">{{ trans('admin_usergroup.usergroup') }}</li>
          </ol>
        </section>
    @endsection

    @section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <div class="box-title">{{ trans('admin_usergroup.usergroup') }}</div>
                        <a  href="{{ url('admin/usergroup/create') }}" class="btn btn-success pull-right">{{ trans('admin_usergroup.create_usergroup') }}</a>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @include('partials.message')
                        </div>
                        <div class="col-sm-12">
                            @include('admin.usergroup.allusers_show_form') 
                      </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection








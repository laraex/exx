@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ ucfirst($actionname) }} {{ trans('admin_action.list') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ ucfirst($actionname) }} {{ trans('admin_action.list') }}</li>
      </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ ucfirst($actionname) }} {{ trans('admin_action.list') }}</div>
                </div>
                <div class="row">
                     <div class="col-md-12">
                                @include('partials.message')
                            </div>
                  <div class="col-sm-12">
                          @if ($actionname == 'kyc')
                            @include('adminpartials._kycuserlist')
                          @elseif ($actionname == 'fund')
                            @include('adminpartials._pending_deposit_fund')
                          @endif
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection


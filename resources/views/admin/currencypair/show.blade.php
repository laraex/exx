@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>{{ trans('admin_currencypair.currencypairlist') }}</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('admin_currencypair.list') }}</li>
      </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ trans('admin_currencypair.currencypairlist') }} </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                  @include('partials.message')
                  @include('admin.currencypair.show_list')
   
                </div>
            </div>
        </div>
    </div>
@endsection
  @include('admin.datatable')

  @push('scripts')
  <script>
      $(document).ready(function(){
          $('#userdatatable').DataTable();
      });
  </script>
  @endpush



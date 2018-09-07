@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Admin
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">Admin Lists</li>
      </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Admin Lists</div>
                </div>
                <div class="row">
                  <div class="col-sm-12">

                 

                  
                  @include('admin.main.show_list')
   
                </div>
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



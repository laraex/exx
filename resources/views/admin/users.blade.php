@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        Users
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('admin_user.user_lists') }}</li>
      </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ trans('admin_user.user_lists') }}</div>
                </div>
                           <div class="dropdown pull-right">
    <button class="btn btn btn-success dropdown-toggle " type="button" data-toggle="dropdown">{{ trans('export.exports') }}
    <span class="caret"></span></button>
    <ul class="dropdown-menu">
      <li><a href="{{ url('admin/exportusers') }}">CSV</a></li>
      <li><a href="{{ url('admin/exportusersxls') }}">XLS</a></li>
     
    </ul>
  </div> <br><br>
                <div class="row">
                  <div class="col-sm-12">
                  <form  method="POST" role="search">
                      {{ csrf_field() }}
                      <div class="input-group">
                          <input type="text" class="form-control" name="q"
                              placeholder="Search users by Username or Email"> <span class="input-group-btn">
                              <button type="submit" class="btn btn-default">
                                  <span class="glyphicon glyphicon-search"></span>
                              </button>
                          </span>
                      </div>
                  </form>
                  @include('partials.message')
                  @include('adminpartials._user_list')
   
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



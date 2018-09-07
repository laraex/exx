@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('admin_coupon.recent_buy') }} 
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('admin_coupon.list') }}</li>
      </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ trans('admin_coupon.recent_buy') }}</div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                   <form  method="POST" role="search">
                      {{ csrf_field() }}
                      <div class="input-group">
                          <input type="text" class="form-control" name="q"
                              placeholder="Search users by Username or Coupon Code or Txn Id or Amount"> <span class="input-group-btn">
                              <button type="submit" class="btn btn-default">
                                  <span class="glyphicon glyphicon-search"></span>
                              </button>
                          </span>
                      </div>
                  </form>
                
                  @include('partials.message')
                  @include('admin.couponcode.show_form')
   
                </div>
            </div>
        </div>
    </div>
@endsection

     


 



        


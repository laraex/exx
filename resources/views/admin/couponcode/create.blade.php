@extends('backpack::layout')
    @section('header')
        <section class="content-header">
          <h1>{{ trans('admin_coupon.coupon_code') }}</h1>
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
                             
                                @include('admin.couponcode.create_form')
                            
                      </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection








@extends('layouts.app')
  @section('content')
    <div class="container">
      @include('partials.message')
        <div class="col-md-12 mb-20 mt-20">
          @include('myaccount.couponcode.create_form')
        </div>
    </div>
  @endsection



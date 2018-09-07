@extends('backpack::layout') 
@section('header')
    <section class="content-header">
      <h1>
        {{ trans('forms.msg_list') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('forms.msg_list') }}</li>
      </ol>
    </section>
@endsection

@section('content')
<section class="section">
  <div class="panel panel-default"> 
    <div class="panel-body">              
            @include('partials.message')                           
            @include('admin.message.lists')  
    </div>
 </div>
</section>
@endsection

@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('forms.ticketlists') }} 
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('forms.ticket') }} </li>
      </ol>
    </section>
@endsection



@section('content')
<section class="section">


                 <div class="panel panel-default">
   
    <div class="panel-body">
                @if (session('status'))
                <div class="alert alert-success">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('status') }}
                </div>
                @endif

       
                           
                        @include('admin.tickets.ticketlists')
   
    </div>
 </div>



</section>
@endsection

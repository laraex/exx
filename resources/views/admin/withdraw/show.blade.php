@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('admin_withdraw.withdraw_lists') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('admin_withdraw.withdraw_lists') }}</li>
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

                @if (session('successmessage'))
                <div class="alert alert-success">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('successmessage') }}
                </div>
                @endif
                
               <!--  @if (session('errormessage'))
                <div class="alert alert-success">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('errormessage') }}
                </div>
                @endif -->
            
                @if ($status == 'request')    
                    @include('admin.withdraw.requestlists')
                @elseif ($status == 'pending')    
                    @include('admin.withdraw.pendinglists')
                @elseif ($status == 'rejected')
                    @include('admin.withdraw.rejectedlists')
                @elseif ($status == 'completed')
                    @include('admin.withdraw.completedlists')
                @endif
   
    </div>
 </div>

</section>
@endsection








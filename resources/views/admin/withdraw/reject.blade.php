@extends('backpack::layout') 
@section('content')
<section class="section">

    <div class="row">
        <div class="container">
            <h3>{{ trans('admin_withdraw.withdraw_reject_form') }}</h3>
            <p class="pull-right"><a href="{{ url('admin/withdraw/pending') }}">{{ trans('admin_withdraw.back') }}</a></p>
                 <div class="panel panel-default">
   
    <div class="panel-body">
       
        <div class="row">
            <div class="col-md-12">
                         
                            @include('admin.withdraw.rejectform')
                       
            </div>
        </div>
    </div>
 </div>
            </div>
        </div>


</section>
@endsection

@extends('backpack::layout')
@section('content')
<section class="section">

    <div class="row">
        <div class="container">
            <h3>{{ trans('forms.ticketlists') }}sds</h3>
                 <div class="panel panel-default">
   
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                <div class="alert alert-success">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('status') }}
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="box-header with-border">
                           
                        @include('staff.tickets.ticketlists')
                            
            </div>
        </div>
    </div>
 </div>
            </div>
        </div>


</section>
@endsection

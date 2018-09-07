@extends('backpack::layout')

@section('content')
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('forms.changepassword') }}</div>

                <div class="panel-body">
                <div class="row">
                        <div class="col-md-12">
                        @if (session('successmessage'))
                                <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session('successmessage') }}
                                </div>
                            @endif
                            @if (session('errormessage'))
                                <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session('errormessage') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                      @include('staff.changepasswordform')
                    </div>                     
                </div>
               </div>
@endsection

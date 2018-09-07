@extends('layouts.app')
@section('content')
<div class="flex container mt-40 mb-40">
          <div class="col col-md-3">
                  @include('home.partials.settingsmenu')
          </div>
        <div class="col col-md-9">
                 <h1 class="page-title">{{ trans('forms.transactionpassword') }} </h1>
                        @if (!is_null($transactionpassword))   
                        <a href="{{ url('/myaccount/rest_transaction_password') }}" class="btn btn-primary btn-xs pull-right" id="transaction_password_click">{{ trans('forms.transaction_password_reset_btn') }}</a>
                        @endif

                           @if (session('errormessage'))
                                <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session('errormessage') }}
                                </div>
                            @endif

                            @if (session('successmessage'))
                                <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session('successmessage') }}
                                </div>
                            @endif
                            <div class="bgd-box-round p-20">
                              @include('home.transactionpasswordform')
                            </div>
        </div>
</div>
@endsection

@push('bottomscripts')
    <script>  
         $("#transaction_password_click").on("click", function(){
            return confirm("{{ trans('forms.transaction_password_confirm_alert') }}");
        });
    </script>
@endpush

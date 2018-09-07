@extends('layouts.app')
@section('content')


            <div class="flex container mt-40 mb-40">
            <div class="col col-md-3">
                  @include('home.partials.settingsmenu')
          </div>
           <div class="col col-md-9">
          <div class="container">
                @include('partials.message')             
                @include('home.mypayaccounts_bank_create_form')
                </div>
            </div>
    </div>
@endsection

@push('bottomscripts')
<!-- Modal Js -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js">
</script>
<!-- End Modal Js -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
{{--<script src="{{ asset('js/custom.js') }}"></script>--}}
<script src="{{ asset('js/jquery.validate.js') }}"></script>
@endpush
@extends('layouts.app')
@section('content')
<div class="container mt-20 mb-20">
<h1 class="page-title dark-text">{{ trans('myaccount.transactionhistory') }}</h1>
  @include('partials.message')

<div class="container bgd-box-round">
  
 
                 @include('transaction.show_transaction')

          
</div>
</div>
      @endsection
@push('bottomscripts')

<script>

function ChangeStatus(val){
alert(val);
  window.location.href ="/myaccount/tradehistory/show/transhistory/"+$val;
}

</script>
@endpush
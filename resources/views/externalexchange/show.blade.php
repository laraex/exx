@extends('layouts.app')

@section('content')
<div class="container">
  @include('transaction._tabs')
</div> 
<div class="flex container mt-40 mb-40">
  <div class="col col-md-9">
    <h1 class="page-title">{{ trans('forms.external_exchange_transactions') }}</h1>
      <div class="panel-body">                  
        <div class="row">
          @include('partials.message')
				    <div class="col-md-12">
              @include('externalexchange.show_list')
						</div>
        </div>                 
      </div>
  </div>
</div>
@endsection


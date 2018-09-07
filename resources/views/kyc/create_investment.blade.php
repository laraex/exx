@extends('layouts.app')
@section('content')

            <div class="flex container mt-40 mb-40">
            <div class="col col-md-3">
                  @include('home.partials.settingsmenu')
          </div>
           <div class="col col-md-9 bgd-box-round p-20">

                           @include('kyc.kyc_tabs')
                <h4 class="mt-20" >{{trans('forms.kyc_investment_title')}}</h4>                 
                @include('partials.message')
	      @if((is_null($information->status))&&($userprofile->kyc_approved==0))       
	        @include('kyc.create_investment_form')
	    @else
	      <p>{{trans('forms.kyc_financialmessage')}}</p>
	    @endif

                </div>
            </div>
    </div>
@endsection











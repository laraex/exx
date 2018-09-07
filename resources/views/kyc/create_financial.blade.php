@extends('layouts.app')

@section('content')
<div class="flex container mt-40 mb-40">
	<div class="col col-md-3">
        @include('home.partials.settingsmenu')
    </div>
	<div class="col col-md-9 bgd-box-round p-20">
	 	@include('kyc.kyc_tabs')

            <h4 class="mt-20">{{trans('forms.kyc_financial_title')}}</h4>

                                @include('partials.message')
                    @if(($userprofile->bank_verified != 1) &&($userprofile->kyc_approved==0))
		                <p>{{trans('forms.kyc_financial_text1')}}</p>
		                <p>{{trans('forms.kyc_financial_text2')}}</p>
                        <ul>
                        <li>{{trans('forms.kyc_financial_text3')}}</li>
                        <li>{{trans('forms.kyc_financial_text4')}}</li>
                        <li>{{trans('forms.kyc_financial_text5')}}</li>
                        </ul>
                   <div class="">                
                         @include('kyc.create_financial_form')
                   </div>

                   @else
                    <p>{{trans('forms.kyc_financialmessage')}}</p>

                   @endif
                 
    </div>  
</div>
@endsection










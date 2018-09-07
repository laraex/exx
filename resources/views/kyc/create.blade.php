@extends('layouts.app')

@section('content')
<div class="flex container mt-40 mb-40">
	<div class="col col-md-3">
        @include('home.partials.settingsmenu')
    </div>
	<div class="col col-md-9 bgd-box-round p-20">
	 	@include('kyc.kyc_tabs')

            <h4 class=" mt-20">{{trans('forms.kyc_title')}}</h4>
                @include('partials.message')
                @if(($userprofile->user->isKycApproved == 1) ||($userprofile->kyc_approved==1))               
                <p>{{trans('forms.kyc_message')}}</p>
         
                @else
                 <p>{{trans('forms.kyc_text1')}}</p>
                <p>{{trans('forms.kyc_text2')}}</p>
                <p>{{trans('forms.kyc_text3')}}</p>
                @include('kyc.create_form')
                @endif
                 
    </div>  
</div>
@endsection



@extends('layouts.app')

@section('content')

<div class="flex container mt-40 mb-40">
          <div class="col col-md-3">
                  @include('fund.partials._sidebar_fund')
          </div>
        <div class="col col-md-9">
            <h1 class="page-title">{{ trans('forms.add_fund') }}</h1>
                        <div class="panel-body">
                   @if (session('error'))
                        <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ session('error') }}
                        </div>
                    @endif

                     @if (\Config::get('settings.force_deposit_down') == 0)       


                @if (\Config::get('settings.force_email_verification_for_deposit') == 0 && \Config::get('settings.force_kyc_verification_for_deposit') == 0) 

                   <div class="row">
                               @include('fund.fundform')
                            </div>                 

                    
                @else
                    
                         @if (\Config::get('settings.force_email_verification_for_deposit') == 1 || \Config::get('settings.force_kyc_verification_for_deposit') == 1) 


                                @if ($isEmailVerified == 0 && \Config::get('settings.force_email_verification_for_deposit') == 1)
                                     <p>{{ trans('forms.email_verification_incomplete_deposit_alert') }}</p>

                                @else
                                    @if (($isKycApproved  == 0 || $isKycApproved ==2) && \Config::get('settings.force_kyc_verification_for_deposit') == 1)
                                         <p>{{ trans('forms.kyc_incomplete_deposit_alert') }}</p>
                                                <a href="{{ url('/myaccount/profile') }}" class="btn btn-primary btn-lg">{{ trans('forms.ctabutton') }}</a>

                                    @else
                                        <div class="row">
                               @include('fund.fundform')
                            </div>
                                    @endif
                                    
                                @endif

                        @endif
                @endif

            @else
                    <div class="row">                    
                    <p>{{ trans('forms.force_deposit_down_info_message') }}</p>
                </div>

            @endif

                            
        </div>
      </div>
</div>
@endsection

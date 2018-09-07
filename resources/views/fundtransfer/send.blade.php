@extends('layouts.app')

@section('content')

<div class="flex container mt-40 mb-40">
          <div class="col col-md-3">
                  @include('fund.partials._sidebar_fund')
          </div>
        <div class="col col-md-9">
            <h1 class="page-title">{{ trans('forms.fund_transfer_form') }}</h1>
             <a href="{{ url('myaccount/fundtransfer/type/send') }}" class="pull-right">{{ trans('forms.back_to_list') }}</a>
                <div class="panel-body">
                     @include('partials.message')
                        <div class="row">

                          @if ($force_email_verification_for_fund_transfer == 0 && $force_kyc_verification_for_fund_transfer == 0)

                 @if (is_null($transaction_password))

                            <center>
                                    <p>{{ trans('forms.transaction_password_fund_transfer_alert') }}</p>
                                        <a href="{{ url('/myaccount/transactionpassword') }}" class="btn btn-primary btn-lg">{{ trans('forms.transaction_password_button_alert') }}</a>
                            </center>
                @else
           
                   @include('fundtransfer.fundtransferform') 

                 @endif             

                    
                @else
                    
                         @if ($force_email_verification_for_fund_transfer == 1 || $force_kyc_verification_for_fund_transfer == 1) 


                                @if ($isEmailVerified == 0 && $force_email_verification_for_fund_transfer == 1)
                                     
                                      <p>{{ trans('forms.email_verification_incomplete_fund_transfer_alert') }}</p>

                                @else
                                    @if (($isKycApproved  == 0 || $isKycApproved ==2) && $force_kyc_verification_for_fund_transfer == 1)

                                           <p>{{ trans('forms.kyc_incomplete_fund_transfer_alert') }}</p>
                                            <a href="{{ url('/myaccount/profile') }}" class="btn btn-primary btn-lg">{{ trans('myaccount.ctabutton') }}</a>

                                    @else
                                        @include('fundtransfer.fundtransferform') 
                                    @endif
                                    
                                @endif

                        @endif           
                                         
            @endif

</div>
        </div>
      </div>
</div>
@endsection


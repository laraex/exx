@extends('layouts.app')

@section('content')

<div class="flex container mt-40 mb-40">
          <div class="col col-md-3">
                  @include('fund.partials._sidebar_fund')
          </div>
        <div class="col col-md-9">
                  <div class="flex">
                          <div class="page-title">{{ trans('forms.withdrawrequest') }}  </div>
                          <div class="ml-auto">
                                      <a href="{{ url('myaccount/withdraw/pending') }}" class="btn btn-sm btn-primary">
                                      {{ trans('forms.go_to_list') }}</a>
                          </div>
                  </div>
            <hr>
                        <div class="panel-body">
                   
                @include('partials.message')
                <div class="flex">
                      <div class="withdraw-amount-info">{{ trans('forms.minamount') }}{{ Config::get('settings.withdraw_min_amount') }} {{ $currencydetails->name }}</div>
                      <div class="withdraw-amount-info">{{ trans('forms.maxamount') }}{{ Config::get('settings.withdraw_max_amount') }} {{ $currencydetails->name }}</div>
                      <div class="withdraw-amount-info">{{ trans('forms.balance') }} : {{ $userbalance }} {{ $currencydetails->name }}</div>
                 </div> 
                 <div class="flex mt-20 mb-20">
                 <div class="limit-box limit-box-1">
                       <p>{{ trans('forms.total_monthly_withdraw_limit') }} : <span class="label label-warning">{{ \Config::get('settings.monthly_withdraw_limit') }}</span></p>
                      <p>{{ trans('forms.user_withdraw_taken_count') }} : <span class="label label-success">{{ $user_withdraw_count }}</span></p>
                      <p>{{ trans('forms.remaining_monthly_withdraw_limit') }} : <span class="label label-danger">{{ $monthly_remaining_withdraw_limit }}</span></p>
                 </div> 
                 <div class="limit-box limit-box-2">
                <p>{{ trans('forms.total_daily_withdraw_limit') }} : <span class="label label-warning">{{ \Config::get('settings.daily_withdraw_limit') }}</span></p>

                <p>{{ trans('forms.daily_withdraw_taken_count') }} : <span class="label label-success">{{ $daily_withdraw_taken_count }}</span></p>

                <p>{{ trans('forms.daily_remaining_withdraw_limit') }} : <span class="label label-danger">{{ $daily_remaining_withdraw_limit }}</span></p>

                 </div>
                 </div>
                 </div>
            

        <div class="row">

            @if ($force_withdraw_down == 0)       

            <div class="col-md-10">

                @if ($force_email_verification_for_withdraw == 0 && $force_kyc_verification_for_withdraw == 0) 

                  @if (is_null($transaction_password))
                   <center>
                                    <p>{{ trans('forms.transaction_password_withdraw_transfer_alert') }}</p>
                                        <a href="{{ url('/myaccount/transactionpassword') }}" class="btn btn-primary btn-lg">{{ trans('forms.transaction_password_button_alert') }}</a>
                            </center>
                @else
           

                    @include('withdraw.withdrawform')    

                @endif              

                    
                @else
                    
                         @if ($force_email_verification_for_withdraw == 1 || $force_kyc_verification_for_withdraw == 1) 


                                @if ($isEmailVerified == 0 && $force_email_verification_for_withdraw == 1)
                                      <p>{{ trans('forms.email_verification_incomplete_withdraw_alert') }}</p>

                                @else
                                    @if (($isKycApproved  == 0 || $isKycApproved ==2) && $force_kyc_verification_for_withdraw == 1)
                                         <p>{{ trans('forms.kyc_incomplete_withdraw_alert') }}</p>
                                    <a href="{{ url('/myaccount/profile') }}" class="btn btn-primary btn-lg">{{ trans('myaccount.ctabutton') }}</a>

                                    @else
                                        @include('withdraw.withdrawform')
                                    @endif
                                    
                                @endif

                        @endif
                @endif

            @else
                <div class="col-md-10">
                    <p>{{ trans('forms.force_withdraw_down_info_message') }}</p>
                </div>

            </div>
            @endif
                            </div>
        </div>
      </div>
</div>
@endsection


<div class="tab-container">
	<div class="row">
	<div class="col-md-12">
		<h4>{{ trans('admin_user.user_profile') }}</h4>
	</div>
		@include('partials.message')
	</div>
	<div class="row">
		<div class="col-md-4 p-20">
			<table class="table">
				<tr>
					<td>{{ trans('admin_user.first_name') }}</td>
					<td>{{ $user->userprofile->firstname }} </td>
				</tr>
				<tr>
					<td>{{ trans('admin_user.last_name') }}</td>
					<td>{{ $user->userprofile->lastname }} </td>
				</tr>				
				@if(Config::get('settings.address1'))
				<tr>
					<td>{{ trans('admin_user.address1') }}</td>
					<td>{{ $user->userprofile->address1}} </td>
				</tr>
				@endif
				@if(Config::get('settings.address2'))
				<tr>
					<td>{{ trans('admin_user.address2') }}</td>
					<td>{{ $user->userprofile->address2}} </td>
				</tr>
				@endif
				@if(Config::get('settings.city'))
				<tr>
					<td>{{ trans('admin_user.city') }}</td>
					<td>{{ $user->userprofile->city}} </td>
				</tr>
				@endif
				@if(Config::get('settings.state'))
				<tr>
					<td>{{ trans('admin_user.state') }}State : </td>
					<td>{{ $user->userprofile->state}} </td>
				</tr>
				@endif
				<tr>
					<td>{{ trans('admin_user.country') }}</td>
					<td>{{ $user->userprofile->Country != '' ? $user->userprofile->Country->name : ''}} </td>
				</tr>
				<tr>
					<td>{{ trans('admin_user.mobile') }}</td>
					<td>{{ $user->userprofile->mobile }} </td>
				</tr>
				{{--<tr>
					<td>{{ trans('admin_user.ssn') }} </td>
					<td>{{ $user->userprofile->ssn }} </td>
				</tr>
				<tr>
					<td>{{ trans('admin_user.document') }}</td>
					<td>
					@if ($user->userprofile->kyc_doc != '')					
					<form method="post" action="{{ url('admin/users/attachdocdownload/'.$user->userprofile->id.'') }}">
	                {{ csrf_field()}}
	                <div class="form-group">
	                          <button type="submit" class="btn btn-default btn-xs">{{ $user->userprofile->kyc_doc }}</button>
	                  </div>
	                </form>
	                @if ( $user->userprofile->kyc_verified == 0)            

	                 <div>
                        <form method="post" class="approvekyc" action="{{ url('admin/users/verifykyc/'.$user->userprofile->id.'') }}">
                            {{ csrf_field() }} 
                            {!! Form::submit(trans('forms.verifykyc'), ['class' => 'btn btn-success btn-sm flex-button']) !!}
                        </form>
                    </div>
                    <div>
                         <form method="post" class="rejectkyc" action="{{ url('admin/users/rejectkyc/'.$user->userprofile->id.'') }}">
                            {{ csrf_field() }} 
                            {!! Form::submit(trans('forms.rejectkyc'), ['class' => 'btn btn-danger btn-sm flex-button']) !!}
                        </form>

                </div>
                	@elseif( $user->userprofile->kyc_verified == 2)
	                 <span class="label label-danger">{{ trans('admin_user.reject') }}</span>
	                @else
	                 <span class="label label-success">{{ trans('admin_user.verify') }}</span>
	                @endif
	                @endif
					</td>
				</tr>--}}
			</table>
		</div>


{{--             <div class="col-md-8 p-20">
            <div class="spacer-120"><p>&nbsp;</p></div>
            <table class="table table-striped">
                @if($paypal)
                <tr>
                    <td>Paypal</td>
                    <td>
                        @if(count($paypal_result) > 0)
                        @include('adminpartials._userpayaccouts_paypal_list')
                        @else
                        No Paypal Account Found.
                        @endif                      
                    </td>
                </tr>
                @endif
                @if($bank)
                <tr>
                    <td>Bank Account</td>
                    <td>
                        @if(count($bankwire_result) > 0)
                        @include('adminpartials._userpayaccouts_bankwire_list')
                        @else
                        No Bank wire Account Found.
                        @endif      
                    </td>
                </tr>
                @endif
                @if($stp)
                <tr>
                    <td>Solidtrust Pay</td>
                    <td>
                        @if(count($stpay_result) > 0)
                        @include('adminpartials._userpayaccouts_stpay_list')
                        @else
                        No Solidtrust Pay Account Found.
                        @endif                      
                    </td>
                </tr>
                @endif
                @if($payeer)
                <tr>
                    <td>Payeer</td>
                    <td>
                        @if(count($payeer_result) > 0)
                        @include('adminpartials._userpayaccouts_payeer_list')
                        @else
                        No Payeer Account Found.
                        @endif          

                    </td>
                </tr>
                @endif
                @if($advcash)
                <tr>
                    <td>AdvCash</td>
                        <td>
                            @if(count($advcash_result) > 0)
                            @include('adminpartials._userpayaccouts_advcash_list')
                            @else
                            No AdvCash Account Found.
                            @endif                      
                        </td>
                </tr>
                @endif
                @if($bitcoin_direct)
                <tr>
                    <td>Bitcoin Wallet</td>
                    <td>
                        @if(count($bitcoin_result) > 0)
                        @include('adminpartials._userpayaccouts_bitcoin_list')
                        @else
                        No Bitcoin Wallet Found.
                        @endif          
                    </td>
                </tr>
                @endif
                @if($skrill)
                <tr>
                    <td>Skrill</td>
                    <td>
                        @if(count($skrill_result) > 0)
                        @include('adminpartials._userpayaccouts_skrill_list')
                        @else
                        No Skrill Account Found.
                        @endif      
                    </td>
                </tr>
                @endif
                @if($okpay)
                <tr>
                    <td>Okpay</td>
                    <td>
                        @if(count($okpay_result) > 0)
                        @include('adminpartials._userpayaccouts_okpay_list')
                        @else
                        No Okpay Account Found.
                        @endif      
                    </td>
                </tr>
                @endif
                @if($perfectmoney)
                <tr>
                    <td>PerfectMoney</td>
                    <td>
                        @if(count($pm_result) > 0)
                        @include('adminpartials._userpayaccouts_perfectmoney_list')
                        @else
                        No PerfectMoney Account Found.
                        @endif                      
                    </td>
                </tr>                   
                @endif

                @if($neteller)
                <tr>
                    <td>Neteller</td>
                    <td>
                        @if(count($neteller_result) > 0)
                        @include('adminpartials._userpayaccouts_neteller_list')
                        @else
                        No No Neteller Account Found.
                        @endif                      
                    </td>
                </tr>                   
                @endif


                 @if($paypal == '0' && $bank == '0' && $stp == '0' && $payeer == '0' && $advcash == '0' && $bitcoin_direct == '0' && $skrill == '0' && $okpay == '0' && $perfectmoney == '0' && $neteller == '0')
                      <tr>
                            <td>No Withdraw Payments Found.</td>
                       
                       </tr>
                    @endif
            </table>
        </div> --}}


        
	</div>
	</div>


@push('scripts')
<script>
    $(".update").on("submit", function(){
        return confirm("{{ trans('admin_user.change_status') }}");
    });

    $(".approvekyc").on("submit", function(){
        return confirm("{{ trans('admin_user.approve_kyc') }}");
    });

     $(".rejectkyc").on("submit", function(){
        return confirm("{{ trans('admin_user.reject_kyc') }}");
    });

    $("#reset").on("click", function()
    {
        return confirm("{{ trans('admin_user.pwd_reset') }}");
    });

    $("#resetpwd").on("click", function(){
        return confirm("{{ trans('admin_user.reset_transaction') }}");
    });

     
</script>
@endpush
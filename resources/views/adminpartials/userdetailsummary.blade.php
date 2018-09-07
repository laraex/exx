<div class="mt-20 mb-20">
    <div class="row">
        <div class="col-md-12">
            <h2> {{ trans('admin_user.username') }} {{ $user->name }} 
                <span class="pull-right">
                    <small>{{ trans('admin_user.email') }} <a href="mailto:{{ $user->email }}">{{ $user->email }} </a> | {{ trans('admin_user.since') }} {{ $user->created_at->diffForHumans() }}</small>
                </span> 
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="well grid grid-user-summary gc-20">
        <div class="grid-item">
            @if($user->userprofile->profile_avatar != '')
            <img width="120px" height="120px"  src="{{  url('/uploads/'.$user->userprofile->profile_avatar)  }}" style="padding-right: 20px">
            @else
            <img src="https://placehold.it/120x120?text=Your+Avatar" style="padding-right: 20px">
            @endif
        </div>
        <div class="grid-item">
            <p> {{ trans('admin_user.first_name') }} {{ $user->userprofile->firstname }} </p>
            <p> {{ trans('admin_user.last_name') }} {{ $user->userprofile->lastname }}</p>
            <p> {{ trans('admin_user.mobile') }} {{ $user->userprofile->mobile }}</p>
            <p> {{ trans('admin_user.country') }} {{ $user->userprofile->Country != '' ? $user->userprofile->Country->name : ''}}</p>
        </div>

        <div class="grid-item">
            <p>{{ trans('admin_user.email_verify') }} 
                @if($user->userprofile->email_verified == 0)
                    <span class="label label-danger">{{ trans('admin_user.unverify') }}</span>
                @else
                    <span class="label label-success">{{ trans('admin_user.verify') }}</span>
                @endif
            </p>

            <p>{{ trans('admin_user.mobile_verify') }}
                 @if($user->userprofile->mobile_verified == 0)
                <span class="label label-danger">{{ trans('admin_user.unverify') }}</span>
                @else
                <span class="label label-success">{{ trans('admin_user.verify') }} Verified</span>
                @endif
            </p>

            <p>{{ trans('admin_user.user_status') }} 
                @if($user->userprofile->active == 0)
                <span class="label label-danger">{{ trans('admin_user.suspend') }}</span>
                @else
                <span class="label label-success">{{ trans('admin_user.active') }}</span>
                @endif
            </p>
        </div>
                       
        <div class="grid-item">
            <p>{{ trans('admin_user.kyc') }}
            @if(($user->isKycApproved == 1)||($user->userprofile->kyc_approved==1))
            <span class="label label-success">{{ trans('admin_user.kyc') }}</span>
            @elseif( $user->isKycApproved == 0 || $user->isKycApproved == 2)
            <span class="label label-danger">{{ trans('admin_user.kyc') }}</span>
            @endif

            @if (($user->userprofile->bank_verified == '1')||($user->userprofile->kyc_approved==1))
            <span class="label label-success">{{ trans('admin_user.kyc_bank') }}</span>
            @elseif(($user->userprofile->bank_verified != '1')||(!is_null($user->userprofile->bank_attachment)))
            <span class="label label-danger">{{ trans('admin_user.kyc_bank') }}</span>
            @endif
            </p>

            <p> {{ trans('admin_user.fa') }} 
                @if($user->google2fa_secret_status==1)
                    <span class="label label-success">{{ trans('admin_user.activated') }}</span>
                    <a id="google2fa" href="{{ url('/admin/users/disable/'.$user->id) }}" class="btn btn-primary btn-xs">{{ trans('admin_user.reset') }}</a>
                @else
                    <span class="label label-danger">{{ trans('admin_user.inactive') }}</span>
                @endif
            </p>
                <p> {{ trans('forms.total_assets') }} : <b> {{$total_assets}} </b> KRW
                 
            </p>
              

        </div>

        <div class="grid-item">
            <div> <a href="{{ url('/users/'.$user->id.'/impersonate') }}" class="btn btn-success btn-block">{{ trans('admin_user.login') }}</a></div>
        </div>
        
        <div class="grid-item">
            <div class="grid grid-two gc-10">
                <div> 
                    <a href="{{ url('/admin/sendmail/'.$user->id) }}" class="btn btn-primary btn-xs btn-block">{{ trans('admin_user.send_mail') }}</a>
                </div>

                <div>   
                    <a id="reset" href="{{ url('/admin/users/resetpassword/'.$user->id) }}" class="btn btn-primary btn-xs btn-block">{{ trans('admin_user.pwd') }}</a>
                </div>

                <div>
                    <form method="post" class="update" action="{{ url('admin/users/update/'.$user->userprofile->id.'') }}">
                        {{ csrf_field()}}                      
                        @if($user->userprofile->active == 0)
                            <input type="hidden" name="userstatus" value="1">
                            <button type="submit" class="btn btn-success btn-xs btn-block">{{ trans('admin_user.active') }}</button>
                        @else
                            <input type="hidden" name="userstatus" value="0">
                            <button type="submit" class="btn btn-danger btn-xs btn-block">{{ trans('admin_user.suspend') }}</button>
                        @endif
                    </form>
                </div>
                              
                <div >
                    <a id="resetpwd" href="{{ url('/admin/users/resettransactionpassword/'.$user->userprofile->id) }}" class="btn btn-primary btn-xs btn-block">{{ trans('admin_user.reset_pwd') }}</a>
                </div>
            </div>   
        </div>
        <div class="grid-item">
            <div class="grid grid-two gc-10">
                <div>
                    @if($user->userprofile->email_verified == 0)
                    <a id="resend" href="{{ url('/admin/users/resend/'.$user->id) }}" class="btn btn-xs btn-primary btn-block">{{ trans('admin_user.resend_email') }}</a>
                    @endif
                </div>
                <div>
                    @if($user->userprofile->mobile_verified == 0)
                    <a id="resend" href="#" class="btn btn-xs btn-primary btn-block">{{ trans('admin_user.resend_mobile') }}</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="grid-item">
            <div class="grid">
               <div class="">
                    <p>{{ trans('admin_user.last_login') }}
                        @if ($lastlogin) 
                            <?php 
                                $properties = json_decode($lastlogin->properties, true); 
                            ?>                            
                            {{ $properties['ip'] }}
                        @endif
                    </p>
                </div>
                <div class="">
                    <p>{{ trans('admin_user.last_loginat') }} 
                        @if ($lastlogin) 
                            {{ $lastlogin->created_at->format('d/m/Y H:i:s') }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

                {{--<div class="row">
                <div class="flex wallet-box">
                    @foreach ($walletlists as $walletlist)
                        <div class="wallet-balance-box">
                            <div><img src="{{ url($walletlist->currency->image) }}" class="flag-image"></div>
                            <div><strong> {{ $walletlist->currency->name }} {{ trans('admin_user.wallet') }}</strong></div>
                            <div>{{ $walletlist->currency->name }} <span> {{ $walletlist->present()->getBalance($walletlist->currency->id, $user->id) }}</span></div>
                        </div>
                    @endforeach
                <div class="wallet-balance-box">
                    <div><img src="{{ url($btc_currency_details->image) }}" class="flag-image"></div>
                    <div><strong> {{ $btc_currency_details->displayname }} {{ trans('admin_user.wallet') }}</strong></div>
                    <div>
                        @if(count($user_accounts_btc)>0)
                            <p><b>{{$user_accounts_btc->btc_address}}</b></p>
                        @else
                            -
                        @endif 
                        <span><p>{{ $btc_currency_details->token }}<b> {{$balance_btc}}</b></p> </span>
                    </div>
                </div>
                   
                <div class="wallet-balance-box">
                    <div><img src="{{ url($ltc_currency_details->image) }}" class="flag-image"></div>
                    <div><strong> {{ $ltc_currency_details->displayname }} {{ trans('admin_user.wallet') }}</strong></div>
                        <div>
                            @if(count($user_accounts_ltc)>0)
                            <p><b>{{$user_accounts_ltc->ltc_address}}</b></p>
                            @else
                                -
                            @endif 
                                <span><p>{{ $ltc_currency_details->token }}<b> {{$balance_ltc}}</b></p> </span>
                        </div>
                </div> 

                <div class="wallet-balance-box">
                    <div><img src="{{ url($doge_currency_details->image) }}" class="flag-image"></div>
                    <div><strong> {{ $doge_currency_details->displayname }} {{ trans('admin_user.wallet') }}</strong></div>
                        <div>
                            @if(count($user_accounts_doge)>0)
                                <p><b>{{$user_accounts_doge->doge_address}}</b></p>
                            @else
                                -
                            @endif 
                                <span><p>{{ $doge_currency_details->token }}<b> {{$balance_doge}}</b></p> </span>
                        </div>
                </div> 
            </div>
            </div>--}}
</div>

@push('scripts')
<script type="text/javascript">

$("#referralgroup").change(function() 
{
    var referralid = $(this).val();
    var userid = $('#userid').val();
    if(confirm("{{ trans('admin_user.change_grop') }}")) 
    {
        window.location.href = "{{url('admin/users/updatereferralgroup')}}" + "/" + userid + "/" + referralid;
        return true;
    }
    return false;
});

    $("#google2fa").on("click", function()
    {
        return confirm("{{ trans('admin_user.google2fa') }}");
    });
</script>

@endpush
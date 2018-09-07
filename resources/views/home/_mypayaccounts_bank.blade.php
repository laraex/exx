
                                <div class="flex flex-page-head">
                                    <div class="flex flex-page-left">
                                        <h1 class="page-title">My Payment Bank Accounts</h1>
                                    </div>
                            </div>
                            <div  class="flex flex-c flex-page-content">                              
                            <div class="my-pay-account-box">
                                @if($bitcoin_direct)
                                   @include('home._mypayaccounts_bitcoin_direct')
                                @endif
                            </div>
                            <div class="my-pay-account-box">
                                @if($bankusd)
                                   @include('home._mypayaccounts_bankwire_usd')
                                @endif
                            </div>
                            <div class="my-pay-account-box">
                                @if($bankngn)
                                   @include('home._mypayaccounts_bankwire_ngn')
                                @endif
                            </div>
                            <div class="my-pay-account-box">
                                @if($bankgbp)
                                   @include('home._mypayaccounts_bankwire_gbp')
                                @endif
                            </div>
                        <div class="my-pay-account-box">
                            @if($bankeuro)
                               @include('home._mypayaccounts_bankwire_euro')
                            @endif
                        </div>

                    @if ($bankusd == '0' && $bankngn == '0' && $bankgbp == '0' && $bankeuro == '0' && $bitcoin_direct == '0')
                        <div class="my-pay-account-box">
                            {{ trans('myaccount.no_withdraw_payment_found') }}
                        </div>

                    @endif

                            </div>
             
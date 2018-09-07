<div class="mt-20 mb-20">
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1default" data-toggle="tab">{{ trans('admin_user.user_profile') }}</a></li>
                  <li><a href="#tab888default" data-toggle="tab">{{ trans('admin_user.wallet') }}</a></li>
                <li><a href="#tab11default" data-toggle="tab">{{ trans('admin_user.kyc') }}</a></li>
                <li><a href="#tab12default" data-toggle="tab">{{ trans('admin_user.source') }}</a></li>
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown"> {{ trans('admin_user.fund_deposit') }}<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#tab21default" data-toggle="tab">{{ trans('admin_user.new') }}</a></li>
                        <li><a href="#tab22default" data-toggle="tab">{{ trans('admin_user.active') }}</a></li>
                    </ul>
                </li>    
                                            
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown">{{ trans('admin_user.withdraw') }}<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#tab31default" data-toggle="tab">{{ trans('admin_user.pending') }}</a></li>
                        <li><a href="#tab32default" data-toggle="tab">{{ trans('admin_user.complete') }}</a></li>
                        <li><a href="#tab33default" data-toggle="tab">{{ trans('admin_user.reject') }}</a></li>
                    </ul>
                </li>

                
                 <li><a href="#tab81default" data-toggle="tab">{{ trans('myaccount.crypto_withdraw') }}</a></li>

                <li class="dropdown">
                    <a href="#" data-toggle="dropdown">{{ trans('admin_user.order') }}<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#tab111default" data-toggle="tab">{{ trans('admin_user.buyorder') }}</a></li>
                        <li><a href="#tab222default" data-toggle="tab">{{ trans('admin_user.sellorder') }}</a></li>
                        <li><a href="#tab333default" data-toggle="tab">{{ trans('admin_user.completeorder') }}</a></li>

                         <li><a href="#tab444default" data-toggle="tab">{{ trans('admin_user.cancelorder') }}</a></li>
                    </ul>
                </li>

                <li><a href="#tab6default" data-toggle="tab">{{ trans('admin_user.log') }}</a></li>

                <li><a href="#tab7default" data-toggle="tab">{{ trans('admin_user.history') }} </a></li>

                <!-- <li class="dropdown">
                    <a href="#" data-toggle="dropdown">{{ trans('admin_user.gift') }}<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#tab111default" data-toggle="tab">{{ trans('admin_user.approve') }}</a></li>
                        <li><a href="#tab222default" data-toggle="tab">{{ trans('admin_user.complete') }}</a></li>
                        <li><a href="#tab333default" data-toggle="tab">{{ trans('admin_user.wallet') }}</a></li>
                    </ul>
                </li> -->

                <li class="dropdown">
                    <a href="#" data-toggle="dropdown">{{ trans('admin_user.transaction') }}<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#tab444default" data-toggle="tab">{{ trans('admin_user.transaction_fiat') }}</a></li>
                        <li><a href="#tab555default" data-toggle="tab">{{ trans('admin_user.transaction_crypto') }}</a></li>
                        <li><a href="#tab666default" data-toggle="tab">{{ trans('admin_user.transaction_buycoin') }}</a></li>
                        <li><a href="#tab44default" data-toggle="tab">{{ trans('admin_user.sell_coin') }}</a></li>
                    </ul>
                </li>



                <li><a href="#tab777default" data-toggle="tab">{{ trans('admin_user.pay_ac') }}</a></li>

              
                                     
                {{--<li class="nav-item"><a href="{{url('admin/users/'.$user->id.'/wallet') }}" class="nav-link">{{trans('admin_user.wallet')}}</a></li>--}}
            </ul>
  
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab1default">
                    @include('adminpartials._userdetail_profile_tab')
                </div>
               
                <div class="tab-pane fade in" id="tab11default">
                    @include('adminpartials._user_kyc')
                </div>
                
                <div class="tab-pane fade in" id="tab12default">
                    @include('adminpartials._user_source_investment')
                </div>

                <div class="tab-pane fade" id="tab7default">                       
                    @include('adminpartials._userloginhistory_list')
                </div>

                <div class="tab-pane fade" id="tab6default">                       
                    @include('adminpartials._useractivitylog_list')
                </div> 

                <div class="tab-pane fade" id="tab21default">                      
                    @include('adminpartials._user_new_deposit_list')
                </div>

                <div class="tab-pane fade" id="tab22default">                      
                    @include('adminpartials._user_active_deposit_list')
                </div>    

                <div class="tab-pane fade" id="tab31default">                      
                    @include('adminpartials._userwithdrawpending_list')
                </div>

                <div class="tab-pane fade" id="tab32default">                      
                    @include('adminpartials._userwithdrawcompleted_list')
                </div>

                <div class="tab-pane fade" id="tab33default">                      
                    @include('adminpartials._userwithdrawrejected_list')
                </div>
                 <div class="tab-pane fade" id="tab111default">                      
                    @include('adminpartials._userbuyorder_list')
                </div>
                <div class="tab-pane fade" id="tab222default">                      
                    @include('adminpartials._usersellorder_list')
                </div> 
                 <div class="tab-pane fade" id="tab333default">                      
                    @include('adminpartials._usercompleteorder_list')
                </div>  
                 <div class="tab-pane fade" id="tab444default">                      
                    @include('adminpartials._usercancelorder_list')
                </div>      

           

                <div class="tab-pane fade" id="tab444default">                      
                    @include('adminpartials._tranfiatcurrency_list')
                </div>

                <div class="tab-pane fade" id="tab555default">                      
                    @include('adminpartials._trancryptocurrency_list')
                </div>

                <div class="tab-pane fade" id="tab666default">                      
                    @include('adminpartials._buycoin_list')
                </div>

                <div class="tab-pane fade" id="tab777default">                      
                    @include('adminpartials.mypayaccounts_details')
                </div>

                <div class="tab-pane fade" id="tab888default">           
                            
                   @include('admin.userdetail.show_form')
                </div>

                <!-- Crypto-Withdraw -->
                <div class="tab-pane fade" id="tab81default">                      
                    @include('adminpartials._usercryptowithdraw_list')
                </div>

                  <!-- Fund Transfers -->
               <!--  <div class="tab-pane fade" id="tab81default">                      
                    @include('adminpartials._userfundtransfersend_list')
                </div> -->
                <div class="tab-pane fade" id="tab82default">                      
                    @include('adminpartials._userfundtransferreceived_list')
                </div>   
                
                <div class="tab-pane fade" id="tab44default">  
                    @include('adminpartials._show_sellcoin_list')
                </div>   

                              
            </div> 
        </div>
    </div>
</div>

 @include('admin.datatable')
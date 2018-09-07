@if (auth()->user()->userprofile->usergroup_id=='1')

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <!-- ================================================ -->
            <!-- ==== Recommended place for admin menu items ==== -->
            <!-- ================================================ -->
            <li><a href="{{ url(config('backpack.base.route_prefix').'/dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
            <!-- Users, Roles Permissions -->
            <li>
                <a href="{{ url(config('backpack.base.route_prefix').'/users') }}"><i class="fa fa-group"></i> <span>User Management</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/users/create/new') }}"><i class="fa fa-plus"></i> <span>Create Member / Staff </span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/users') }}"><i class="fa fa-user"></i> <span>Members List</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/staffs') }}"><i class="fa fa-group"></i> <span>Staff List</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/create/') }}"><i class="fa fa-plus"></i> <span>Create Admin User</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/show') }}"><i class="fa fa-user"></i> <span>Admin List</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/usergroup/list') }}"><i class="fa fa-group"></i> <span>User Groups</span></a></li>
                </ul>
            </li>
            <li><a href="{{ url(config('backpack.base.route_prefix').'/erc20token') }}"><i class="fa fa-check-square"></i> <span>ERC20 Token</span></a></li>

        <li class="treeview">
                         <a href="#"><i class="glyphicon glyphicon-hand-right"></i> <span>Trade</span><i class="fa fa-angle-left pull-right"></i> </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url(config('backpack.base.route_prefix').'/tradeorder/open') }}"><i class="glyphicon glyphicon-list"></i> <span>Open</span></a></li> 
                              
                            <li><a href="{{ url(config('backpack.base.route_prefix').'/tradeorder/closed') }}"><i class="glyphicon glyphicon-hand-right"></i> <span>Closed</span></a></li>
                            <li><a href="{{ url(config('backpack.base.route_prefix').'/tradeorder/settlements') }}"><i class="glyphicon glyphicon-hand-right"></i> <span>Settlements</span></a></li>
                        </ul>
                     </li>
            <li class="treeview">
                <a href="#"><i class="glyphicon glyphicon-refresh"></i> <span>Action  Items</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/kyc') }}"><i class="glyphicon glyphicon-envelope"></i> <span>KYC</span></a></li>
                    {{--<li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/actions/kyc') }}"><i class="glyphicon glyphicon-check"></i> KYC</a></li>--}}
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/actions/fund') }}"><i class="glyphicon glyphicon-check"></i> Pending Fund List</a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/withdraw/pending') }}"><i class="fa fa-flag-checkered"></i> Pending Withdraw List</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="glyphicon glyphicon-list"></i> <span>Lists</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/fund/active') }}"><i class="glyphicon glyphicon-usd"></i> <span>Active Deposit Fund </span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/fundtransfer') }}"><i class="fa fa-random"></i> <span>Fund Transfers</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/exchange/lists') }}"><i class="glyphicon glyphicon-refresh"></i> <span>Exchange</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/withdraw/pending') }}"><i class="fa fa-flag-checkered"></i> Pending Withdraw</a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/withdraw/completed') }}"><i class="fa fa-language"></i> Completed Withdraw</a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/withdraw/rejected') }}"><i class="fa fa-language"></i> Rejected Withdraw</a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/earnings') }}"><i class="glyphicon glyphicon-plus"></i> <span>Admin Earnings</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/loggedin') }}"><i class="glyphicon glyphicon-eye-open"></i> <span>Loggedin Users</span></a></li> 
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/sendmail') }}"><i class="glyphicon glyphicon-envelope"></i> <span>Send Mail List</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/massmail') }}"><i class="glyphicon glyphicon-envelope"></i> <span>Send Mass Mail</span></a></li>

                 <!--     <li class="treeview">
                         <a href="#"><i class="glyphicon glyphicon-hand-right"></i> <span>Trade</span><i class="fa fa-angle-left pull-right"></i> </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url(config('backpack.base.route_prefix').'/tradeorder/open') }}"><i class="glyphicon glyphicon-list"></i> <span>Open</span></a></li> 
                              
                            <li><a href="{{ url(config('backpack.base.route_prefix').'/tradeorder/closed') }}"><i class="glyphicon glyphicon-hand-right"></i> <span>Closed</span></a></li>
                            <li><a href="{{ url(config('backpack.base.route_prefix').'/tradeorder/settlements') }}"><i class="glyphicon glyphicon-hand-right"></i> <span>Settlements</span></a></li>
                        </ul>
                     </li> -->

                      <li class="treeview">
                         <a href="#"><i class="glyphicon glyphicon-hand-right"></i> <span>Crypto Withdraw</span><i class="fa fa-angle-left pull-right"></i> </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url(config('backpack.base.route_prefix').'/cryptowithdraw/pending') }}"><i class="glyphicon glyphicon-list"></i> <span>Pending</span></a></li> 
                              
                            <li><a href="{{ url(config('backpack.base.route_prefix').'/cryptowithdraw/approve') }}"><i class="glyphicon glyphicon-hand-right"></i> <span>Approve</span></a></li>
                            <li><a href="{{ url(config('backpack.base.route_prefix').'/cryptowithdraw/cancel') }}"><i class="glyphicon glyphicon-hand-right"></i> <span>Cancel</span></a></li>
                        </ul>
                     </li>

                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-cogs"></i> <span>Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/setting') }}"><i class="fa fa-cog"></i> <span>Site Settings</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/referralgroups') }}"><i class="fa fa-cog"></i> <span>Referral Groups</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/currency') }}"><i class="glyphicon glyphicon-eur"></i> <span>Currency</span></a></li>
                     <li><a href="{{ url(config('backpack.base.route_prefix').'/currencypair') }}"><i class="fa fa-list"></i> <span>Currency Pair</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/paymentgateway') }}"><i class="fa fa-list"></i> <span>Payment Gateways</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/blockedusername') }}"><i class="fa fa-list"></i> <span>Blocked Usernames</span></a></li>  
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/mailtemplate') }}"><i class="fa fa-envelope" aria-hidden="true"></i><span>Mail Template</span></a></l>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/sociallink') }}"><i class="fa fa-envelope" aria-hidden="true"></i><span>Social Link</span></a></l>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-newspaper-o"></i> <span>Manage</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/news') }}"><i class="fa fa-newspaper-o"></i> <span>News</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/pages') }}"><i class="fa fa-file-o"></i> <span>Pages</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/faqs') }}"><i class="glyphicon glyphicon-question-sign"></i> <span>FAQs</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/sliders') }}"><i class="glyphicon glyphicon-question-sign"></i> <span>Sliders</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/ticketcategory') }}"><i class="fa fa-tag"></i> <span>Ticket Category</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/ticketcategoryuser') }}"><i class="fa fa-tag"></i> <span>Ticket Category User</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/country') }}"><i class="glyphicon glyphicon-question-sign"></i> <span>Country</span></a></li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-tag"></i> <span>Coupon Code</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/couponcode') }}"><i class="fa fa-tag"></i><span>Coupon Code</span></a></li>
                        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/couponcode/show') }}"><i class="fa fa-tag"></i><span>Coupon Code List</span></a></li>
                    </ul>
                </li>
                </ul>
            </li>
   
            <li><a href="{{ url(config('backpack.base.route_prefix').'/elfinder') }}"><i class="fa fa-files-o"></i> <span>File manager</span></a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-envelope"></i> <span>Messages</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/message/send') }}"><i class="fa fa-flag-checkered"></i> Send</a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/message/list') }}"><i class="fa fa-language"></i> List</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-globe"></i> <span>Translations</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/language') }}"><i class="fa fa-flag-checkered"></i> Languages</a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/language/texts') }}"><i class="fa fa-language"></i> Site texts</a></li>
                </ul>
            </li>
            <li><a href="{{ url(config('backpack.base.route_prefix').'/ticket') }}"><i class="glyphicon glyphicon-tasks"></i> <span>Tickets</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix').'/activitylogs') }}"><i class="glyphicon glyphicon-eye-open"></i> <span>Activity Logs</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix').'/changepassword') }}"><i class="fa fa-key" aria-hidden="true"></i> <span>Change Password</span></a></li>


            <li><a href="{{ url(config('backpack.base.route_prefix').'/exchange/show') }}"><i class="fa fa-exchange" aria-hidden="true"></i> <span>Transactions</span></a></li>
         

            <li><a href="{{ url(config('backpack.base.route_prefix').'/externalexchangefee') }}"><i class="fa fa-location-arrow" aria-hidden="true"></i> <span>Cypto Exchange Fee</span></a></li>

            {{--<li><a href="{{ url(config('backpack.base.route_prefix').'/kyc') }}"><i class="fa fa-dashboard" aria-hidden="true"></i> <span>Security Center</span></a></li>--}}

             <li class="treeview">
                <a href="#"><i class="glyphicon glyphicon-gift"></i> <span>Reports</span><i class="fa fa-angle-left pull-right"></i> </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/memberbalance') }}"><i class="fa fa-dashboard" aria-hidden="true"></i> <span>Member Balance</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/cashpointbalance') }}"><i class="fa fa-dashboard" aria-hidden="true"></i> <span>CashPoint Balance</span></a></li>
                   
                </ul>
            </li>

           

            <!-- ======================================= -->
            {{--
            <li class="header">{{ trans('backpack::base.user') }}</li>
            <li><a href="{{ url(config('backpack.base.route_prefix').'/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li> --}}
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
@else
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <!-- ================================================ -->
            <!-- ==== Recommended place for admin menu items ==== -->
            <!-- ================================================ -->
            <li><a href="{{ url('/staff/dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
            <!-- Users, Roles Permissions -->
     
            <li><a href="{{ url('/staff/ticket') }}"><i class="glyphicon glyphicon-tasks"></i> <span>Ticket List</span></a></li>

         
            <li><a href="{{ url('/staff/changepassword') }}"><i class="fa fa-key" aria-hidden="true"></i> <span>Change Password</span></a></li>

            <!-- ======================================= -->
            {{--
            <li class="header">{{ trans('backpack::base.user') }}</li>
            <li><a href="{{ url(config('backpack.base.route_prefix').'/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li> --}}
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
@endif
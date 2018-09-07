<nav class="navbar navbar-toggleable-md member-menu">
    <div class="container">
        <div class="flex flex-member-menu">
        <div class="togger-section">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#member-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i> {{ trans('menu.navigation') }} 
            </button>
        </div>
        <div class="menu-section">
        <div class="collapse navbar-collapse" id="member-menu">
            <ul class="navbar-nav ">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fas fa-home fa-menubar"></i> 
                       {{ trans('menu.dashboard') }} 
                    </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="{{ url('/myaccount/trade') }}">
                        <i class="fas fa-briefcase fa-menubar"></i>
                        {{ trans('menu.trade') }}
                    </a>
                </li>

                 <li class="nav-item">
                    <a class="nav-link"  href="{{ url('/myaccount/tradehistory/show/open') }}">
                        <i class="fas fa-check-square fa-menubar"></i>
                        {{ trans('menu.transhistory') }}
                    </a>
                </li>

                 <li class="nav-item">
                    <a class="nav-link" href="{{ url('/myaccount/accounts') }}">
                        <i class="fas fa-briefcase fa-menubar"></i>
                        {{ trans('menu.wallets') }}
                    </a>
                </li>
               <li class="nav-item">
                    <a class="nav-link" href="{{ url('/myaccount/support') }}">
                        <i class="fas fa-question-circle fa-menubar"></i>
                        {{ trans('menu.support') }}
                    </a>
                </li>
             <!--    <li class="nav-item">
                    <a class="nav-link" href="{{ url('/myaccount/giftcards/') }}">
                        <i class="fas fa-gift fa-menubar"></i>
                        {{ trans('menu.giftcard') }}
                    </a>
                </li> -->
                <li class="nav-item">
               <a class="nav-link" href="{{ url('/myaccount/exchange') }}">
                        <i class="fas fa-exchange-alt fa-menubar"></i>
                        {{ trans('menu.exchange_home') }}
                    </a>
                </li> 

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/myaccount/profile') }}">
                        <i class="fas fa-cog fa-menubar"></i>
                        {{ trans('menu.settings') }}
                    </a>
                </li>

              <!--   <li class="nav-item">
                    <a class="nav-link" href="{{ url('/myaccount/support') }}">
                        <i class="fas fa-question-circle fa-menubar"></i>
                        {{ trans('menu.support') }}
                    </a>
                </li> -->

                <li class="nav-item">
                    <a class="nav-link"  href="{{ url('/myaccount/orderhistory/giftcard/approved') }}">
                        <i class="fas fa-check-square fa-menubar"></i>
                        {{ trans('menu.orderhistory') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/myaccount/externalexchange/show') }}">
                        <i class="fas fa-list-alt fa-menubar"></i>
                        {{ trans('menu.externalexchange') }}
                    </a>
                </li>

                <!--  <li class="nav-item">
                    <a class="nav-link" href="{{ url('/myaccount/couponcode/create') }}">
                        <i class="fa fa-tag"></i>
                        {{ trans('menu.coupon_code') }}
                    </a>
                </li> -->

            </ul>
        </div>
        </div>
        </div>
    </div>
</nav>



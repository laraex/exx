 <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                     <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}" title="{{ Config::get('settings.sitename') }}">
            <img src="{{ url(Config::get('settings.sitelogo')) }}" alt="{{ Config::get('settings.sitename') }}" style="padding-bottom:8px;"> 
            </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->


                        <li><a href="{{ url('about') }}">{{ trans('menu.about') }}</a></li>
                            <li><a href="{{ url('privacy') }}">{{ trans('menu.privacypolicy') }}</a></li>
                            <li><a href="{{ url('faq') }}">{{ trans('menu.faqs') }}</a></li>
                            <li><a href="{{ url('contact') }}">{{ trans('menu.contact') }}</a></li>
                            <li><a href="{{ url('terms') }}">{{ trans('menu.termsservice') }}</a></li>

                        @if (Auth::guest())
                            
                             <li><a href="{{ url('login') }}">{{ trans('menu.login') }}</a></li>
                            <li><a href="{{ url('register') }}">{{ trans('menu.register') }}</a></li>                         
                            
                        @else

                            <li><a href="{{ url('myaccount/home') }}">{{ trans('menu.myaccount') }}</a></li>

                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>



                                <ul class="dropdown-menu" role="menu">                              

                                   

                                    <li><a href="{{ url('myaccount/changepassword') }}">{{ trans('menu.changepassword') }}</a></li>                            

                                    

                                    @if(Auth::user()->isImpersonating())
                                     <li>
                                        <a href="{{ url('users/stop') }}" >{{ trans('menu.stop_impersonate') }}
                                        </a>                            
                                    </li>
                                    @endif
                                    
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ trans('menu.logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
                
            </div>
        </nav>
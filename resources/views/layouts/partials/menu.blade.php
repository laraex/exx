<div class="container">
<nav class="navbar navbar-toggleable-md trans-navbar">
        <div class="navbar-logo-section">
            <div class="navbar-grid-item"><a class="navbar-brand" href="/"><img class="img-responsive" src="/{{ Config::get('settings.sitelogo') }}" ></a></div>
            <div class="navbar-grid-item"><button class="navbar-toggler navbar-toggler-custom" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button></div>
        </div> 
        <div class="navbar-menu main-menu">
            <div class="collapse navbar-collapse">
                  <ul class="navbar-nav">
                 <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">
                        {{ trans('menu.trade') }}
                    </a>
                </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('/myaccount/accounts/USD') }}">
                        {{ trans('menu.balance') }}
                    </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link"  href="{{ url('/myaccount/tradehistory/show/holdcoin/all') }}">
                        {{ trans('menu.transhistory') }}
                    </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="{{ url('/myaccount/support') }}">
                        {{ trans('menu.support') }}
                    </a>
                </li>
            </ul>
            </div>
        </div>
        <div class="navbar-menu-section">
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
          
                <ul class="navbar-nav">

                    @if (! Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/login') }}">{{ trans('menu.signin') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/register') }}">{{ trans('menu.signup') }}</a>
                    </li>
                    @else
                    <li class="nav-item">
                    <a class="nav-link" href="{{ url('/myaccount/profile') }}">
                        {{ trans('menu.settings') }}
                    </a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ trans('menu.logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    @endif
                    @if(Auth::check() && Auth::user()->isImpersonating())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('users/stop') }}">{{ trans('menu.stop_impersonate') }}
                                </a>
                    </li>
                    @endif

                       @if ((Auth::id()!=1) &&(!is_null(Session::get('languageslist'))))
                    @if(Session::get('languageslist')->count() > 1)
                     
                    <li>
                        <select name="language_switch" id="language_switch" style="margin: 6px 0" class="form-control">
                        @foreach (Session::get('languageslist') as $lang)
                        <option value="{{ url('/setlocale/'.$lang->abbr) }}" {{ Session::get('locale') == $lang->abbr ? 'selected' : '' }}>{{ $lang->name }}</option>
                        @endforeach
                    </select>
                    </li>
                    
                    @endif
                    @endif

                </ul>
            </div>
        </div>
</nav>
</div>

@push('bottomscripts')
<script>
    jQuery(document).ready(function($) {
        $("#language_switch").change(function() 
        {        
            window.location.href = $(this).val();
         // window.location.reload();
        })
        $("#trans").change(function() 
        { 
         
            window.location.href = $(this).val();
         // window.location.reload();
        })

    });
//     function ChangeStatus(val){
// alert(val);
//   window.location.href ="/myaccount/tradehistory/show/transhistory/"+$val;
// }
</script>
@endpush
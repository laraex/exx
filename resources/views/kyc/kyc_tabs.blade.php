<ul class="nav nav-tabs custom_tabs">
	<li class="{{Request::segment(3)=='kyc' ?'active':''}}"><a href="{{ url('/myaccount/kyc') }}" >{{ trans('menu.identity') }}</a></li>
	<li class="{{Request::segment(3)=='financial' ?'active':''}}"><a href="{{ url('/myaccount/financial') }}" >{{ trans('menu.financial') }}</a></li>
	<li class="{{Request::segment(3)=='investment' ?'active':''}}"><a href="{{ url('/myaccount/investment') }}" >{{ trans('menu.investment') }}</a></li>
</ul>
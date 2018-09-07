<div class="row-fluid">
	<div class="footer-nav-bar">
		<div class="container">
		<div class="grid grid-300-auto" >
			<div class="grid-item">
				<div class="footer-logo-section"><a class="footer-logo" href="/"><img class="img-responsive" src="/{{ Config::get('settings.sitelogo') }}" ></a></div>
			</div>
			<div class="grid-item">
				<ul class="footer-menu footer-menu-1 flex flex-m">
					<li> <a href="{{ url('/about') }}" class="footer-link">{{ trans('welcome.about') }}</a></li>
					<li> <a href="{{ url('/faq') }}" class="footer-link">{{ trans('welcome.faq') }}</a></li>
					<li> <a href="{{ url('/news') }}" class="footer-link">{{ trans('welcome.newsupdates') }}</a></li>
					<li> <a href="{{ url('/terms') }}" class="footer-link">{{ trans('welcome.termsofservice') }}</a></li>
					<li> <a href="{{ url('/privacy') }}" class="footer-link">{{ trans('welcome.privacypolicy') }}</a></li>
					<li> <a href="{{ url('/contact') }}" class="footer-link">{{ trans('welcome.contact') }}</a></li>
				</ul>
				<p class="text-justify">{{ trans('welcome.footercontent1') }}</p>
				<p class="text-justify">{{  trans('welcome.footercontent2') }}</p>
				<p>{{ trans('welcome.footercopyright') }}</p>
			</div>
			
		</div>
		</div>
	</div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

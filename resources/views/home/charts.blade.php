@extends('layouts.app')
	@section('content')
		@push('headscripts')
			<link rel="stylesheet" type="text/css" href="/vendor/select2/css/select2.min.css" />
			<link rel="stylesheet" type="text/css" href="/vendor/amstock/plugins/export/export.css" />
			<link rel="stylesheet" type="text/css" href="/charts/style.css" />
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.js"></script>
			<script src="/vendor/amstock/amcharts.js"></script>
			<script src="/vendor/amstock/serial.js"></script>
			<script src="/vendor/amstock/amstock.js"></script>
			<script src="/vendor/amstock/plugins/export/export.min.js"></script>
			<script src="/vendor/select2/js/select2.full.js"></script>
			<script>var cccPathToAssets ="{{url('/chart/')}}";</script>
			<script>var cccPathToAssetscustom ="{{url('/charts/')}}";</script>
			<script src="/charts/app.min.js"></script>
		@endpush
			<div class="container mb-50 mt-50">
				<div class="p-20" style="background-color:white">
				<div id="my-cc-chart" class="ccc-chart-container"></div>
				</div>
			</div>
	@endsection

@push('bottomscripts')
	<script>
	  cryptocurrencyChartsPlugin.buildChart(
	    'my-cc-chart', // HTML container ID
	    1182, // ID of cryptocurrency (see full list below)
	    'USD' // display currency
	  );
	</script>
@endpush
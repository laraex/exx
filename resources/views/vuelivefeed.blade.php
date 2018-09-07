@extends('layouts.app')
@section('content')
	<div class="container text-center mt-50 mb-50">
		<h1 class="big-heading">Live Feed</h1>
		<livefeed></livefeed>
		{{ message }}
	</div>
@endsection
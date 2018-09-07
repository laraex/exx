<div class="container">
	<div class="row">
		<div class="container mt-20 mb-20">
			@if (count($pages))
				@foreach($pages as $data)
				    <h4><a href="{{ url('/page/'.$data['slug']) }}" class="ing">{{ $data->title }}</a></h4>
                    	<p>{!! $data->description !!}</p>
				@endforeach
			@else
    			<div class="col-md-12">
       				{{ trans('pages.nofaqfound') }}
    			</div>
			@endif
				
		</div>
	</div>
</div>

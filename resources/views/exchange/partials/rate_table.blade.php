<div class="grid grid-2 gc-10">
	@foreach ($currency as $data)
	 <div class="btn btn-info">
		<a>1 {{ $data['name'] }}<br/>{{number_format((float) 1 / $data->present()->getrate($data['name'],'sell'),3) }} USD</a>
	</div>
	@endforeach
</div>
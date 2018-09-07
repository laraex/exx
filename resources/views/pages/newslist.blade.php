<div class="container mt-20 mb-20">
@if (count($news))
@foreach($news as $data)
	<div class="news-in-short">
            <h3 ><a href={{ url('/news/'.$data->id ) }}>{{ $data->title }}</a></h3>
            <p><small><em>{{ $data->created_at->diffForHumans() }}</em></small></p>
            <p>{!! str_limit($data->story, 300) !!}</p>
    </div>
@endforeach
@else
        {{ trans('pages.nonewsfound') }}

@endif
{{ $news->links() }}
 </div>


@extends('layouts.app')
@section('content')
<div class="member-content">
    <div class="inner-wrapper news mt-40 mb-40">
        <div class="container">
            <div class="flex flex-page-head">
                <div class="flex flex-page-left">
                    <h1 class="page-title">{{ trans('welcome.newsdetails') }}</h1>
                </div>
                <div class="flex flex-page-right">
                    <a href="/news" class="btn btn-link">Back to All News</a>
                </div>
            </div>
            <div  class="bgd-box-round flex flex-page-content">
                <div class="container mb-20 mt-20">
                    
                    @if (count($news))
                    
                    <h3 >{{ $news->title }}</h3>
                    <p> <small><em>{{ $news->created_at->diffForHumans() }}</em></small></p>
                    <p>{!! $news->story !!}</p>
                    
                    @else
                    <h6 class="no-news">{{ trans('pages.nonewsfound') }}</h6>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
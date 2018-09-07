@extends('layouts.app')
@section('content')
    <div class="member-content">
            <div class="inner-wrapper news mt-40 mb-40">
                    <div class=" container">
                                <div class="flex flex-page-head">
                                    <div class="flex flex-page-left">
                                        <h1 class="page-title">{{ trans('welcome.newsupdatesheader') }}</h1>
                                    </div>
                                    <div class="flex flex-page-right">
                                    </div>
                            </div>
                            <div  class="bgd-box-round ">
                                        @include('pages.newslist')
                            </div>
                    </div>
            </div>
    </div>
@endsection
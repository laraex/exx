@extends('layouts.app')
@section('content')
    <div class="member-content">
            <div class="inner-wrapper aboutus mt-40 mb-40">
                    <div class="container">
                                <div class="flex flex-page-head">
                                    <div class="flex flex-page-left">
                                        <h1 class="page-title">{{ trans('welcome.aboutebuckheader') }}</h1>
                                    </div>
                                    <div class="flex flex-page-right">
                                    </div>
                            </div>
                            <div  class="flex flex-page-content">
                                     {!! trans('aboutus.content') !!}
                            </div>
                    </div>
            </div>
    </div>
@endsection

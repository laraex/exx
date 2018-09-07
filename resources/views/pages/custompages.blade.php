@extends('layouts.app')
@section('content')
    <div class="member-content">
            <div class="inner-wrapper custompage mt-40 mb-40">
                    <div class="container">
                            <div  class="flex flex-page-content">
                                     {!! $pagedetails->content !!}
                            </div>
                    </div>
            </div>
    </div>
@endsection

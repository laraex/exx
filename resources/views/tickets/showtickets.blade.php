@extends('layouts.app') 

@section('content')
    <div class="member-content">
            <div class=" support mt-40 mb-40">
                    <div class="container">
                            <div class="flex flex-jc-sb">
                                        <h1 class="page-title">{{ trans('forms.my_tickets') }}</h1>
                                        <p>@if ($userprofile->usergroup_id == 3) 
                                                <a class="btn  btn-submit" href="{{ url('/myaccount/ticket/create') }}">{{ trans('forms.create') }}</a>
                                            @endif
                                        </p>
                            </div>
                            <div  class="bgd-box-round flex flex-c p-10 mt-20 mb-20">
                                    @include('partials.message')
                                    @include('tickets.ticketlists')
                            </div>
                    </div>
            </div>
    </div>
@endsection

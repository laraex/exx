@extends('layouts.app') 

@section('content')
    <div class="member-content">
            <div class="support mt-40 mb-40">
                    <div class="container">
                                <div class="flex flex-jc-sb">
                                        <h1 class="page-title">{{ trans('forms.create_new_ticket') }}</h1>
                                        <p>
                                            <a class="btn btn-submit" href="{{ url('/myaccount/ticket') }}">{{ trans('forms.back_to_ticket_list') }}</a>
                                        </p>
                                    </div>
                            <div  class="bgd-box-round grid grid-2 p-10 mt-20 mb-20">
                                    <div> @include('tickets.createticketform')</div>
                                    <div class="p-20 mb-20 mt-20">{!! trans('support.ticketguidelines') !!}</div>
                            </div>
                    </div>
            </div>
    </div>
@endsection

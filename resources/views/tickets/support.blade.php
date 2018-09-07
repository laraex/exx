@extends('layouts.app') 

@section('content')
    <div class="member-content">
            <div class="inner-wrapper support mt-40 mb-40">
                    <div class="container">
                               
                            <div  class="flex flex-page-content mt-20 mb-20">
                                   <div class="flex buysell-container">
                                   <div class="card">
                                   <h3 class="card-header">{{ trans('support.faqtitle') }}</h3> 
                                   <div class="card-block">
                                    
                                   <p class="card-text">{{ trans('support.faqcontent') }}</p> 
                                   <a href="{{ url('faq') }}" class="btn btn-primary">{{ trans('support.faq_btn') }}</a>
                                   </div>
                                   </div> 
                                   <div class="card">
                                   <h3 class="card-header">{{ trans('support.tickettitle') }}</h3> 
                                   <div class="card-block">
                                   
                                   <p class="card-text">{{ trans('support.ticketcontent') }}</p> 
                                   <a href="{{ url('myaccount/ticket') }}" class="btn btn-primary">{{ trans('support.ticket_btn') }}</a></div>
                                   </div>
                                   </div>
                            </div>
                    </div>
            </div>
    </div>
@endsection

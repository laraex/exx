@extends('layouts.app') 
@section('content')
    <div class="member-content">
        <div class="inner-wrapper ticket mt-40 mb-40">
            <div class="container">
                <div class="flex flex-page-head">
                    <div class="flex flex-page-left">
                        <h1 class="page-title">View Ticket Details</h1>
                    </div>
                </div>
                <div  class="flex flex-page-content row bgd-box-round p-20">
                    @include('partials.message')
                        <input type="hidden" name="baseurl" id="baseurl" value="{{url('/')}}">   
                    @include('tickets.ticketdetails')
                </div>
            </div>
        </div>
    </div>
@endsection
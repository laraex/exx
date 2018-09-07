@extends('layouts.app')
@section('content')


            <div class="flex container mt-40 mb-40">
            <div class="col col-md-3">
                  @include('home.partials.settingsmenu')
          </div>
           <div class="col col-md-9">

           <div class="container">
                @include('partials.message')
                @include('home._mypayaccounts_tabs') 
                <br>                    
                @include('home._mypayaccounts_ltc_form')


            </div>
                </div>
            </div>
    </div>
@endsection


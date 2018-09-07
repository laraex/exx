@extends('layouts.app') 

@section('content')



<div class="flex container mt-40 mb-40">
          <div class="col col-md-3">
                  @include('home.partials.settingsmenu')
          </div>
        <div class="col col-md-9">
        	<div class="flex" style="justify-content: space-between;">
            <h1 class="page-title">{{ trans('forms.my_message_view') }}</h1>
            <div><a href="{{ url('myaccount/message/send') }}" class="btn btn-secondary">{{ trans('forms.send') }}</a></div>
           </div>      	          
                       @include('message.details')
                            
            </div>
</div>
   
@endsection

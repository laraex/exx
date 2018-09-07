
@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
       {{ $ticketdetails->subject.' '.trans('forms.details')}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ $ticketdetails->subject.' '.trans('forms.details') 
    }}</li>
      </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ $ticketdetails->subject.' '.trans('forms.details') 
    }}</div>
                </div>
                <div class="row">
                     <div class="col-md-12">
                                @include('partials.message')
                            </div>
                  <div class="col-sm-12">
                         
                             <p class="pull-right">
      <select class="" id="priority" name="priority" onchange="changeTicketstatus(this.value, {{ $ticketdetails->id }})">  
        @foreach ($ticketstatus as $status)
            <option value="{{ $status->id }}" {{ $ticketdetails->status_id == $status->id ? "selected" : " " }}>{{ $status->name }}</option>
        @endforeach
    </select>
    &nbsp;
    <a href='{{ url("admin/ticket") }}'>Back to List</a>
    </p>


                       <input type="hidden" name="baseurl" id="baseurl" value="{{url('/')}}">     
                        @include('tickets.ticketdetails')
                        
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection




<script type="text/javascript">
    
function changeTicketstatus(statusid, ticketid )
{ 
   var base_url = $('#baseurl').val();
   window.location.href = base_url + "/admin/ticket/update" + "/" + statusid + "/" + ticketid;
        
}
</script>
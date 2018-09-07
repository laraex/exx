@extends('backpack::layout')

@section('content')
<div class="container"><h3>Tickets</h3></div>
<div class="container mt-20 mb-20">
    <div class="panel panel-default">
    <div class="panel-heading">{{ $ticketdetails->subject.' '.trans('forms.details') 
    }}
   
    <p class="pull-right">
      <select class="" id="priority" name="priority" onchange="changeTicketstatus(this.value, {{ $ticketdetails->id }})">  
        @foreach ($ticketstatus as $status)
            <option value="{{ $status->id }}" {{ $ticketdetails->status_id == $status->id ? "selected" : " " }}>{{ $status->name }}</option>
        @endforeach
    </select>
    &nbsp;
    <a href='{{ url("staff/ticket") }}'>Back to List</a>
    </p>
   
    </div>
    <div class="panel-body">  
            @include('partials.message')
        <div class="row">
            <div class="col-md-12">
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
   window.location.href = base_url + "/staff/ticket/update" + "/" + statusid + "/" + ticketid;
        
}
</script>
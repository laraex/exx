<div class="widget draggable ui-widget-content" id="3">
	<div class="widget-header">
    	<h2 class="widget-heading"><i class="fa fa-comments-o" aria-hidden="true"></i>{{ trans('admin_dashboard.quick_msg') }} <span class="pull-right"><i class="fa fa-arrows widget-move" aria-hidden="true"></i></span></h2>
  	</div>
  	<div class="widget-body">
	  	@if (session('success'))
	        <div class="alert alert-success messageHide" id="messageDisplay">
	         	<a href="{{ url('admin/message/conversation/'.$conversations['id']) }}">{{ session('success') }}</a>
	        </div>
	    @endif
  		<div class="widget-inner">
		    <form method="post" action="{{ url('admin/quickmessage')}}" class="form-horizontal" id="contact">
				{{ csrf_field() }}
				<div class="form-group">
					<div id="messageDisplay"></div>
				</div> 
			    <!-- <div class="form-group{{ $errors->has('users') ? ' has-error' : '' }}">
			        <select class="progControlSelect2 form-control js-example-basic-single"  name="users" required="required">
				        @foreach ($userlists as $user)
				        <option value="{{ $user->user->id }}" >{{ $user->user->name }}</option>
				        @endforeach
			      	</select>
			        <small class="text-danger">{{ $errors->first('users') }}</small>
			    </div>  -->

			    <div class="form-group{{ $errors->has('send_to') ? ' has-error' : '' }}">
		           <input type="text" name="send_to" id="send_to" class='' value="{{ old('send_to') }}">
		            <small class="text-danger">{{ $errors->first('send_to') }}</small>
		        </div> 

			    <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
			        <textarea  rows="5" class="form-control"  id="message" placeholder="Enter your message here" name="message" required="required">{{ old('message') }}</textarea>
			        <small class="text-danger">{{ $errors->first('message') }}</small>
			    </div>  

				<div class="form-group">
			        {!! Form::submit(trans('forms.submit_btn'), ['class' => 'btn btn-primary']) !!}
			        <a href="" class='btn btn-default'>{{ trans('forms.reset') }}</a>
			    </div>
			</form>
		</div>
 	</div>
  	<div class="widget-footer text-muted">
    	<a href="{{ url('admin/message/list/') }}" class="btn btn-primary">{{ trans('admin_dashboard.msg_center') }}</a>   
  	</div>
</div>

@push('scripts')
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script> --}}

<script type="text/javascript">
$(document).ready(function() {
//$('.js-example-basic-single').select2();

	$("#messageDisplay").delay(10000).fadeOut("slow");
	$("#messageDisplay").click(function(){
        $("#messageDisplay").delay(1000).fadeOut("slow");
    });	
				
});
</script>
@endpush

@push('scripts')

<script src="http://cdn.jsdelivr.net/typeahead.js/0.9.3/typeahead.min.js"></script>
<script>
$(document).ready(function() {

    $("#send_to").typeahead({
        name : 'sear',
        remote: {
            url : '/admin/searchuser?query=%QUERY'
        }
        
    });
});
</script>
@endpush
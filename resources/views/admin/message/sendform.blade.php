<div class="col-md-12 ">
<form method="post" action="{{ url('admin/message/save')}}" class="form-horizontal" id="contact">
{{ csrf_field() }}

    <!-- <div class="form-group userbox-width{{ $errors->has('users') ? ' has-error' : '' }}">
        <select class="progControlSelect2 js-example-basic-single" name="users" required="required">

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
        <textarea  rows="5" class="form-control"  placeholder="{{trans('forms.entermsg')}}" name="message" >{{ old('message') }}</textarea>
        <small class="text-danger">{{ $errors->first('message') }}</small>
    </div>  
 <div class="form-group">
        {!! Form::submit(trans('forms.submit_btn'), ['class' => 'btn btn-primary']) !!}
        <a href="" class='btn btn-default'>{{ trans('forms.reset') }}</a>
    </div>
</form>
</div>
@push('scripts')
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script> -->

<script type="text/javascript">
    $(document).ready(function() {  
        //$('.js-example-basic-single').select2();
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







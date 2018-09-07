 <fieldset>
    <legend>{{ trans('forms.reply') }}</legend>
    @if ($userprofile->usergroup_id == 3)
    <form method="POST" action="{{ url('myaccount/ticket/storecomment')}}"  class="form-horizontal">
    @endif
    @if ($userprofile->usergroup_id == 2)
    <form method="POST" action="{{ url('staff/ticket/storecomment')}}"  class="form-horizontal">
    @endif
     @if ($userprofile->usergroup_id == 1)
    <form method="POST" action="{{ url('admin/ticket/storecomment')}}"  class="form-horizontal">
    @endif
    <input type="hidden" name="ticket_id" value="{{ $ticketdetails->id }}">

    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
        <div class="col-lg-12">
                <textarea class='form-control' name="comment">{{ old('comment') }}</textarea>
                <small class="text-danger">{{ $errors->first('comment') }}</small>
            </div>  </div>
       

    <div class="form-group">
    <div class="col-lg-12">
         <input value="{{ trans('forms.submit_btn') }}" class="btn btn-success" type="submit">
         </div>
    </div>
     </form>
</fieldset>
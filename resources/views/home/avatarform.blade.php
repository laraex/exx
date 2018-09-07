<div class="p-20">

<form method="post" action="{{ url('myaccount/saveavatar')}}" class="form-horizontal" id="changeavatar" enctype="multipart/form-data">

{{ csrf_field() }}

    <div class="form-group{{ $errors->has('profileimage') ? ' has-error' : '' }}">
        <label>{{ trans('forms.profile_image_lbl') }}</label>
        <input type="file" name="profileimage">
        <small class="text-danger">{{ $errors->first('profileimage') }}</small>
    </div>

    <div class="form-group">
        {!! Form::submit(trans('forms.submit_btn'), ['class' => 'btn btn-primary']) !!}
        <a href="" class='btn btn-default'>{{ trans('forms.reset') }}</a>
    </div>

</form>
</div>
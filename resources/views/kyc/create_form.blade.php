<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
{{ csrf_field() }}
<input name="verification"  type="hidden">
 <small class="text-danger">{{ $errors->first('verification') }}</small>

    @if($userprofile->passport_verified!= 1  )

            <div class="form-group{{ $errors->has('passport') ? ' has-error' : '' }}">
                <label>{{ trans('forms.passport_lbl') }}</label>
                <input name="passport" value="1" id="passport" type="checkbox" @if(old('passport')==1) checked @endif>       
            </div>   

             <div class="form-group{{ $errors->has('passport_attachment') ? ' has-error' : '' }}">
                <label>{{ trans('forms.passport_attachment_lbl') }}</label>
                <input type="file" name="passport_attachment">
                <small class="text-danger">{{ $errors->first('passport_attachment') }}</small>
            </div>
    @endif

    @if($userprofile->id_card_verified!= 1  )
        <div class="form-group{{ $errors->has('id_card') ? ' has-error' : '' }}">
            <label>{{ trans('forms.id_card_lbl') }}</label>
            <input name="id_card" value="1" id="id_card" type="checkbox" @if(old('id_card')==1) checked @endif>       
        </div>

        <div class="form-group{{ $errors->has('id_card_attachment') ? ' has-error' : '' }}">
            <label>{{ trans('forms.id_card_attachment_lbl') }}</label>
            <input type="file" name="id_card_attachment">
            <small class="text-danger">{{ $errors->first('id_card_attachment') }}</small>
        </div>
    @endif

   @if(  $userprofile->driving_license_verified!= 1  )
        <div class="form-group{{ $errors->has('driving_license') ? ' has-error' : '' }}">
            <label>{{ trans('forms.driving_license_lbl') }}</label>
            <input name="driving_license" value="1" id="driving_license" type="checkbox" @if(old('driving_license')==1) checked @endif>       
        </div> 

        <div class="form-group{{ $errors->has('driving_license_attachment') ? ' has-error' : '' }}">
            <label>{{ trans('forms.driving_license_attachment_lbl') }}</label>
            <input type="file" name="driving_license_attachment">
            <small class="text-danger">{{ $errors->first('driving_license_attachment') }}</small>
        </div>
    @endif
    @if(  $userprofile->photo_id_verified!= 1  )
         <div class="form-group{{ $errors->has('photo_id') ? ' has-error' : '' }}">
            <label>{{ trans('forms.photo_id_lbl') }}</label>
            <input name="photo_id" value="1" id="photo_id" type="checkbox" @if(old('photo_id')==1) checked @endif>       
        </div>

        <div class="form-group{{ $errors->has('photo_id_attachment') ? ' has-error' : '' }}">
            <label>{{ trans('forms.photo_id_attachment_lbl') }}</label>
            <input type="file" name="photo_id_attachment">
            <small class="text-danger">{{ $errors->first('photo_id_attachment') }}</small>
        </div>
    @endif

    <div class="form-group">
   

        <input value="{{ trans('forms.submit_btn') }}" class="btn btn-primary" type="submit" id="myBtn"> 
        <a href="" class='btn btn-default'>{{ trans('forms.reset') }}</a>
    </div>

</form>





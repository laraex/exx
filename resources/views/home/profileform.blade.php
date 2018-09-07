<div class="col-md-12 p-20">

<form method="post" action="{{ url('myaccount/profile')}}" class="form-horizontal" id="profile" enctype="multipart/form-data">

{{ csrf_field() }}

    <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
        <label>{{ trans('forms.first_name_lbl') }}</label>
        <input name="firstname" class="form-control" value="{{ (Form::old('firstname') != '' ? old('firstname') : $userprofile->firstname) }}" type="text">
        <small class="text-danger">{{ $errors->first('firstname') }}</small>
    </div>

    <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
        <label>{{ trans('forms.last_name_lbl') }}</label>     
        <input name="lastname" class="form-control" value="{{ (Form::old('lastname') != '' ? old('lastname') : $userprofile->lastname) }}" type="text">
        <small class="text-danger">{{ $errors->first('lastname') }}</small>
    </div>

    <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
        <label>{{ trans('forms.country_lbl') }}</label>
        <select class="form-control" id="country" name="country" onchange="getCountryCode(this.value);">
        <option value="">Select</option>
            @foreach ($country as $country)
                <option value="{{ $country->id }}" {{ ($userprofile->country == $country->id ? "selected":"") }} >{{ $country->name }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('country') }}</small>
    </div>

@if($userprofile->mobile_verified == 0 )
    <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
        <label>{{ trans('forms.mobile_no_lbl') }} ({{ trans('forms.country_code_alert') }})</label> 
        <input name="mobile" id="mobile" class="form-control bfh-phone" value="{{ (Form::old('mobile') != '' ? old('mobile') : $userprofile->mobile) }}" type="text">
        <small class="text-danger">{{ $errors->first('mobile') }}</small>
    </div>
@endif
    

@if(Config::get('settings.address1'))
    <div class="form-group{{ $errors->has('address1') ? ' has-error' : '' }}">
        <label>{{ trans('forms.address1_lbl') }}</label>
        <input name="address1" class="form-control" value="{{ (Form::old('address1') != '' ? old('address1') : $userprofile->address1) }}" type="text">
        <small class="text-danger">{{ $errors->first('address1') }}</small>
    </div>
@endif

@if(Config::get('settings.address2'))
    <div class="form-group{{ $errors->has('address2') ? ' has-error' : '' }}">
        <label>{{ trans('forms.address2_lbl') }}</label>
        <input name="address2" class="form-control" value="{{ (Form::old('address2') != '' ? old('address2') : $userprofile->address2) }}" type="text">
        <small class="text-danger">{{ $errors->first('address2') }}</small>
    </div>
@endif

@if(Config::get('settings.city'))
    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
        <label>{{ trans('forms.city_lbl') }}</label>
        <input name="city" class="form-control" value="{{ (Form::old('city') != '' ? old('city') : $userprofile->city) }}" type="text">
        <small class="text-danger">{{ $errors->first('city') }}</small>
    </div>
@endif

@if(Config::get('settings.state'))
    <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
        <label>{{ trans('forms.state_lbl') }}</label>
        <input name="state" class="form-control" value="{{ (Form::old('state') != '' ? old('state') : $userprofile->state) }}" type="text">
        <small class="text-danger">{{ $errors->first('state') }}</small>
    </div>
@endif

    {{--<div class="form-group{{ $errors->has('ssn') ? ' has-error' : '' }}">
        <label>{{ trans('forms.security_no_lbl') }}</label>
        <input name="ssn" class="form-control" value="{{ (Form::old('ssn') != '' ? old('ssn') : $userprofile->ssn) }}" type="text">
        <small class="text-danger">{{ $errors->first('ssn') }}</small>
    </div>
@if($userprofile->kyc_verified == 0 || $userprofile->kyc_verified == 2)
    <div class="form-group{{ $errors->has('kyc_doc') ? ' has-error' : '' }}">
        <label>{{ trans('forms.kyc_doc_lbl') }}</label>
        <input type="file" name="kyc_doc">
        <small class="text-danger">{{ $errors->first('kyc_doc') }}</small>
    </div>
@endif--}}
    <div class="form-group">
        {!! Form::submit("Submit", ['class' => 'btn btn-primary']) !!}
        {!! Form::reset("Reset", ['class' => 'btn btn-default']) !!}
    </div>

</form>
</div>

@push('bottomscripts')

<script src="{{ asset('js/custom.js') }}"></script>
<script>
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
function getCountryCode(countryid)
{ 
    $.post( "/myaccount/getmobilecode", { countryid: countryid })
      .done(function( data ) {
        $('#mobile').val(data);
   });
}
</script>
@endpush
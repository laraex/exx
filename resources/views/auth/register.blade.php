@extends('layouts.app')
@section('content')
    <div class="member-content">
        <div class="inner-wrapper register mt-40 mb-40">
            <div class="container">
    
                <div  class="flex flex-page-content">
                    <div class="register-form-container bgd-box-round p-20">
                        <h1 class="page-title">{{ trans('auth.register') }}</h1>
                        @if (\Config::get('settings.force_register_down') == 0)
                            <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}
                                <div class = "form-group{{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label for="name" class="control-label">{{ trans('auth.name') }}</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="control-label">{{ trans('auth.E-Mail-Address') }}</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="control-label">{{ trans('auth.password') }}</label>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="control-label">{{ trans('auth.confirm-password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>

                               {{-- <div class="form-group{{ $errors->has('sponsor') ? ' has-error' : '' }}">
                                    <label for="sponsor" class="control-label">{{ trans('auth.sponsor') }}</label>
                                    <input id="sponsor" type="text" class="form-control" name="sponsor" value="{{Form::old('sponsor') != '' ? old('sponsor') :Cookie::get('sponsor')}}">
                                    @if ($errors->has('sponsor'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('sponsor') }}</strong>
                                        </span>
                                    @endif
                                </div> --}}

                              

                               <div class="form-group{{ $errors->has('contactno') ? ' has-error' : '' }}">
                                    <label for="contactno" class="control-label">{{ trans('auth.contactno') }}</label>
                                     <input id="contactno" type="text" class="form-control" name="contactno" value="{{Form::old('contactno') != '' ? old('contactno') :Cookie::get('contactno')}}">

                                        @if ($errors->has('contactno'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('contactno') }}</strong>
                                            </span>
                                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('address1') ? ' has-error' : '' }}">
                                    <label for="address1" class="control-label">{{ trans('auth.address1') }}</label>
                                     <input id="address1" type="text" class="form-control" name="address1" value="{{Form::old('address1') != '' ? old('address1') :Cookie::get('address1')}}">

                                        @if ($errors->has('address1'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('address1') }}</strong>
                                            </span>
                                        @endif
                    </div>
                     <div class="form-group{{ $errors->has('address2') ? ' has-error' : '' }}">
                                   {{-- <label for="address2" class="control-label">{{ trans('auth.address2') }}</label>--}}
                                     <input id="address2" type="text" class="form-control" name="address2" value="{{Form::old('address2') != '' ? old('address2') :Cookie::get('address2')}}">

                                        @if ($errors->has('address2'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('address2') }}</strong>
                                            </span>
                                        @endif
                    </div>
                     <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                    <label for="city" class="control-label">{{ trans('auth.city') }}</label>
                                     <input id="city" type="text" class="form-control" name="city" value="{{Form::old('city') != '' ? old('city') :Cookie::get('city')}}">

                                        @if ($errors->has('city'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('city') }}</strong>
                                            </span>
                                        @endif
                    </div>
                     <div class="form-group{{ $errors->has('area') ? ' has-error' : '' }}">
                                    <label for="area" class="control-label">{{ trans('auth.area') }}</label>
                                     <input id="area" type="text" class="form-control" name="area" value="{{Form::old('area') != '' ? old('area') :Cookie::get('area')}}">

                                        @if ($errors->has('area'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('area') }}</strong>
                                            </span>
                                        @endif
                    </div>
                     <div class="form-group{{ $errors->has('postcode') ? ' has-error' : '' }}">
                                    <label for="postcode" class="control-label">{{ trans('auth.postcode') }}</label>
                                     <input id="postcode" type="text" class="form-control" name="postcode" value="{{Form::old('postcode') != '' ? old('postcode') :Cookie::get('postcode')}}">

                                        @if ($errors->has('postcode'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('postcode') }}</strong>
                                            </span>
                                        @endif
                    </div>
                     <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                <label>{{ trans('auth.country') }}</label>
                                <select class="form-control" id="country" name="country" >
                                <option value="">Select</option>
                                    @foreach ($country as $country)
                                        <option value="{{ $country->id }}" {{ (old('country') == $country->id ? "selected":"") }} >{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger">{{ $errors->first('country') }}</small>
                     </div>
                    <label>{{ trans('auth.dateofbirth') }}</label>
                     <div class="row">


                     <div class="col-md-4">

                             <div class="form-group{{ $errors->has('day') ? ' has-error' : '' }}">

                                       <select class="form-control" id="day" name="day" >
                                        <option value="">{{ trans('auth.day') }}</option>
                                            @for ($i=1;$i<=31;$i++)
                                                <option value="{{ $i }}" {{ (old('day') == $i ? "selected":"") }} >{{ $i }}</option>
                                            @endfor
                                        </select>
                                        <small class="text-danger">{{ $errors->first('day') }}</small>
                             </div>
                     </div>
                     <div class="col-md-4">

                           @php 

                            $month= array("01"=>"Jan","02"=>"Feb","03"=>"Mar","04"=>"Apr","05"=>"May","06"=>"Jun","07"=>"Jul","08"=>"Aug","09"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dec"); 
                           

                            @endphp
                             <div class="form-group{{ $errors->has('month') ? ' has-error' : '' }}">

                                      
                                        <select class="form-control" id="month" name="month" >
                                        <option value="">{{ trans('auth.month') }}</option>
                                            @foreach ($month as $key=>$value)
                                                <option value="{{ $key }}" {{ (old('month') == $key ? "selected":"") }} >{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger">{{ $errors->first('month') }}</small>
                             </div>
                     </div>

                      <div class="col-md-4">
                            @php 

                            $year= date("Y"); 
                            $n= $year-70; 
                            $start= $year-18; 

                            @endphp
                             <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">

                                  
                                        <select class="form-control" id="year" name="year" >
                                        <option value="">{{ trans('auth.year') }}</option>
                                            @for ($i=$start;$i>=$n;$i--)
                                                <option value="{{ $i }}" {{ (old('year') == $i ? "selected":"") }} >{{ $i }}</option>
                                            @endfor
                                        </select>
                                        <small class="text-danger">{{ $errors->first('year') }}</small>
                             </div>
                     </div>

                     </div>

                           <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">

                                        <label>{{ trans('auth.gender') }}</label>
                                        <input type="radio" name="gender" value="male" {{ (old('gender') == 'male' ? "checked":"") }}> Male
                                        <input type="radio" name="gender" value="female" {{ (old('gender') == 'female' ? "checked":"") }}> Female
                                       
                                        <small class="text-danger">{{ $errors->first('gender') }}</small>
                             </div>


                             <div class="form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">
                                <label>{{ trans('auth.nationality') }}</label>
                                <select class="form-control" id="nationality" name="nationality" >
                                <option value="">Select</option>
                                    @foreach ($nationality as $nationality)
                                        <option value="{{ $nationality->id }}" {{ (old('nationality') == $nationality->id ? "selected":"") }} >{{ $nationality->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger">{{ $errors->first('nationality') }}</small>
                           </div>

                            @php 

                            $identity= array("passport_no"=>"Passport","driving_license_no"=>"Driving license","id_card_no"=>"National Id"); 
                           

                            @endphp
                             <div class="form-group{{ $errors->has('identity') ? ' has-error' : '' }}">

                                        <label>{{ trans('auth.identity') }}</label>
                                        <select class="form-control" id="identity" name="identity" >
                                        <option value="">Select</option>
                                            @foreach ($identity as $key=>$value)
                                                <option value="{{ $key }}" {{ (old('identity') == $key ? "selected":"") }} >{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger">{{ $errors->first('identity') }}</small>
                             </div>
                           <div class="form-group{{ $errors->has('identityno') ? ' has-error' : '' }}">
                                    <label for="identityno" class="control-label">{{ trans('auth.identityno') }}</label>
                                     <input id="identityno" type="text" class="form-control" name="identityno" value="{{Form::old('identityno') != '' ? old('identityno') :Cookie::get('identityno')}}">

                                        @if ($errors->has('identityno'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('identityno') }}</strong>
                                            </span>
                                        @endif
                           </div>

                           <div class="form-group{{ $errors->has('occupation') ? ' has-error' : '' }}">
                                    <label for="occupation" class="control-label">{{ trans('auth.occupation') }}</label>
                                     <input id="occupation" type="text" class="form-control" name="occupation" value="{{Form::old('occupation') != '' ? old('occupation') :Cookie::get('occupation')}}">

                                        @if ($errors->has('occupation'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('occupation') }}</strong>
                                            </span>
                                        @endif
                           </div>

     

                                <div class="form-group">
                    <input id="termsandcondn" type="checkbox" class="control-label" name="termsandcondn" value="1" @if(old('termsandcondn')==1) checked @endif>
                    <label for="account_type" class="control-label">{{ trans('auth.iagree')  }} <a href="{{url('terms')}}" target="_blank">{{ trans('auth.termsandcondn') }}</a></label>
                    <br>
                  
                    @if ($errors->has('termsandcondn'))
                            <span class="help-block">
                                <strong>{{ $errors->first('termsandcondn') }}</strong>
                            </span>
                    @endif
                   
                    </div>

                                {{-- <div class="form-group">
                                    <label for="account_type" class="control-label">{{ trans('auth.account_type') }}</label>
                                    <select class="form-control" name="account_type">
                                        <option value="">Select</option>
                                        <option value="business" {{ old('account_type')== 'business' ? "selected":"" }} >Business</option>
                                        <option value="personal" {{ old('account_type')== 'personal' ? "selected":"" }}>Personal</option>
                                    </select>
                                    @if ($errors->has('account_type'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('account_type') }}</strong>
                                        </span>
                                    @endif               
                                </div>--}}

                            @if(Config::get('settings.register_captcha_active') == '1')
                                <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                    <label for="password-confirm" class="col-md-4 control-label">{{ trans('forms.captcha') }}</label>
                                    <div class="g-recaptcha" data-sitekey="{{ Config::get('settings.captchasitekey') }}"></div>
                                    <small class="text-danger">{{ $errors->first('g-recaptcha-response') }}</small>
                                </div>  
                            @endif                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        {{ trans('auth.register') }}
                                    </button>
                                </div>
                            </form>
                        @elseif (\Config::get('settings.force_register_down') == 1)
                            <p>{{ trans('forms.force_register_down_message') }}</p>
                        @endif
                    <hr>
                        <p>{{ trans('auth.already_have_account') }}<a href="{{ url('/login') }}"> {{ trans('auth.signin') }} </a> {{ trans('auth.here') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('bottomscripts')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endpush

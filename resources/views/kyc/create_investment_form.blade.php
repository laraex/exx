<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
{{ csrf_field() }}

   @php 
    $status=array('employed'=>'Employed','unemployed'=>'UnEmployed','business'=>'Business','others'=>'Others');

    @endphp
 <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
        <label>{{ trans('forms.status_lbl') }}</label>
        <select class="form-control" id="status" name="status" >
        <option value="">Select</option>
            @foreach ($status as $key=>$value)
                <option value="{{ $key }}" @if(old('status')){{ (old('status') == $key ? "selected":"") }}@else{{ ($information->status == $key ? "selected":"") }}@endif >{{ $value }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('status') }}</small>
    </div>
    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        <label>{{ trans('forms.emp_title_lbl') }}</label>     
        <input name="title" class="form-control" value="{{ old('title',  isset($information->title) ? $information->title : null) }}" type="text">
        <small class="text-danger">{{ $errors->first('title') }}</small>
    </div>

   <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label>{{ trans('forms.emp_name_lbl') }}</label>     
        <input name="name" class="form-control" value="{{ old('name',  isset($information->name) ? $information->name : null) }}" type="text">
        <small class="text-danger">{{ $errors->first('name') }}</small>
    </div>
     <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
        <label>{{ trans('forms.emp_state_lbl') }}</label>     
        <input name="state" class="form-control" value="{{ old('state',  isset($information->state) ? $information->state : null) }}" type="text">
        <small class="text-danger">{{ $errors->first('state') }}</small>
    </div>
     <div class="form-group{{ $errors->has('district') ? ' has-error' : '' }}">
        <label>{{ trans('forms.emp_district_lbl') }}</label>     
        <input name="district" class="form-control" value="{{ old('district',  isset($information->district) ? $information->district : null) }}" type="text">
        <small class="text-danger">{{ $errors->first('district') }}</small>
    </div>
     <div class="form-group{{ $errors->has('street') ? ' has-error' : '' }}">
        <label>{{ trans('forms.emp_street_lbl') }}</label>     
        <input name="street" class="form-control" value="{{ old('street',  isset($information->street) ? $information->street : null) }}" type="text">
        <small class="text-danger">{{ $errors->first('street') }}</small>
    </div>


   @php 
    $source=array('salary'=>'Salary','savings'=>'Savings','inheritance'=>'Inheritance','investment'=>'Investments','other'=>'Other');

    @endphp

 <div class="form-group{{ $errors->has('source') ? ' has-error' : '' }}">
        <label>{{ trans('forms.source_lbl') }}</label>
        <select class="form-control" id="source" name="source[]" multiple >
       
            @foreach ($source as $key=>$value)
                <option value="{{ $key }}" @if(old('source')){{ (old('source') == $key ? "selected":"") }}@else{{ ($information->source == $key ? "selected":"") }}@endif >{{ $value }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('source') }}</small>
    </div>
  @php 
    $net_amount=array('0-20000'=>'0-20000','20000-40000'=>'20000-40000','40000-60000'=>'40000-60000','60000-80000'=>'60000-80000','80000-100000'=>'80000-100000');

    @endphp
     <div class="form-group{{ $errors->has('net_amount') ? ' has-error' : '' }}">
        <label>{{ trans('forms.net_amount_lbl') }}</label>
        <select class="form-control" id="net_amount" name="net_amount" >
        <option value="">Select</option>
            @foreach ($net_amount as $key=>$value)
                <option value="{{ $key }}" @if(old('net_amount')){{ (old('net_amount') == $key ? "selected":"") }}@else{{ ($information->net_amount == $key ? "selected":"") }}@endif >{{ $value }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('net_amount') }}</small>
    </div>


  @php 
    $industry=array('software'=>'Software','hardware'=>'Hardware');

    @endphp
     <div class="form-group{{ $errors->has('industry') ? ' has-error' : '' }}">
        <label>{{ trans('forms.industry_lbl') }}</label>
        <select class="form-control" id="industry" name="industry" >
        <option value="">Select</option>
            @foreach ($industry as $key=>$value)
                <option value="{{ $key }}" @if(old('industry')){{ (old('industry') == $key ? "selected":"") }}@else{{ ($information->industry == $key ? "selected":"") }}@endif >{{ $value }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('industry') }}</small>
    </div>
   <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
        <label>{{ trans('forms.emp_country_lbl') }}</label>
        <select class="form-control" id="country" name="country" >
        <option value="">Select</option>
            @foreach ($country as $country)
                <option value="{{ $country->id }}" @if(old('country')){{ (old('country') == $country->id ? "selected":"") }}@else{{ ($information->country == $country->id ? "selected":"") }}@endif >{{ $country->name }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('country') }}</small>
    </div>
     <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
        <label>{{ trans('forms.emp_city_lbl') }}</label>     
        <input name="city" class="form-control" value="{{ old('city',  isset($information->city) ? $information->city : null) }}" type="text">
        <small class="text-danger">{{ $errors->first('city') }}</small>
    </div>
     <div class="form-group{{ $errors->has('number') ? ' has-error' : '' }}">
        <label>{{ trans('forms.emp_number_lbl') }}</label>     
        <input name="number" class="form-control" value="{{ old('number',  isset($information->number) ? $information->number : null) }}" type="text">
        <small class="text-danger">{{ $errors->first('number') }}</small>
    </div>
   <div class="form-group{{ $errors->has('zipcode') ? ' has-error' : '' }}">
        <label>{{ trans('forms.emp_zipcode_lbl') }}</label>     
        <input name="zipcode" class="form-control" value="{{ old('zipcode',  isset($information->zip) ? $information->zip : null) }}" type="text">
        <small class="text-danger">{{ $errors->first('zipcode') }}</small>
    </div>

 

     @php 
    $investment=array('0-5000'=>'0-5000','5000-10000'=>'5000-10000','10000-15000'=>'10000-15000','20000-30000'=>'20000-30000','50000-100000'=>'50000-100000');

    @endphp
     <div class="form-group{{ $errors->has('investment') ? ' has-error' : '' }}">
        <label>{{ trans('forms.investment_lbl') }}</label>
        <select class="form-control" id="investment" name="investment" >
        <option value="">Select</option>
            @foreach ($investment as $key=>$value)
                <option value="{{ $key }}" @if(old('investment')){{ (old('investment') == $key ? "selected":"") }}@else{{ ($information->investment == $key ? "selected":"") }}@endif >{{ $value }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('investment') }}</small>
    </div>
      
<h4 class="mt-20">{{trans('forms.investment')}}</h4>
   @php 
    $invest_stock=array('yes'=>'Yes','no'=>'No');

    @endphp
 <div class="form-group{{ $errors->has('invest_stock') ? ' has-error' : '' }}">
        <label>{{ trans('forms.invest_stock_lbl') }}</label>
        <select class="form-control" id="invest_stock" name="invest_stock" >
        <option value="">Select</option>
            @foreach ($invest_stock as $key=>$value)
                <option value="{{ $key }}" @if(old('invest_stock')){{ (old('invest_stock') == $key ? "selected":"") }}@else{{ ($information->q1 == $key ? "selected":"") }}@endif >{{ $value }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('invest_stock') }}</small>
    </div>
 <div class="form-group{{ $errors->has('investment_exp') ? ' has-error' : '' }}">
        <label>{{ trans('forms.emp_investment_exp_lbl') }}</label>     
        <input name="investment_exp" class="form-control" value="{{ old('investment_exp',  isset($information->q2) ? $information->q2 : null) }}" type="text">
        <small class="text-danger">{{ $errors->first('investment_exp') }}</small>
    </div> 
    <div class="form-group{{ $errors->has('investment_exp_market') ? ' has-error' : '' }}">
        <label>{{ trans('forms.emp_investment_market_lbl') }}</label>     
        <input name="investment_exp_market" class="form-control" value="{{ old('investment_exp_market',  isset($information->q3) ? $information->q3 : null) }}" type="text">
        <small class="text-danger">{{ $errors->first('investment_exp_market') }}</small>
    </div>
       @php 
    $derivative=array('yes'=>'Yes','no'=>'No');

    @endphp
 <div class="form-group{{ $errors->has('derivative') ? ' has-error' : '' }}">
        <label>{{ trans('forms.derivative_lbl') }}</label>
        <select class="form-control" id="derivative" name="derivative" >
        <option value="">Select</option>
            @foreach ($derivative as $key=>$value)
                <option value="{{ $key }}" @if(old('derivative')){{ (old('derivative') == $key ? "selected":"") }}@else{{ ($information->q4 == $key ? "selected":"") }}@endif >{{ $value }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('derivative') }}</small>
    </div>  

       @php 
    $crypto_currencies=array('yes'=>'Yes','no'=>'No');

    @endphp
 <div class="form-group{{ $errors->has('crypto_currencies') ? ' has-error' : '' }}">
        <label>{{ trans('forms.crypto_currencies_lbl') }}</label>
        <select class="form-control" id="crypto_currencies" name="crypto_currencies" >
        <option value="">Select</option>
            @foreach ($crypto_currencies as $key=>$value)
                <option value="{{ $key }}" @if(old('crypto_currencies')){{ (old('crypto_currencies') == $key ? "selected":"") }}@else{{ ($information->q5 == $key ? "selected":"") }}@endif >{{ $value }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('crypto_currencies') }}</small>
    </div>

    <div class="form-group">
   

        <input value="{{ trans('forms.submit_btn') }}" class="btn btn-primary" type="submit" id="myBtn"> 
        <a href="" class='btn btn-default'>{{ trans('forms.reset') }}</a>
    </div>

</form>


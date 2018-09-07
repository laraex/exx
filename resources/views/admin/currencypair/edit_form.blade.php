<div class="col-md-12 ">
    <form method="post" action="{{url('admin/currencypair/edit/'.$details->id)}}" class="form-horizontal" >
        {{ csrf_field() }}

         <div class="form-group">
         <label>{{ trans('admin_currencypair.from_currency') }}</label> : 
         <label>{{$details->fromcurrency->token}} </label>       
         </div>
         <div class="form-group">
         <label>{{ trans('admin_currencypair.to_currency') }}</label> : 
         <label>{{$details->tocurrency->token}} </label>       
         </div> 
        <div class="form-group">
         <label>{{ trans('admin_currencypair.ex_rate') }}</label> : 
         <label>{{$exchangerate}} </label>       
         </div> 

        <div class="form-group{{ $errors->has('min_amount') ? ' has-error' : '' }}">
         <label>{{ trans('admin_currencypair.min_amt') }} ({{$details->fromcurrency->token}})</label>
            <input type="text" name="min_amount" value="{{ old('min_amount',  isset($details->min_value) ? $details->min_value : null) }}" class="form-control"  placeholder="Enter the Min Amount ">
            <small class="text-danger">{{ $errors->first('min_amount') }}</small>
        </div> 
        <div class="form-group{{ $errors->has('max_amount') ? ' has-error' : '' }}">
         <label>{{ trans('admin_currencypair.max_amt') }} ({{$details->fromcurrency->token}})</label>
            <input type="text" name="max_amount" value="{{ old('max_amount',  isset($details->max_value) ? $details->max_value : null) }}" class="form-control"  placeholder="Enter the Min Amount ">
            <small class="text-danger">{{ $errors->first('max_amount') }}</small>
        </div> 
       {{-- <div class="form-group{{ $errors->has('rate') ? ' has-error' : '' }}">
         <label>Rate</label>
            <input type="text" name="rate" value="{{ old('rate',  isset($details->rate) ? $details->rate : null) }}" class="form-control"  placeholder="Enter the Rate ">
            <small class="text-danger">{{ $errors->first('rate') }}</small>
        </div> --}}

       {{-- <div class="form-group{{ $errors->has('exchange_rate_variant') ? ' has-error' : '' }}">
         <label>{{ trans('admin_currencypair.ex_rate_variant') }}</label>
            <input type="text" name="exchange_rate_variant" value="{{ old('exchange_rate_variant',  isset($details->exchange_rate_variant) ? $details->exchange_rate_variant : null) }}" class="form-control"  placeholder="Enter the Exchange Rate Variant ">
            <small class="text-danger">{{ $errors->first('exchange_rate_variant') }}</small>
        </div> 
         --}}


         <div class="form-group{{ $errors->has('buy_fee') ? ' has-error' : '' }}">
         <label>{{ trans('admin_currencypair.buy_fee') }}</label>
            <input type="text" name="buy_fee" value="{{ old('buy_fee',  isset($details->buy_fee) ? $details->buy_fee : null) }}" class="form-control"  placeholder="Enter the buy fee ">
            <small class="text-danger">{{ $errors->first('buy_fee') }}</small>
        </div>
          <div class="form-group{{ $errors->has('buy_base_fee') ? ' has-error' : '' }}">
         <label>{{ trans('admin_currencypair.buy_base_fee') }}</label>
            <input type="text" name="buy_base_fee" value="{{ old('buy_base_fee',  isset($details->buy_base_fee) ? $details->buy_base_fee : null) }}" class="form-control"  placeholder="Enter the Base Fee ">
            <small class="text-danger">{{ $errors->first('buy_base_fee') }}</small>
        </div> 


         <div class="form-group{{ $errors->has('sell_fee') ? ' has-error' : '' }}">
         <label>{{ trans('admin_currencypair.sell_fee') }}</label>
            <input type="text" name="sell_fee" value="{{ old('sell_fee',  isset($details->sell_fee) ? $details->sell_fee : null) }}" class="form-control"  placeholder="Enter the sell fee ">
            <small class="text-danger">{{ $errors->first('sell_fee') }}</small>
        </div>
          <div class="form-group{{ $errors->has('sell_base_fee') ? ' has-error' : '' }}">
         <label>{{ trans('admin_currencypair.sell_base_fee') }}</label>
            <input type="text" name="sell_base_fee" value="{{ old('sell_base_fee',  isset($details->sell_base_fee) ? $details->sell_base_fee : null) }}" class="form-control"  placeholder="Enter the Base Fee ">
            <small class="text-danger">{{ $errors->first('sell_base_fee') }}</small>
        </div> 

         {{--<div class="form-group{{ $errors->has('reserve_amount') ? ' has-error' : '' }}">
         <label>Reserve Amount </label>
            <input type="text" name="reserve_amount" value="{{ old('reserve_amount',  isset($details->reserve_amount) ? $details->reserve_amount : null) }}" class="form-control"  placeholder="Enter the Reserve Amount ">
            <small class="text-danger">{{ $errors->first('reserve_amount') }}</small>
        </div> --}}



        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label>{{ trans('admin_currencypair.status') }}</label>
              <input type="radio" value="active" name="status" @if(isset($details->status))@if($details->status=='active')checked @endif @elseif(old('status')=='active') checked @endif>Active
            <input type="radio" value="inactive" name="status" @if(isset($details->status))@if($details->status=='inactive')checked @endif @elseif(old('status')=='inactive') checked @endif>Inactive
            <small class="text-danger">{{ $errors->first('status') }}</small>
        </div> 

        <div class="form-group">
            <input value="Save" class="btn btn-primary" type="submit" onclick="this.disabled=true;this.form.submit();"> 
              
            <a href="{{ url('admin/currencypair') }}" class='btn btn-info'>{{ trans('admin_currencypair.back') }}</a>
        </div>
    </form>    
</div>

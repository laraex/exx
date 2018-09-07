<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
{{ csrf_field() }}

  

     <div class="form-group{{ $errors->has('bank_attachment') ? ' has-error' : '' }}">
        <label>{{ trans('forms.bank_attachment_lbl') }}</label>
        <input type="file" name="bank_attachment">
        <small class="text-danger">{{ $errors->first('bank_attachment') }}</small>
    </div>

    <div class="form-group{{ $errors->has('bank_name') ? ' has-error' : '' }}">
        <label>{{ trans('forms.bank_name_lbl') }}</label>     
        <input name="bank_name" class="form-control" value="{{ old('bank_name',  isset($bankdata->bank_name) ? $bankdata->bank_name : null)  }}" type="text">
        <small class="text-danger">{{ $errors->first('bank_name') }}</small>
    </div>



    <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
        <label>{{ trans('forms.bank_country_lbl') }}</label>
        <select class="form-control" id="country" name="country" >
        <option value="">Select</option>
            @foreach ($country as $country)
                <option value="{{ $country->id }}" @if(old('country')){{ (old('country') == $country->id ? "selected":"") }}@endif @if(count($bankdata)>0){{ ($bankdata->country_id == $country->id ? "selected":"") }}@endif >{{ $country->name }}</option>
            @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('country') }}</small>
    </div>

       <div class="form-group{{ $errors->has('statement') ? ' has-error' : '' }}">
     <label>{{ trans('forms.statement_lbl') }}</label>
    <div class='input-group date' id='statement'>
                    <input type='text' class="form-control" name="statement" value="{{ old('statement',  isset($bankdata->statement) ? date('d-m-Y',strtotime($bankdata->statement)) : null)  }}
                    "/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
    </div>
        <small class="text-danger">{{ $errors->first('statement') }}</small>
    </div>
      

    <div class="form-group">
   

        <input value="{{ trans('forms.submit_btn') }}" class="btn btn-primary" type="submit" id="myBtn"> 
        <a href="" class='btn btn-default'>{{ trans('forms.reset') }}</a>
    </div>

</form>

@push('bottomscripts')
<link  rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.css">


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script>
var date = new Date();
date.setDate(date.getDate());
$("#statement").datepicker({
      
         viewMode: 'years',
         format: 'dd-mm-yyyy',
         autoclose:true,
      });


</script>

@endpush
<div class="col-md-12">
  <form method="post" action="{{ url('/admin/usergroup/edit/'.$memberedit->id) }}" class="form-horizontal" id="field">
    {{ csrf_field() }}
    <div class="form-group">
      <label class="col-md-3 control-label" for="usergroup_name">{{ trans('admin_usergroup.usergroup_name')}}</label>
      <div class="col-md-9">
        <input type="text" name="usergroup_name" class="form-control" value="{{ $memberedit->usergroup_name }}">
      </div>
    </div>

    <label>{{ trans('admin_usergroup.rule1') }}</label><br>
    <label>{{ trans('admin_usergroup.reg_date') }}</label>

    <div class="form-group">
      <label class="col-md-3 control-label" for="period">{{ trans('admin_usergroup.select') }}</label>
      <div class="col-md-9">
        <select class="form-control" id="period" name="period">
          <option value="">Select</option>
          <option value="after" {{ ($edit['register_rule']['period'] == 'after' ? "selected":"") }} {{ $edit['register_rule']['period'] }}>After</option>
          <option value="between" {{ ($edit['register_rule']['period']== 'between' ? "selected":"") }} {{ $edit['register_rule']['period'] }}>Between</option>
        </select>
      </div>
    </div> 

    <div class="form-group">
      <label class="col-md-3 control-label" for="date_after">{{ trans('admin_usergroup.after_date')}}</label>
      <div class="col-md-9">
        <input type="date" name="date_after" class="form-control" value="{{ $edit['register_rule']['after_date'] }}" id="date_after">
      </div>
    </div>


    <div class="form-group">
      <label class="col-md-3 control-label" for="from_date">{{ trans('admin_usergroup.from_date')}}</label>
      <div class="col-md-9">
        <input type="text" name="from_date" class="form-control" value="{{ $edit['register_rule']['from_date'] }}" id="fromdate">
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-3 control-label" for="to_date">{{ trans('admin_usergroup.to_date')}}</label>
      <div class="col-md-9">
        <input type="text" name="to_date" class="form-control" value="{{ $edit['register_rule']['to_date'] }}" id="todate">
      </div>
    </div> 

{{-- <div class="form-group">
      <label class="col-md-3 control-label" for="date">{{ trans('admin_usergroup.date')}}</label>
      <div class="col-md-9">
        <input type="date" name="date" class="form-control" value="{{ $edit[0]->date }}">
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-3 control-label" for="from_date">{{ trans('admin_usergroup.from_date')}}</label>
      <div class="col-md-9">
        <input type="text" name="from_date" class="form-control" value="{{ $edit[0]->from_date }}" id="fromdate">
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-3 control-label" for="to_date">{{ trans('admin_usergroup.to_date')}}</label>
      <div class="col-md-9">
        <input type="text" name="to_date" class="form-control" value="{{ $edit[0]->to_date }}" id="todate">
      </div>
    </div> 

    <label>{{ trans('admin_usergroup.rule2') }}</label><br>
    <label>{{ trans('admin_usergroup.kyc_verified') }}</label>

    <div class="form-group">
      <label class="col-md-3 control-label" for="kyc_verified">{{ trans('admin_usergroup.kyc_verified') }}</label>
      <div class="col-md-9">
        <select class="form-control" id="kyc_verified" name="kyc_verified">
          <option value="">Select</option>
          <option value="1" {{ ($edit[1]->kyc_verified == 1 ? "selected":"") }} {{ $edit[1]->kyc_verified }}>Yes</option>
          <option value="0"  {{ ($edit[1]->kyc_verified == 0 ? "selected":"") }} {{ $edit[1]->kyc_verified }}> No</option>
        </select>
      </div>
    </div> 

    <label>{{ trans('admin_usergroup.rule3') }}</label><br>
    <label>{{ trans('admin_usergroup.status') }}</label>

    <div class="form-group">
      <label class="col-md-3 control-label" for="status">{{ trans('admin_usergroup.status') }}</label>
      <div class="col-md-9">
        <select class="form-control" id="status" name="status">
          <option value="">Select</option>
          <option value="1" {{ ($edit[2]->status == 1 ? "selected":"") }} {{ $edit[2]->status }}>Active</option>
          <option value="0"  {{ ($edit[2]->status == 0 ? "selected":"") }} {{ $edit[2]->status }}>Inactive</option>
        </select>
      </div>
    </div> 

    <label>{{ trans('admin_usergroup.rule4') }}</label><br>
    <label>{{ trans('admin_usergroup.wallet_amt') }}</label>

    <div class="form-group">
      <label class="col-md-3 control-label" for="amt">{{ trans('admin_usergroup.amt')}}</label>
      <div class="col-md-9">
        <input type="text" name="amt" class="form-control" value="{{ $edit[3]->amt }}" id="todate">
      </div>
    </div> 

    <div class="form-group">
      <label class="col-md-3 control-label" for="amt_level">{{ trans('admin_usergroup.select') }}</label>
      <div class="col-md-9">
        <select class="form-control" id="amt_level" name="amt_level">
          <option value="">Select</option>
          <option value="1" {{ ($edit[3]->amt_level == 1 ? "selected":"") }} {{ $edit[3]->amt_level }}>Above</option>
          <option value="2"  {{ ($edit[3]->amt_level == 0 ? "selected":"") }} {{ $edit[3]->amt_level }}>Below</option>
          <option value="3"  {{ ($edit[3]->amt_level == 0 ? "selected":"") }} {{ $edit[3]->amt_level }}>=</option>
        </select>
      </div>
    </div> 

    <div class="form-group">
      <label class="col-md-3 control-label" for="currency">{{ trans('admin_usergroup.currency') }}</label>
      <div class="col-md-9">
        <select class="form-control" id="currency" name="currency">
          <option value="">Select</option>
          @foreach($currency as $key=>$currencies)
            <option value="{{ $currencies->id }}" {{ ($edit[3]->currency == $currencies->id ? "selected":"") }} >{{ $currencies->displayname}} </option>
          @endforeach
        </select>
      </div>
    </div> --}}

    <br>
      <div class="form-group">
        <input value="{{ trans('admin_usergroup.submit') }}" class="btn btn-success" type="submit">
      </div>
  </form>
</div>

@push('datescripts')

<link rel='stylesheet' type='text/css' href='stylesheet.css'/>
    <link rel='stylesheet' type='text/css' href='http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css'/>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() 
            {
                $("#fromdate").datepicker();
                $("#todate").datepicker();
                $("#period_date").click(function() 
                {
                    var fromdate = $("#fromdate").val();
                    var todate = $("#todate").val();
                    if (fromdate === "" || todate === "") 
                    {
                        alert("{{ trans('admin_fee.select_date') }}");
                    } 
                    // else 
                    // {
                    //     confirm("{{ trans('admin_fee.go') }}" + selected + " on " + fromdate + "{{ trans('admin_fee.return_on') }}" + todate + "?");
                    // }
                });
            });
    </script>

    <script type="text/javascript">
        $(document).ready(function() 
        {
            $('.checkboxone').on('change', function() 
            {
                $('.ruleone').toggle();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() 
        {
            $('.checkboxtwo').on('change', function() 
            {
                $('.kyc_verified').toggle();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() 
        {
            $('.checkboxthree').on('change', function() 
            {
                $('.rulethree').toggle();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() 
        {
            $('.checkboxfour').on('change', function() 
            {
                $('.rulefour').toggle();
            });
        });
    </script>

    <script>
    $('.register').change(function()
    {
        $('.afterdate').css('display','none');
        $('.betweendate').css('display','none');
        $('.dateon').css('display','none');

        val= $(this).val();

        if(val=='after')
        {
            $('.afterdate').css('display','block');
        }

        if(val=='between')
        {
            $('.betweendate').css('display','block');
        }

        if(val=='today')
        {
            $('.dateon').css('display','block');
        }

    });
    </script>

    <script type="text/javascript">
        $(document).ready(function() 
        {
            $('.checkboxfive').on('change', function() 
            {
                $('.rulefive').toggle();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() 
        {
            $('.checkboxemail_verified').on('change', function() 
            {
                $('.email_verified').toggle();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() 
        {
            $('.checkboxbuycoin').on('change', function() 
            {
                $('.buy_coin').toggle();
            });
        });
    </script>

    <script>
    $('.buycoin_level').change(function()
    {
        $('.buycoin_above').css('display','none');
        $('.buycoin_between').css('display','none');
       
        val= $(this).val();

        if(val=='above')
        {
            $('.buycoin_above').css('display','block');
        }

        if(val=='between')
        {
            $('.buycoin_between').css('display','block');
        }

    });
    </script>

    <script type="text/javascript">
        $(document).ready(function() 
        {
            $('.downline').on('change', function() 
            {
                $('.downline_count').toggle();
            });
        });
    </script>

     <script>
    $('.count_level').change(function()
    {
        $('.count_above').css('display','none');
        $('.count_between').css('display','none');
       
        val= $(this).val();

        if(val=='above')
        {
            $('.count_above').css('display','block');
        }

        if(val=='between')
        {
            $('.count_between').css('display','block');
        }

    });
    </script>
@endpush

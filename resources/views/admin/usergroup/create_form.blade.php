<div class="col-md-12 ">
    <form method="post" class="form-horizontal" id="contact">
        {{ csrf_field() }}   

        <div class="form-group{{ $errors->has('usergroup_name') ? 'has-error' : '' }}">
            <label>{{ trans('admin_usergroup.usergroup_name') }}</label>
            <input type="text" name="usergroup_name" value="{{ old('usergroup_name') }}" class="form-control">
            <small class="text-danger"> {{ $errors->first('usergroup_name') }}</small> 
        </div> 

        <label>{{ trans('admin_usergroup.rule1') }}</label><label>{{ trans('admin_usergroup.reg_date') }}</label><br>

        <input type="checkbox" class="checkboxone" name="ruleone" value="1"><br>
        <div class="form-group{{ $errors->has('period') ? 'has-error' : '' }} ruleone" style="display:none;">
            <label>{{ trans('admin_usergroup.select') }}</label>
                <select class="form-control register" id="period" name="period">
                    <option value="">Select</option>
                    <option value="after">After</option>
                    <option value="between">Between</option>
                    <option value="today">Register On</option>
                </select>
            <small class="text-danger"> {{ $errors->first('period') }}</small> 
        </div> 

        <div class="form-group{{ $errors->has('date_after') ? 'has-error' : '' }} afterdate" style="display:none;">
            <label>{{ trans('admin_usergroup.after_date') }}</label>
            <input type="date" name="date_after" value="{{ old('date_after') }}" class="form-control" placeholder="yy-mm-dd">
            <small class="text-danger"> {{ $errors->first('date_after') }}</small> 
        </div> 

        <div class="form-group{{ $errors->has('from_date') ? 'has-error' : '' }} betweendate" style="display:none;">
            <label>{{ trans('admin_usergroup.from_date') }}</label>
            <input type="text" name="from_date" value="{{ old('from_date') }}" class="form-control" id="fromdate">
            <small class="text-danger"> {{ $errors->first('from_date') }}</small> 
        </div> 

        <div class="form-group{{ $errors->has('to_date') ? 'has-error' : '' }} betweendate" style="display:none;">
            <label>{{ trans('admin_usergroup.to_date') }}</label>
            <input type="text" name="to_date" value="{{ old('to_date') }}" class="form-control" id="todate">
            <small class="text-danger"> {{ $errors->first('to_date') }}</small> 
        </div> 

        <div class="form-group{{ $errors->has('date_on') ? 'has-error' : '' }} dateon" style="display:none;">
            <label>{{ trans('admin_usergroup.date_on') }}</label>
            <input type="date" name="date_on" value="{{ old('date_on') }}" class="form-control">
            <small class="text-danger"> {{ $errors->first('date_on') }}</small> 
        </div> 

        <label>{{ trans('admin_usergroup.rule2') }}</label><label>{{ trans('admin_usergroup.country') }}</label><br>
        
        <input type="checkbox" class="checkboxfive" name="rulefive" value="5"><br>
        <div class="form-group{{ $errors->has('country') ? 'has-error' : '' }} rulefive" style="display:none;">
            <label>{{ trans('admin_usergroup.select') }}</label>
                <select class="form-control" id="country" name="country">
                    <option value="">Select</option>
                    @foreach($country as $countries)
                        <option value="{{ $countries->id }}">
                            {{ $countries->name }}
                        </option>
                    @endforeach
                </select>
            <small class="text-danger"> {{ $errors->first('country') }}</small> 
        </div> 

        <label>{{ trans('admin_usergroup.rule3') }}</label><label>{{ trans('admin_usergroup.email_verified') }}</label><br>

        <input type="checkbox" class="checkboxemail_verified" name="email_verified" value="6"><br>
        
        
        <label>{{ trans('admin_usergroup.rule4') }}</label><label>{{ trans('admin_usergroup.kyc_verified') }}</label><br>

        <input type="checkbox" class="checkboxtwo" name="kyc_verified" value="2"><br>
       
        <label>{{ trans('admin_usergroup.rule5') }}</label><label>{{ trans('admin_usergroup.downline_count') }}</label><br>

        <input type="checkbox" class="downline" name="downline" value="8"><br>

        <div class="form-group{{ $errors->has('downline_count') ? 'has-error' : '' }} downline_count" style="display:none;">
            <label>{{ trans('admin_usergroup.downline_count') }}</label>
            <select class="form-control count_level" id="downline_count" name="downline_count">
                <option value="">Select</option>
                <option value="above">Above</option>
                <option value="between">Between</option>
            </select>
            <small class="text-danger"> {{ $errors->first('downline_count') }}</small> 
        </div> 

        <div class="form-group{{ $errors->has('downline_abovecount') ? 'has-error' : ''}} count_above" style="display: none;">
            <label>{{ trans('admin_usergroup.count') }}</label>
            <input type="text" name="downline_abovecount" value="{{ old('downline_abovecount') }}" class="form-control">
            <small class="text-danger">{{ $errors->first('downline_abovecount') }}</small>
        </div> 

        <div class="form-group{{ $errors->has('downline_fromcount') ? 'has-error' : ''}} count_between" style="display: none;">
            <label>{{ trans('admin_usergroup.from_count') }}</label>
            <input type="text" name="downline_fromcount" value="{{ old('downline_fromcount') }}" class="form-control">
            <small class="text-danger">{{ $errors->first('downline_fromcount') }}</small>
        </div> 

        <div class="form-group{{ $errors->has('downline_tocount') ? 'has-error' : ''}} count_between" style="display: none;">
            <label>{{ trans('admin_usergroup.to_count') }}</label>
            <input type="text" name="downline_tocount" value="{{ old('downline_tocount') }}" class="form-control">
            <small class="text-danger">{{ $errors->first('downline_tocount') }}</small>
        </div> 


        <label>{{ trans('admin_usergroup.rule6') }}</label><label>{{ trans('admin_usergroup.wallet_amt') }}</label><br>

        <input type="checkbox" class="checkboxfour" name="rulefour" value="4"><br>

        <div class="form-group{{ $errors->has('currency') ? 'has-error' : '' }} rulefour" style="display: none;">
            <label>{{ trans('admin_usergroup.currency') }}</label>
            <select class="form-control" id="currency" name="currency">
                <option value="">Select</option>
                @foreach($currency as $key=>$currencies)
                    <option value="{{ $currencies->id }}"> 
                        {{ $currencies->displayname}}
                    </option>
                @endforeach
            </select>
            <small class="text-danger"> {{ $errors->first('currency') }}</small> 
        </div> 

        <div class="form-group{{ $errors->has('condition') ? 'has-error' : '' }} rulefour" style="display:none;">
            <label>{{ trans('admin_usergroup.condition') }}</label>
            <select class="form-control" id="condition" name="condition">
                <option value="">Select</option>
                <option value="withdraw">Withdraw</option>
                <option value="fund_transfer">Fund Transfer</option>
                <option value="transaction">Transaction</option>
            </select>
            <small class="text-danger"> {{ $errors->first('condition') }}</small> 
        </div> 

        <div class="form-group{{ $errors->has('amt') ? 'has-error' : '' }} rulefour" style="display:none;">
            <label>{{ trans('admin_usergroup.amt') }}</label>
            <input type="text" name="amt" value="{{ old('amt') }}" class="form-control">
            <small class="text-danger"> {{ $errors->first('amt') }}</small> 
        </div> 

        <div class="form-group{{ $errors->has('amt_level') ? 'has-error' : '' }} rulefour" style="display: none;">
            <label>{{ trans('admin_usergroup.select') }}</label>
            <select class="form-control" id="amt_level" name="amt_level">
                <option value="">Select</option>
                <option value="1">Above</option>
                <option value="2">Below</option>
                <option value="3">=</option>
            </select>
            <small class="text-danger"> {{ $errors->first('amt_level') }}</small> 
        </div> 

        
        <label>{{ trans('admin_usergroup.rule7') }}</label><label>{{ trans('admin_usergroup.buy_coin') }}</label><br>

         <input type="checkbox" class="checkboxbuycoin" name="buy_coin" value="7"><br>

         <div class="form-group{{ $errors->has('buycoin_currency') ? 'has-error' : ''}} buy_coin" style="display: none;">
            <label>{{ trans('admin_usergroup.currency') }}</label>
            <select class="form-control" id="buycoin_currency" name="buycoin_currency">
                <option value="">select</option>
                @foreach($buycoin_currency as $currencyname)
                    <option value="{{ $currencyname->id }}">
                        {{ $currencyname->displayname }}
                    </option>
                @endforeach
            </select>
            <small class="text-danger">{{ $errors->first('buycoin_currency') }}</small>
        </div>

        <div class="form-group{{ $errors->has('buycoin_level') ? 'has-error' : ''}} buy_coin" style="display: none;">
            <label>{{ trans('admin_usergroup.buy_coin') }}</label>
            <select class="form-control buycoin_level" id="buycoin_level" name="buycoin_level">
                <option value="">select</option>
                <option value="above">Above</option>
                <option value="between">Between</option>
            </select>
            <small class="text-danger">{{ $errors->first('buycoin_level') }}</small>
        </div> 

        <div class="form-group{{ $errors->has('buycoin_amt') ? 'has-error' : ''}} buycoin_above" style="display: none;">
            <label>{{ trans('admin_usergroup.amt') }}</label>
            <input type="text" name="buycoin_amt" value="{{ old('buycoin_amt') }}" class="form-control">
            <small class="text-danger">{{ $errors->first('buycoin_amt') }}</small>
        </div> 

        <div class="form-group{{ $errors->has('from_amt') ? 'has-error' : ''}} buycoin_between" style="display: none;">
            <label>{{ trans('admin_usergroup.from_amt') }}</label>
            <input type="text" name="from_amt" value="{{ old('from_amt') }}" class="form-control">
            <small class="text-danger">{{ $errors->first('from_amt') }}</small>
        </div> 

        <div class="form-group{{ $errors->has('to_amt') ? 'has-error' : ''}} buycoin_between" style="display: none;">
            <label>{{ trans('admin_usergroup.to_amt') }}</label>
            <input type="text" name="to_amt" value="{{ old('to_amt') }}" class="form-control">
            <small class="text-danger">{{ $errors->first('to_amt') }}</small>
        </div> 


        <label>{{ trans('admin_usergroup.rule8') }}</label><label>{{ trans('admin_usergroup.status') }}</label><br>

        <input type="checkbox" class="checkboxthree" name="rulethree" value="3"><br>
        <div class="form-group{{ $errors->has('status') ? 'has-error' : '' }} rulethree" style="display:none;">
            <label>{{ trans('admin_usergroup.status') }}</label>
            <select class="form-control" id="status" name="status">
                <option value="">Select</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            <small class="text-danger"> {{ $errors->first('status') }}</small> 
        </div> 

        <div class="form-group">
            {!! Form::submit(trans('forms.submit_btn'), ['class' => 'btn btn-primary']) !!}
            <a href=" " class='btn btn-default'>{{ trans('forms.reset') }}</a>
        </div>
</form>
</div>

@push('datescripts')

<link rel='stylesheet' type='text/css' href='stylesheet.css'/>
    <link rel='stylesheet' type='text/css' href='http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css'/>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

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

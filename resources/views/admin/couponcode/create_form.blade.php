<div class="col-md-12">
    <form method="post" action="" class="form-horizontal" >
        {{ csrf_field() }} 
        {{--<div class="form-group{{ $errors->has('no_of_code') ? ' has-error' : '' }}">
            <label>{{ trans('admin_coupon.no_coupon_code') }}</label>
            <input type="text" name="no_of_code" value="{{ old('no_of_code') }}" class="form-control"  placeholder="Enter the Number Of Coupon Code">
            <small class="text-danger">{{ $errors->first('no_of_code') }}</small>
        </div>--}}

        <div class="form-group{{ $errors->has('coupon_name') ? ' has-error' : '' }}">
            <label>{{ trans('admin_coupon.coupon_name') }}</label>
            <input type="text" name="coupon_name" value="{{ old('coupon_name') }}" class="form-control">
            <small class="text-danger">{{ $errors->first('coupon_name') }}</small>
        </div>

        <div class="form-group{{ $errors->has('coupon_type') ? 'has-error' : '' }}">
            <label>{{ trans('admin_coupon.coupon_type') }}</label>
                <select class="form-control" id="coupon_type" name="coupon_type">
                    <option value="">Select</option>
                    <option value="flat">Flat Value</option>
                    <option value="percentage">Percentage</option>
                </select>
            <small class="text-danger"> {{ $errors->first('coupon_type') }}</small> 
        </div> 

        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
            <label>{{ trans('admin_coupon.amt') }}</label>
            <input type="text" name="amount" value="{{ old('amount') }}" class="form-control"  placeholder="Enter the Amount">
            <small class="text-danger">{{ $errors->first('amount') }}</small>
        </div>

        <div class="form-group{{ $errors->has('currency') ? 'has-error' : '' }}">
            <label>{{ trans('admin_coupon.apply_to') }}</label>
                <select class="form-control" id="currency" name="currency">
                    <option value="">Select</option>
                        @foreach($currency as $key=>$currencies)
                            <option value="{{ $currencies->id }}">
                                {{ $currencies->displayname }}
                            </option>
                        @endforeach
                </select>
            <small class="text-danger"> {{ $errors->first('currency') }}</small> 
        </div> 

        <div class="form-group{{ $errors->has('applies_to') ? 'has-error' : '' }}">
            <label>{{ trans('admin_coupon.applies_to') }}</label>
                <select class="form-control appliesto" id="applies_to" name="applies_to">
                    <option value="">Select</option>
                    <option value="user">User</option>
                    <option value="usergroup">UserGroup</option>
                </select>
            <small class="text-danger"> {{ $errors->first('applies_to') }}</small> 
        </div>

        <div class="form-group{{ $errors->has('membergroup') ? 'has-error' : '' }} usergroups" style="display: none;">
            <label>{{ trans('admin_usergroup.usergroup_name') }}</label>
                <select class="form-control" id="membergroup" name="membergroup">
                    <option value="">Select</option>
                        @foreach($membergroup as $key=>$group)
                            <option value="{{ $group->id }}">
                                {{ $group->usergroup_name }}
                            </option>
                        @endforeach
                </select>
            <small class="text-danger"> {{ $errors->first('membergroup') }}</small> 
        </div>  

        <label>{{ trans('admin_coupon.per_user') }}Limit</label><br>

        <input type="checkbox" class="checkboxlimit" name="limit" value="1"><br>
        <div class="form-group{{ $errors->has('count') ? ' has-error' : '' }} checkboxcount" style="display: none;" >
            <label>{{ trans('admin_coupon.count') }}</label>
            <input type="text" name="count" value="{{ old('count') }}" class="form-control">
            <small class="text-danger">{{ $errors->first('count') }}</small>
        </div>


        <div class="form-group{{ $errors->has('valid_from') ? 'has-error' : '' }}">
            <label> {{ trans('admin_coupon.valid_from') }} </label>
            <input type="text" name="valid_from" class="form-control" value="{{ old('valid_from') }}" id="fromdate">
            <small class="text-danger"> {{ $errors->first('valid_from') }}</small>  
        </div>

        <div class="form-group{{ $errors->has('valid_to') ? 'has-error' : '' }}">
            <label> {{ trans('admin_coupon.valid_to') }} </label>
            <input type="text" name="valid_to" class="form-control" value="{{ old('valid_to') }}" id="todate">
            <small class="text-danger"> {{ $errors->first('valid_to') }}</small> 
        </div>
        

        <div class="form-group{{ $errors->has('status') ? 'has-error' : '' }}">
            <label> {{ trans('admin_coupon.status') }} </label>
            <select class="form-control" id="status" name="status">
                    <option value="">Select</option>
                    <option value="unused">Unused</option>
                    <option value="used ">Used</option>
                    <option value="partial ">Partial</option>
                </select>
            <small class="text-danger"> {{ $errors->first('status') }}</small> 
        </div>

        {{--<div class="form-group{{ $errors->has('per_user') ? 'has-error' : '' }}">
            <label> {{ trans('admin_coupon.per_user') }} </label>
            <input type="text" name="per_user" class="form-control" value="{{ old('per_user') }}">
            <small class="text-danger"> {{ $errors->first('per_user') }}</small> 
        </div>


        <div class="form-group{{ $errors->has('expire_date') ? 'has-error' : '' }}">
            <label> {{ trans('admin_coupon.expire_date') }} </label>
            <input type="date" name="expire_date" class="form-control" value="{{ old('expire_date') }}">
            <small class="text-danger"> {{ $errors->first('expire_date') }}</small> 
        </div>--}}
 
        <div class="form-group">
            <input value="Submit" class="btn btn-primary" type="submit"> 
            <a href="" class='btn btn-info'>{{ trans('admin_coupon.cancel') }}</a>
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
                $("#fee").click(function() 
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
            $('.checkboxlimit').on('change', function() 
            {
                $('.checkboxcount').toggle();
            });
        });
    </script>

    <!-- <script type="text/javascript">
        $(document).ready(function() 
        {
            $('.appliesto').on('change', function() 
            {
                $('.usergroups').toggle();
            });
        });
    </script> -->

    <script>
    $('.appliesto').change(function()
    {
        val= $(this).val();

        if(val=='usergroup')
        {
            $('.usergroups').css('display','block');
        }

        if(val=='user')
        {
            $('.usergroups').css('display','none');
        }
    });
    </script>


@endpush
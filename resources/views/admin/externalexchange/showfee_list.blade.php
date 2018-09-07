<div class="mt-20 mb-20" style="overflow-x:scroll;">
    <form  method="POST" role="search">
        {{ csrf_field() }}
        <div class="col-md-12 ">
            <div class="row">
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" placeholder="Search Logname or Description"> 
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default" name="searchbutton">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                    </div>
                </div>
                <a href="{{ url('admin/exportcrypto') }}" class="btn btn-success pull-right">{{ trans('export.exports') }}</a>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('from_date') ? 'has-error' : '' }}">
                        <label> {{ trans('forms.from_date') }} </label>
                        <input type="text" name="from_date" class="form-control" value="{{ old('from_date') }}" id="fromdate">
                        <small class="text-danger"> {{ $errors->first('from_date') }}</small>  
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('to_date') ? 'has-error' : '' }}">
                        <label> {{ trans('forms.to_date') }} </label>
                        <input type="text" name="to_date" class="form-control" value="{{ old('to_date') }}" id="todate">
                        <small class="text-danger"> {{ $errors->first('to_date') }}</small> 
                    </div>
                </div>

                <div class="col-md-4">
                    <label></label>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default" id="fee" name="datebutton">{{ trans('admin_fee.submit') }}</button> 
                        <button type="reset" class="btn btn-default">{{ trans('admin_fee.reset') }}</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <form  method="POST" role="search" action="{{ url('/admin/externalexchangefee') }}">
                    <div class="col-md-10">
                        <div class="form-group{{ $errors->has('report') ? ' has-error' : '' }}">
                            <label>{{ trans('forms.report') }}</label>
                            <select class="form-control" id="report" name="report">  
                                <option value="">Select Option</option>
                                <option value="daily">Daily</option>
                            </select>
                            <small class="text-danger">{{ $errors->first('report') }}</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label></label>
                        <div class="form-group"><button type="submit" class="btn btn-default" name="reportbutton">{{ trans('admin_fee.submit') }}</button></div>
                    </div>
                </form>
            </div>                
        </div>      
    </form>
</div>
    <table class="table table-bordered table-striped dataTable"  id="currencypair">
        <thead>
            <tr>                
                <th>{{ trans('admin_fee.user') }}</th>
                <th>{{ trans('admin_fee.from_currency') }}</th>
                <th>{{ trans('admin_fee.to_currency') }}</th>                            
                <th>{{ trans('admin_fee.fee') }}</th>               
                <th>{{ trans('admin_fee.date') }}</th>  
            </tr>
        </thead>
            <tbody>
                @foreach($searchusers as $txn)
                      <tr>                     
                        <td><a href="{{ url('admin/users') }}/{{ $txn->externalexchange->user->id }} ">
                        <strong>{{ $txn->externalexchange->user->name }}</strong></a></td>
                        <td>{{ $txn->externalexchange->from_currency->token }}</td>
                        <td>{{ $txn->externalexchange->to_currency->token }}</td>  
                        <td>{{ $txn->externalexchange->fee_total }}</td>  
                        <td>{{ $txn->created_at->format('Y-m-d H:i:s') }}</td>  
                        </tr>
                @endforeach
            </tbody>
    </table>
 </div>
{{$searchusers->links()}}

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


@endpush

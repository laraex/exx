<a href="{{ url('admin/exportadminearnings') }}" class="btn btn-success pull-right">{{ trans('export.exports') }}</a>
    <form  method="POST" role="search">
     {{ csrf_field() }}
        <div class="mt-20 mb-20">
            <div class="p-10">
                <div class="row">
                    <div class="flex wallet-box">
                        @foreach ($walletlists as $walletlist)
                            <div class="wallet-balance-box">
                                <div><img src="{{ url($walletlist->currency->image) }}" class="flag-image"></div>
                                <div><strong> {{ $walletlist->currency->name }} Wallet</strong></div>
                                <div>{{ $walletlist->currency->name }} <span> {{ $walletlist->present()->getAdminEarnings($walletlist->currency->id, $walletlist->user_id) }}</span></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    <table class="table table-bordered table-striped dataTable"  id="earningdatatable">
        <div class="col-md-12 ">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('from_date') ? 'has-error' : '' }}">
                        <label> {{ trans('forms.from_date') }} </label>
                        <input type="text" name="from_date" class="form-control" value="{{ old('from_date') }}" id="fromdate" placeholder="MM/DD/YYYY">
                        <small class="text-danger"> {{ $errors->first('from_date') }}</small>  
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('to_date') ? 'has-error' : '' }}">
                        <label> {{ trans('forms.to_date') }} </label>
                        <input type="text" name="to_date" class="form-control" value="{{ old('to_date') }}" id="todate" placeholder="MM/DD/YYYY">
                        <small class="text-danger"> {{ $errors->first('to_date') }}</small> 
                    </div>
                </div>

                <div class="col-md-4">
                    <label></label>
                        <div class="form-group"><button type="submit" class="btn btn-default" id="earn">{{ trans('admin_earnings.submit') }} </button> <button type="reset" class="btn btn-default">{{ trans('admin_earnings.reset') }}</button></div>
                </div>
            </div>
        </div>
    </form>

        <thead>
            <tr>        
                <th>{{ trans('admin_earnings.amt') }}</th>
                <th>{{ trans('admin_earnings.earnings_type') }}</th>       
                <th>{{ trans('admin_earnings.credited_from') }}</th>
                <th>{{ trans('admin_earnings.credited_to') }}</th>      
            </tr>
        </thead>
            <tbody>
                @foreach($earnings as $data)
                @php 
                  $fromdetails = json_decode($data['request'], true);  
                @endphp
                    <tr>
                        <td>{{ $data->amount }} {{ $data->present()->getCurrencyName($data->account_id) }}</td>
                        <td>{{ str_replace('-', ' ',$data->accountingcode->accounting_code) }}</td>

                        @if(isset($fromdetails['userid']))
                               <td><a href="{{ url('admin/users/'.$fromdetails['userid']) }}">{{ ucfirst($data->present()->getUsername($fromdetails['userid'])) }}</a></td>
                        @else
                        <td>-</td>
                        @endif
                            <td>{{ $data->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                 @endforeach
            </tbody>
    </table>
</div>

@include('admin.datatable')
    @push('scripts')
        <script>
            $(document).ready(function(){
                $('#earningdatatable').DataTable();
            });
        </script>
            <link rel='stylesheet' type='text/css' href='stylesheet.css'/>
            <link rel='stylesheet' type='text/css' href='http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css'/>
            <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
                <script type="text/javascript">
                    $(document).ready(function() 
                    {
                        $("#fromdate").datepicker();
                        $("#todate").datepicker();
                        $("#earn").click(function() 
                        {
                            var fromdate = $("#fromdate").val();
                            var todate = $("#todate").val();
                            if (fromdate === "" || todate === "") {
                                alert("Please select fromdate and todate dates.");
                            } else 
                            {
                                confirm("Would you like to go to " + selected + " on " + fromdate + " and return on " + todate + "?");
                            }
                        });
                    });
            </script>
    @endpush
<div class="mt-20 mb-20">
<form  method="POST" role="search">
  {{ csrf_field() }}
    <div class="input-group">
      <input type="text" class="form-control" name="q" placeholder="Search Logname or Description"> 
        <span class="input-group-btn">
          <button type="submit" class="btn btn-default">
            <span class="glyphicon glyphicon-search"></span>
          </button>
          <a href="{{ url('admin/exportactivitylogs') }}" class="btn btn-success pull-right">{{ trans('export.exports') }}</a>
        </span>
    </div>

  <table class="table table-bordered table-striped dataTable"  id="">
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
                  <div class="form-group"><button type="submit" class="btn btn-default" id="log">Submit</button> <button type="reset" class="btn btn-default">{{ trans('forms.reset')}}</button></div>
          </div>
      </div>
    </div>
    </form>
<thead>
    <tr>
        <th>{{ trans('admin_activitylog.symbol') }}</th>
        <th>{{ trans('admin_activitylog.logname') }}</th>
        <th>{{ trans('admin_activitylog.username') }}</th>
        <th>{{ trans('admin_activitylog.description') }}</th>        
        <th>{{ trans('admin_activitylog.ip_address') }}</th>
        <th>{{ trans('admin_activitylog.date') }}</th>
    </tr>
</thead>
<tbody>
@foreach($searchlog as $data)
@php 
  $properties = json_decode($data['properties'], true); 
  $ip_address = '';
  if ( isset($properties['ip']))
  {
        $ip_address = $properties['ip'];
  }
@endphp
    <tr>
        <td>{{ $loop->iteration }} </td>
        <td>{{ ucfirst($data->log_name) }}</td>
        <td>
          <a href="{{ url('admin/users/'.$data->loguser->id) }}">
            {{ $data->loguser->name }}
            </a>
        </td>
        <td>{{ $data->description }}</td>
        <td>{{ $ip_address }}</td>
        <td>{{ $data->created_at->format('d/m/Y H:i:s') }}</td>
    </tr>
 @endforeach
</tbody>
</table>
{{$searchlog->links()}}
</div>
@push('scripts')
  </script>
    <link rel='stylesheet' type='text/css' href='stylesheet.css'/>
    <link rel='stylesheet' type='text/css' href='http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css'/>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() 
            {
                $("#fromdate").datepicker();
                $("#todate").datepicker();
                $("#log").click(function() 
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
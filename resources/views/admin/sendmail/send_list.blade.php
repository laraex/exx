 <div class="mt-20 mb-20" style="overflow-x:scroll;">
 <form  method="POST" role="search" action="{{url('/admin/sendmail/search')}}">
    {{ csrf_field() }}

    <a href="{{ url('admin/exportsendmail') }}" class="btn btn-success pull-right">{{ trans('export.exports') }} </a><br><br>
      
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
                            <div class="form-group"><button type="submit" class="btn btn-default" id="mail">{{ trans('mail.submit') }}</button> <button type="reset" class="btn btn-default">{{ trans('mail.reset') }}</button></div>
                    </div>
                </div>
            </div>
                </form>
   <table class="table table-bordered table-striped dataTable"  id="">
            <thead>
                <tr>                
                    <th>{{ trans('mail.name') }}</th>               
                    <th>{{ trans('mail.subject') }}</th>               
                    <th>{{ trans('mail.msg') }}</th> 
                    <th>{{ trans('mail.date') }}</th>
                </tr>
            </thead>
                <tbody>
                    @foreach($list as $send)
                        <tr>
                            <td><a href="{{ url('admin/users') }}/{{ $send->user_id }} ">
                            <strong>{{ $send->user->name }}</strong></a></td>
                            <td>{{ $send->subject }}</td>
                            <td><a class='viewmessage' href="#" data-toggle='modal' data-target1='{{ $send->id }}'> {{ trans('mail.view_msg') }}</a></td>
                            <td>{{ $send->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>

        </table>
    
</div>
    
    <div class="modal fade" id="message-modals" role="dialog"></div>
{{$list->links()}}

@push('scripts')
    <script>
        $('.viewmessage').on('click', function () {
            var $this = $(this).data('target1');
            $('#message-modals').load("{{url('admin/viewmessage')}}/" + $this, function (response, status, xhr) {
                if (status == "success") {
                    $(response).modal('show');
                }
            });
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
                $("#mail").click(function() 
                {
                    var fromdate = $("#fromdate").val();
                    var todate = $("#todate").val();
                    if (fromdate === "" || todate === "") 
                    {
                        alert("{{ trans('mail.select_date') }}");
                    } 
                    // else 
                    // {
                    //     confirm("Would you like to go to " + selected + " on " + fromdate + " and return on " + todate + "?");
                    // }
                });
            });
        </script>
@endpush
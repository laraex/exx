<table class="table dataTable"  id="staffsdatatable">
<thead>
    <tr>        
        <th>{{ trans('admin_user.name') }}</th>
        <th>{{ trans('admin_user.doj') }}</th>
        <th>{{ trans('admin_user.tickets') }}</th>  
        <th>{{ trans('admin_user.action') }}</th>  
    </tr>
</thead>
<tbody>
@foreach($staffs as $data)

    <tr>
        <td>{{ $data->name }}</td>
        <td>{{ $data->created_at->format('d/m/Y H:i:s') }}</td>
        <td>{{ count($data->agent) }}</td>
        <td>
            <a href="{{ url('/users/'.$data->id.'/impersonate') }}" class="btn btn-primary btn-xs"> {{ trans('admin_user.login_as_user') }}</a>&nbsp;
            <a id="reset" href="{{ url('/admin/users/resetpassword/'.$data->id) }}" class="btn btn-danger btn-xs">{{ trans('admin_user.reset_password') }}</a>
        </td>
        
    </tr>
 @endforeach
</tbody>
</table>

<!-- @include('admin.datatable') -->

@push('scripts')
<script>
    $(document).ready(function(){
        $('#staffsdatatable').DataTable();

        $("#reset").on("click", function()
        {
        return confirm("{{ trans('admin_user.reset_pwd_user') }}");
    });
    });
</script>
@endpush
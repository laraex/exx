<div class="mt-20 mb-20">
<table class="table table-bordered table-striped dataTable"  id="loggeddatatable">
<thead>
    <tr>
        <th>{{ trans('admin_loggedin.username') }}</th>           
        <th>{{ trans('admin_loggedin.ip_address') }}</th>
        <th>{{ trans('admin_loggedin.date') }}</th>
    </tr>
</thead>
<tbody>
    @foreach($loggedinlist as $list)
    <tr>
        <td><a href="{{ url('admin/users/'.$list->user->id) }}">{{ $list->user->name }}</a></td>
        <td>{{ $list->ip_address }}</td>
        <td>{{ $list->last_activity->format('d/m/Y H:i:s') }}</td>
    </tr>
 @endforeach
</tbody>
</table>

</div>

@include('admin.datatable')

@push('scripts')
<script>
    $(document).ready(function(){
        $('#loggeddatatable').DataTable();
    });
</script>
@endpush
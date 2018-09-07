<div class="tab-container">
<h3>{{ trans('admin_user.log') }}</h3>
<table class="table table-bordered table-striped dataTable"  id="activitydatatable">
<thead>
    <tr>
        <th>{{ trans('admin_user.symbol') }}</th>
        <th>{{ trans('admin_user.subject') }}</th> 
        <th>{{ trans('admin_user.description') }}</th>
        <th>{{ trans('admin_user.ip_address') }}</th>               
        <th>{{ trans('admin_user.date') }}</th>      
    </tr>
</thead>
<tbody>
@foreach($user->loguser as $log)
<?php
$properties = json_decode($log['properties'], true);
?> 
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ ucfirst($log->log_name) }}</td>       
        <td>{{ $log->description }}</td>  
        <td>{{ $properties['ip'] }}</td>      
        <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>     
    </tr>
 @endforeach
</tbody>
</table>
</div>
@push('scripts')
<script>
    $(document).ready(function()
    {
        $('#activitydatatable').DataTable();
    });
</script>
@endpush
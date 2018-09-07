<div class="tab-container">
<h3>{{ trans('admin_user.history') }}</h3>
<table class="table table-bordered table-striped dataTable"  id="logindatatable">
<thead>
    <tr>
        <th>{{ trans('admin_user.symbol') }}</th>
        <th>{{ trans('admin_user.subject') }}</th> 
        <th>{{ trans('admin_user.ip_address') }}</th>               
        <th>{{ trans('admin_user.date_time') }}</th>      
    </tr>
</thead>
<tbody>
@foreach($loginhistory as $data)
<?php
$properties = json_decode($data['properties'], true);
?> 
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td> {{ $data->description }} </td>       
        <td>{{ $properties['ip'] }}</td>        
        <td>{{ $data->created_at->format('d/m/Y H:i:s') }}</td>        
    </tr>
 @endforeach
</tbody>
</table>
</div>
@push('scripts')
<script>
    $(document).ready(function()
    {
        $('#logindatatable').DataTable();
    });
</script>
@endpush
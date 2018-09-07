<div class="tab-container">
	<h3>{{ trans('admin_user.fund_transfer_list') }}</h3>
	<table class="table table-bordered" id="fundtransfersenddatatable">
	    <thead>
		    <tr>
		        <th>{{ trans('admin_user.receiver') }}</th>
		        <th>{{ trans('admin_user.amt') }}</th>
		        <th>{{ trans('admin_fundtransfer.transaction_id') }}</th> 
		        <th>{{ trans('admin_user.send_date') }}</th>            
		    </tr>
	    </thead>
	    <tbody>
		        @foreach($sendtransferlists as $data)
		        <tr>
		            <td>{{ $data->present()->getUsername($data->fundtransfer_to_id->user_id) }}</td>
		            <td>{{ $data->amount }}</td> 
		            <td>{{ $data->transaction_id }}</td> 
		            <td>{{ $data->created_at->format('d/m/Y H:i:s') }}</td>
		        </tr>
		         @endforeach
	     	
	    </tbody>
	</table>
 </div>
 
 @push('scripts')
<script>
    $(document).ready(function(){
        $('#fundtransfersenddatatable').DataTable();

    });
</script>
@endpush
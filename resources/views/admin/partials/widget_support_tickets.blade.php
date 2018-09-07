<div class="widget draggable ui-widget-content" id="6">
  <div class="widget-header">
    <h2 class="widget-heading"><i class="fa fa-ticket" aria-hidden="true"></i></i>{{ trans('admin_dashboard.support_ticket') }} <span class="pull-right"><i class="fa fa-arrows widget-move" aria-hidden="true"></i></span></h2>
  </div>
  <div class="widget-body">
  <p></p>
     @foreach($ticketlist as $data)
    <div class="widget-data">
        @php 
          $request = json_decode($data['request'], true); 
        @endphp
        <div class="flex-left">
    		<div class="widget-data-item widget-data-user">{{ trans('admin_dashboard.from') }} <a href="{{ url('admin/users/'.$data->user->id) }}">
              {{ $data->user->name }}
                </a></div>
        </div>
        <div class="flex-center">
            <div class="widget-data-item">{{ trans('admin_dashboard.subject') }} <a href="{{ url('admin/ticket/'.$data['id']) }}">{{ $data['subject'] }}</a></div>
        </div>
        <div class="flex-right">
	        <div class="widget-data-item widget-data-user">{{ trans('admin_dashboard.agent') }} <a href="{{ url('admin/staffs') }}">{{ $data->agent->name }}</a></div>
	         <div class="widget-data-item"><small>{{ $data->created_at->diffForHumans() }}</small></div>
        </div>
    </div>
	@endforeach
 </div>
  <div class="widget-footer text-muted">
    <a href="{{ url('admin/message/send') }}" class="btn btn-primary">{{ trans('admin_dashboard.msg') }}</a>   
  </div>
</div>
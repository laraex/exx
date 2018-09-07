<div class="widget draggable ui-widget-content" id="10">
  <div class="widget-header">
    <h2 class="widget-heading"><i class="fa fa-user-circle-o" aria-hidden="true"></i></i></i>{{ trans('admin_dashboard.recent_sign') }} <span class="pull-right"><i class="fa fa-arrows widget-move" aria-hidden="true"></i></span></h2>
  </div>
  <div class="widget-body">
    @foreach($signedupuserslists as $data)
    <div class="widget-data">
        @php 
          $request = json_decode($data['request'], true); 
        @endphp
        <div class="flex-left">
    	
        </div>
     	<div class="flex-center">
            <div class="widget-data-item widget-data-user">{{ trans('admin_dashboard.username') }} <a href="{{ url('admin/users/'.$data->user->id) }}">
              {{ $data->user->name }}
                </a></div>
            <div class="widget-data-item">{{ trans('admin_dashboard.email') }} <a href="{{ url('admin/users/'.$data->user->id) }}">
              {{ $data->user->email }}
                </a></div>
            <div class="widget-data-item"><small>{{ $data->created_at->diffForHumans() }}</small></div>
        </div>
        <div class="flex-right">
            
        </div>
  	</div>
	@endforeach
 </div>
  <div class="widget-footer text-muted">
    <a href="{{ url('admin/users') }}" class="btn btn-primary">{{ trans('admin_dashboard.go_to_user') }}</a>   
  </div>
</div>
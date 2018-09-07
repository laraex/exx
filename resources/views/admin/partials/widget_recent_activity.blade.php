<div class="widget draggable ui-widget-content" id="111">
  <div class="widget-header">
    <h2 class="widget-heading"><i class="fa fa-user-circle-o" aria-hidden="true"></i></i></i>Recent Activity <span class="pull-right"><i class="fa fa-arrows widget-move" aria-hidden="true"></i></span></h2>
  </div>
  <div class="widget-body">
    @foreach($recent_activity as $data)
    @if($data->status!=null)
    <div class="widget-data">

        <div class="flex-left">
        </div>
     	<div class="flex-center">
            <div class="widget-data-item widget-data-user"> <a href="javascript:void(0);">
            <a href="{{ url('admin/users') }}/{{ $data->user_id }} ">
                            <strong>{{ $data->user->name }}</strong>
                            </a>
                </a></div>
            @if($data->status=='pending')
                <div class="widget-data-item"> <a href="javascript:void(0);">
                    placed order # {{ $data->id }} to {{$data->type}} {{$data->quantity}} 
                    @if($data->type=='buy')
                         {{$data->fromcurrency->token }}
                     @endif
                     @if($data->type=='sell')
                         {{$data->tocurrency->token }}
                     @endif 

                     at {{$data->amount}} 
                     @if($data->type=='sell')
                         {{$data->fromcurrency->token }}

                     @endif
                     @if($data->type=='buy')
                         {{$data->tocurrency->token }}
                        
                     @endif

                </a></div>
                <div class="widget-data-item"><small>{{ $data->created_at->diffForHumans() }}</small></div>
            @endif

                 @if($data->status=='cancel')
                <div class="widget-data-item"> <a href="javascript:void(0);">
                    cancel order # {{ $data->id }}
                </a></div>
                <div class="widget-data-item"><small>{{ $data->created_at->diffForHumans() }}</small></div>
                @endif
                @if($data->status=='complete')
                <div class="widget-data-item"> <a href="javascript:void(0);">
                     completed order # {{ $data->id }}
                </a></div>
                <div class="widget-data-item"><small>{{ $data->created_at->diffForHumans() }}</small></div>
                @endif 
                @if($data->status=='partialcomplete')
                <div class="widget-data-item"> <a href="javascript:void(0);">
                     processing order # {{ $data->id }}
                </a></div>
                <div class="widget-data-item"><small>{{ $data->created_at->diffForHumans() }}</small></div>
                @endif 

            
        </div>
        <div class="flex-right">

        </div>

      </div>
      @endif
	@endforeach
 </div>
</div>

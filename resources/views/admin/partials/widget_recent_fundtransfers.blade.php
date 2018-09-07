<div class="widget draggable ui-widget-content" id="9">
  <div class="widget-header">
    <h2 class="widget-heading"><i class="fa fa-exchange" aria-hidden="true"></i>{{ trans('admin_dashboard.fund_transfer') }} <span class="pull-right"><i class="fa fa-arrows widget-move" aria-hidden="true"></i></span></h2>
  </div>
  <div class="widget-body">
  <p></p>
    @foreach($transferfunds as $data)
    <div class="widget-data">
        @php 
          $request = json_decode($data['request'], true); 
        @endphp
        <div class="flex-left">
             <div class="widget-data-item widget-data-amount">
                <strong>{{ $data->amount }}</strong> 
                   {{ $data->present()->getCurrencyName($data->to_account_id) }} 
                  {{--@if(count($data->currency)>0)
                    {{ $data->currency[0]->token}}
                  @endif--}}
            </div>

             <div class="widget-data-item widget-data-user">{{ trans('admin_dashboard.from') }} <a href="{{ url('admin/users/'.$data->fundtransfer_from_id->user_id) }}">
              {{ ucfirst($data->present()->getUsername($data->fundtransfer_from_id->user_id)) }}

                </a></div> 

          {{--<div class="widget-data-item widget-data-user">{{ trans('admin_dashboard.from') }} <a href="{{ url('admin/users/'.$data->from_user[0]->id) }}">
              {{ $data->from_user[0]->name }}
              
                </a></div>--}}
        </div>
        <!-- <div class="flex-center">
            <div class="widget-data-item">Fund From : </div>
           <div class="widget-data-item"></div>
        </div> -->
        <div class="flex-right">
            <div class="widget-data-item"><small>{{ $data->created_at->diffForHumans() }}</small></div>
            <div class="widget-data-item widget-data-user">{{ trans('admin_dashboard.to') }} <a href="{{ url('admin/users/'.$data->fundtransfer_to_id->user_id) }}">
              {{ ucfirst($data->present()->getUsername($data->fundtransfer_to_id->user_id)) }}
                </a></div>
        </div>
  </div>
@endforeach
 </div>
  <div class="widget-footer text-muted">
    <a href="{{ url('admin/users') }}" class="btn btn-primary">{{ trans('admin_dashboard.go_to_user') }}</a>   
  </div>
</div>
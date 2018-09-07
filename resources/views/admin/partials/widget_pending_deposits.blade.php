<div class="widget draggable ui-widget-content" id="1">
  <div class="widget-header">
    <h2 class="widget-heading"><i class="fa fa-credit-card" aria-hidden="true"></i>{{ trans('admin_dashboard.fund_approve') }} <span class="pull-right"><i class="fa fa-arrows widget-move" aria-hidden="true"></i></span></h2>
  </div>
  <div class="widget-body">
  <p></p>
@foreach($pendingdepositfunds as $data)
    <div class="widget-data">
        @php 
          $request = json_decode($data['request'], true); 
        @endphp
        <div class="flex-left">
             <div class="widget-data-item widget-data-amount">
                <strong>{{ $data->amount }} </strong> {{ $data->currency->token }} 
            </div>
            <div class="widget-data-item widget-data-user">{{ trans('admin_dashboard.by') }} <a href="{{ url('admin/users/'.$data->user_id) }}">
             {{-- {{ $data->present()->getTransactionUsername($data->account_id) }} --}}
            @if(count($data->user)>0)
              {{ $data->user->name }} 
            @endif
                </a></div>
             
        </div>
        <div class="flex-center">
            <div class="widget-data-item">{{ trans('admin_dashboard.fund_to') }}
              {{-- {{ $data->present()->getTransactionAccountName($data->account_id) }} --}}
             {{--  @if(count($data->usercurrencyaccount)>0)
            

              @endif --}}
                  {{ $data->present()->getAccountNo($data->user->id,$data->currency->id)}}
            </div>
            <div class="widget-data-item">{{ $data->present()->getTransactionPaymentName($request['user']['payment_id']) }}</div>
        </div>
        <div class="flex-right">
            <div class="widget-data-item"> <a href="{{ url('admin/depositfund/confirm/'.$data->id) }}" class="btn btn-success btn-xs flex-button" onclick="return (confirm('{{ trans("admin_dashboard.approve_deposit") }}'))">{{ trans('admin_dashboard.confirm') }} </a>   </div>
            <div class="widget-data-item"><small>{{ $data->created_at->diffForHumans() }}</small></div>
        </div>
  </div>
@endforeach
 </div>
  <div class="widget-footer text-muted">
<a href="{{ url('admin/actions/fund') }}" class="btn btn-primary">{{ trans("admin_dashboard.view_all") }}</a>   
  </div>
</div>
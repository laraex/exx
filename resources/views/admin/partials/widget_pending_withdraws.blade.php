<div class="widget draggable ui-widget-content" id="2">
  <div class="widget-header">
    <h2 class="widget-heading"><i class="fa fa-usd" aria-hidden="true"></i>{{ trans('admin_dashboard.withdraw_req') }} <span class="pull-right"><i class="fa fa-arrows widget-move" aria-hidden="true"></i></span></h2>
  </div>
  <div class="widget-body">
  <p></p>
    @foreach($withdrawlists as $data)
    <div class="widget-data">
        @php 
          $request = json_decode($data['request'], true); 
        @endphp
        <div class="flex-left">
             <div class="widget-data-item widget-data-amount">
                <strong>{{ $data->amount }}</strong> @unless(is_null($data->transaction))
                {{ $data->userpayaccounts->paymentgateways->currency->name}}
          
            @if(count($data->transaction)>0)
              @if(count($data->transaction->currency))
                {{ $data->transaction->currency->token }}
              @endif
            @endif
            @endunless
            </div>
    		<div class="widget-data-item widget-data-user">{{ trans('admin_dashboard.by') }} <a href="{{ url('admin/users/'.$data->user->id) }}">
              {{ $data->user->name }}
                </a></div>
        </div>
     	<div class="flex-center">
        <div class="widget-data-item">{{ trans('admin_dashboard.withdraw_from') }} 
          @unless(is_null($data->transaction))
            {{-- {{ $data->transaction->present()->getTransactionAccountName($data->transaction->account_id) }} --}}
            
          {{-- $data->transaction->usercurrencyaccount->account_no --}}  
           
          @endunless
        </div>
        
        <div class="widget-data-item">
          @unless(is_null($data->transaction))
           {{-- {{ $data->transaction->present()->getTransactionPaymentName($data->userpayaccounts->paymentgateways_id) }}--}}

           {{ $data->userpayaccounts->paymentgateways->displayname}}
          @endunless
        </div>
      </div>
        <div class="flex-right">
            <div class="widget-data-item"> <a href="{{ url('admin/withdraw/complete/'.$data['id'].'') }}" class="btn btn-success btn-xs flex-button" onclick="return (confirm('{{ trans("admin_dashboard.approve_withdraw") }}'))">{{ trans('admin_dashboard.confirm') }}</a></div>
            <div class="widget-data-item"><small>{{ $data->created_at->diffForHumans() }}</small></div>
        </div>
  </div>
@endforeach
 </div>
  <div class="widget-footer text-muted">
    <a href="{{ url('admin/withdraw/pending') }}" class="btn btn-primary">{{ trans("admin_dashboard.view_all") }}</a>   
  </div>
</div>
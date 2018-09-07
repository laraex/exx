  <div class="row">
  <div class="col-md-12">    
    <div class="table-responsive">          
        <table class="table table-bordered table-hover">
          <thead>
            <tr>        
              <th>{{ trans('forms.bitcoin_coinname_lbl') }}</th>
              <th>{{ trans('forms.bitcoin_btccode_lbl') }}</th>
              <th>{{ trans('forms.autowithdraw') }}</th>
              <th>{{ trans('forms.actions') }}</th>       
            </tr>
          </thead>
          <tbody>
          @foreach($bitcoin_result as $bitcoin)
            <tr>
              <td>{{ $bitcoin->param1 }}</td>
              <td>{{ $bitcoin->param2 }}</td>
               <td>
              @if($bitcoin->current == '1')
                <a class="bitcoinauto" href="{{ url('myaccount/currentaccounts/'.$bitcoin->id.'/'.$bitcoin->paymentgateways_id.'/'.$bitcoin->current)}}">{{ trans('forms.yes') }}</a>
              @else
                <a class="bitcoinauto" href="{{ url('myaccount/currentaccounts/'.$bitcoin->id.'/'.$bitcoin->paymentgateways_id.'/'.$bitcoin->current)}}">{{ trans('forms.no') }}</a>
              @endif
              </td>
              <td>
                   <form method="post" class="bitremovefrm" action="{{ url('myaccount/removeaccount/'.$bitcoin->id.'') }}">
                {{ csrf_field()}}
                <div class="form-group">
                          <button type="submit" value="Remove" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button>
                  </div>
                </form>
              </td>         
            </tr>
            @endforeach    
          </tbody>
        </table>
    </div>
</div>
  </div>
      @push('bottomscripts')
<script>
    $(".bitremovefrm").on("submit", function(){
        return confirm("{{ trans('forms.pay_account_remove_alert') }}");
    });
    $(".bitcoinauto").on("click", function(){
        return confirm("{{ trans('forms.auto_withdraw_alert') }}");
    });
</script>
@endpush
<h4>{{ trans('forms.my_bitcoin_direct') }}</h4>
@if(count($bitcoin_result) > 0)
   @include('home._mypayaccounts_bitcoin_direct_details')
@endif
<p>
<a href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#bitcoin_direct">{{ trans('forms.add_bitcoin_direct') }}</a>                       
</p>
<hr>
 <!-- Modal -->
  <div class="modal fade" id="bitcoin_direct" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ trans('forms.bitcoin_direct_details_form') }}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <form method="post" id="bitcoin_form" action="{{ url('myaccount/payaccounts')}}">
            {{ csrf_field() }}
              <div class="form-group">
                <label for="recipient-name" class="control-label">{{ trans('forms.bitcoin_coinname_lbl') }}</label>
                <input type="text" class="form-control" id="coinname" name="coinname">
              </div> 
              <div class="form-group">
                <label for="recipient-name" class="control-label">{{ trans('forms.bitcoin_address_lbl') }}</label>
                <input type="text" class="form-control" id="coincode" name="coincode">
              </div> 
              <div class="form-group">
              <input type="hidden" name="paymentid" value="1">
                   <input value="{{ trans('forms.submit_btn') }}" class="btn btn-success" id="payment" type="submit">      
              </div>           
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
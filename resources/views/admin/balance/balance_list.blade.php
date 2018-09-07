<div  class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="margin-top: 50px;">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('admin_memberbalance.member_balance')}}</h4>
            </div>
            <div class="modal-body">
                <div class="mt-20 mb-20" style="overflow-x:scroll;">
                    <table class="table table-bordered table-striped dataTable"  id="">
                        <thead>
                            <tr>                
                                <th>{{ trans('admin_memberbalance.currency')}}</th>               
                                <th>{{ trans('admin_memberbalance.balance')}}</th>
                                <th>{{ trans('admin_memberbalance.pending_balance')}}</th>          
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>{{ $btc->token }}</strong></td>
                                <td>{{sprintf(CURRENCY_DECIMAL,$balance)}}</td>
                                <td>-</td>
                            </tr>

                            <tr>
                                <td><strong>{{ $ltc->token }}</strong></td>
                                <td>{{sprintf(CURRENCY_DECIMAL,$balance_ltc)}}</td>
                                <td>-</td>
                            </tr>

                            <tr>
                                <td><strong>{{ $doge->token }}</strong></td>
                                <td>{{sprintf(CURRENCY_DECIMAL,$balance_doge)}}</td>
                                <td>-</td>
                            </tr>

                           
                            @foreach($walletlists as $walletlist)
                                <tr>
                                    <td>
                                        <strong>{{ $walletlist->currency->token }}</strong>
                                    </td>
                                    <td>                            
                                        <span> 
                                            {{ $walletlist->present()->getBalance($walletlist->currency->id, $walletlist->user_id) }}
                                        </span>
                                    </td>
                                <td>
                                    {{ $walletlist->present()->getPendingBalance($walletlist->currency->id, $walletlist->user_id) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


    


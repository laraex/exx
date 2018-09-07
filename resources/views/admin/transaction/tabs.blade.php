<div class="col-md-12 mb-20 mt-20">
  <ul class="nav justify-content-center nav-tabs">
    <li class="nav-item"><a href="{{url('admin/exchange/show')}}" class="nav-link {{Request::segment(3)=='exchange' ?'active':''}} ">{{trans('myaccount.exchange_txn')}}</a></li>
    <li class="nav-item"><a  href="{{url('admin/externalexchange/show')}}" class="nav-link {{Request::segment(3)=='externalexchange' ?'active':''}}">{{trans('myaccount.external_exchange_txn')}}</a></li>
    <li class="nav-item"><a  href="{{url('admin/buycoin/show')}}" class="nav-link {{Request::segment(3)=='buycoin' ?'active':''}}">{{trans('myaccount.buy_coin_txn')}}</a></li>
  </ul>
 </div>
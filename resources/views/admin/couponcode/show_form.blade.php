 <div class="mt-20 mb-20" style="overflow-x:scroll;">
    <table class="table table-bordered table-striped dataTable"  id="userdatatable">
        <thead>
            <tr>                
                <th>{{ trans('admin_coupon.coupon_name') }}</th>  
                <th>{{ trans('admin_coupon.coupon_type') }}</th>  
                <th>{{ trans('admin_coupon.amt') }}</th> 
                <th>{{ trans('admin_coupon.coupon_code') }}</th>               
                <th>{{ trans('admin_coupon.currency') }}</th>               
                <th>{{ trans('admin_coupon.applies_to') }}</th>               
                <th>{{ trans('admin_coupon.usergrp_name') }}</th>                    
                <th>{{ trans('admin_coupon.transaction_id') }}</th>
                {{--<th>{{ trans('admin_coupon.limit') }}</th>--}}
                <th>{{ trans('admin_coupon.count') }}</th>
                <th>{{ trans('admin_coupon.valid_from') }}</th>
                <th>{{ trans('admin_coupon.valid_to') }}</th>
                <th>{{ trans('admin_coupon.status') }}</th> 
                <th>{{ trans('admin_coupon.date') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($couponcodeLists as $couponcodeList)
                <tr>
                    <td>
                        @if(!is_null($couponcodeList->user_id))
                            <a href="{{ url('couponcode/show') }}/{{ $couponcodeList->user_id }} ">
                                <strong>{{ $couponcodeList->user->name }}</strong>
                            </a>  
                        @else
                            {{ $couponcodeList->coupon_name }}
                        @endif                    
                    </td>
                    <td>{{ $couponcodeList->coupon_type }}</td>
                    <td>{{ $couponcodeList->amount }}</td>                       
                    <td>{{ $couponcodeList->code }}</td>                   
                    <td>{{ $couponcodeList->Currency->displayname }}</td>       
                    <td>{{ $couponcodeList->applies_to }}</td>  
                    @if(count($couponcodeList->MemberGroup))
                        <td>{{ $couponcodeList->MemberGroup->usergroup_name }}</td>
                    @endif
                    <td>{{ $couponcodeList->transaction_id }}</td>
                    <td>{{ $couponcodeList->count }}</td>
                    <td>{{ $couponcodeList->valid_from }}</td>
                    <td>{{ $couponcodeList->valid_to }}</td>
                    <td>{{ $couponcodeList->status }}</td>
                    <td>{{ $couponcodeList->updated_at->format('d/m/Y H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>






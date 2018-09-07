<div class="mt-20 mb-20">
    <table class="table table-bordered table-striped dataTable"  id="userdatatable">
        <thead>
            <tr>                
              
                <th>{{ trans('myaccount.app_veri') }}</th>
                <th>{{ trans('myaccount.coin') }}</th>
              
                <th>{{ trans('myaccount.order_quantity') }}</th>
                <th>{{ trans('myaccount.transaction_id') }}</th>  
                <th>{{ trans('myaccount.condition') }}</th>              
 
            </tr>
        </thead>
        <tbody>
        @if(count($lists) > 0)
           @foreach($lists as $list)
           
               <tr> 
                   <td>{{$list->created_at}}</td>
                 
                 <td>{{optional($list->currency)->token}}</td>

         
                    <td>{{$list->amount}}</td>
                    <td>{{$list->transaction_id}}</td>
                     <td>{{trans('forms.pending')}} <a href="{{url('myaccount/bankwire/invoice/'.$list->id)}}" class="btn btn-primary">{{trans('forms.printinvoice')}}</a></td>
       
                </tr>
            @endforeach
        @else
            <td colspan="12">{{ trans('myaccount.noopenlist')}}</td>
        @endif
        </tbody>
    </table>
</div>
 {{ $lists->links('vendor.pagination.bootstrap-4') }}
 

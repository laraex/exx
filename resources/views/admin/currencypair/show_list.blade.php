 <div class="mt-20 mb-20" style="overflow-x:scroll;">
    <table class="table table-bordered table-striped dataTable"  id="currencypair">
        <thead>
            <tr>                
                <th>{{ trans('admin_currencypair.from_currency') }}</th>
                <th>{{ trans('admin_currencypair.to_currency') }}</th>
                <th>{{ trans('admin_currencypair.status') }}</th>               
                <th>{{ trans('admin_currencypair.min_amt') }}</th>               
                <th>{{ trans('admin_currencypair.max_amt') }}</th>  
               <!--  <th>{{ trans('admin_currencypair.variant') }}</th>   -->             
                <th>{{ trans('admin_currencypair.buy_fee') }}</th>               
                <th>{{ trans('admin_currencypair.buy_base_fee') }}</th> 
                 <th>{{ trans('admin_currencypair.sell_fee') }}</th>               
                <th>{{ trans('admin_currencypair.sell_base_fee') }}</th> 
                <th>{{ trans('admin_currencypair.action') }}</th> 
            </tr>
        </thead>
        
        <tbody>
            @foreach($list as $pairlist)
                <tr>                     
                    <td>{{ $pairlist->fromcurrency->token }}</td>
                    <td>{{ $pairlist->tocurrency->token }}</td>
                    <td>{{ ucfirst($pairlist->status) }}</td>  
                    <td>{{ $pairlist->min_value }}</td>  
                    <td>{{ $pairlist->max_value }}</td>
                   <!--  <td>{{ $pairlist->exchange_rate_variant }}</td>   -->
                    <td>{{ $pairlist->buy_fee }}</td>  
                    <td>{{ $pairlist->buy_base_fee }}</td> 
                    <td>{{ $pairlist->sell_fee }}</td>  
                    <td>{{ $pairlist->sell_base_fee }}</td> 

                    <td>
                        <div class="form-group">
                            <div class="flex-button-group">
                                <div>
                                    <a  href="{{ url('/admin/currencypair/edit/'.$pairlist->id) }}" class="btn btn-success btn-sm flex-button">{{ trans('admin_currencypair.edit') }}</a>  
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@push('scripts')
<script>
            $(document).ready(function(){
                $('#currencypair').DataTable();
            });
        </script>
@endpush
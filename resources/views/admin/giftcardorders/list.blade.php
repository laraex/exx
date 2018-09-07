<div class="mt-20 mb-20">
    <table class="table table-bordered table-striped dataTable"  id="giftcardorderdatatable">
        <thead>
            <tr>        
                <th>{{ trans('giftcard.username') }}</th>
                <th>{{ trans('giftcard.amt') }}</th>    
                <th>{{ trans('giftcard.gift_name') }}</th>       
                <th>{{ trans('giftcard.img') }}</th>
                <th>{{ trans('giftcard.comments') }}</th>
                <th>{{ trans('giftcard.action') }}</th>
            </tr>
        </thead>
        @foreach($giftcardOrders as $data)
        <tbody>
            
                <td>{{ $data->user->name }} </td>
                <td>{{ $data->amount }} {{ USER_BUY_GIFTCARD_CURRENCY }}</td>
                <td>{{ $data->giftcard->name }}</td>
                <td>
                    @if ($data->giftcard->image != '')
                        <img id="myImg{{ $data->giftcard->id }}" class="Image" src="{{ url($data->giftcard->image) }}"  width="50" height="50" rel="{{ $data->giftcard->id }}">  
                    @else
                        -
                    @endif
                </td>
                
                @if($data['status']=='complete')
                    <td>{{ $data->comments }}</td>
                @else
                    <td> - </td>
                @endif

                @if($data['status']=='approve')
                <td>
                    <div class="form-group">
                        <div class="flex-button-group">
                            <div>
                                <a id="complete" href="{{ url('/admin/giftcardorders/complete/'.$data['id'].'') }}" class="btn btn-info btn-sm flex-button">{{ trans('giftcard.complete') }}</a>                        
                            </div>
                            <div>
                                <a id="addtowallet" href="{{ url('/admin/giftcardorders/addtowallet/'.$data['id'].'') }}" class="btn btn-success btn-sm flex-button">{{ trans('giftcard.add_wallet') }}</a>  
                            </div>
                        </div>
                    </div>
                </td>
                @else
                <td> - </td>
                @endif
            
        </tbody>
        @endforeach
    </table>
</div>

@include('admin.datatable')

@push('scripts')
<script>
    $(document).ready(function(){
        $('#giftcardorderdatatable').DataTable();
        $("#addtowallet").on("click", function()
        {
            return confirm(" {{ trans('giftcard.add_deposit') }}");
        });
    });   
</script>
@endpush
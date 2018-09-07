<table class="table table-bordered table-striped dataTable"  id="kycdatatable">
<thead>
     <tr>
        <th>{{ trans('admin_kyc.username') }}</th>
        <th>{{ trans('admin_kyc.kyc_doc') }}</th>
      
    
    </tr>
</thead>
<tbody>
 @foreach($lists as $list)
    <tr>
        <td>
            <a href="{{ url('admin/users/'.$list->user->id) }}">{{ $list->user->name }}</a>
        </td>
        <td>

            @if (($list->passport_verified != '1')&&(!is_null($list->passport_attachment)))
              Passport <br>
            @endif
            
            @if (($list->id_card_verified != '1')&&(!is_null($list->id_card_attachment)))
              Id Card <br>
            @endif
            @if (($list->driving_license_verified != '1')&&(!is_null($list->driving_license_attachment)))
              Driving License <br>
            @endif
            @if (($list->photo_id_verified != '1')&&(!is_null($list->photo_id_attachment)))
              Photo Id Card <br>
            @endif
            @if (($list->bank_verified != '1')&&(!is_null($list->bank_attachment)))
              Bank
            @endif
            
           

        </td>
        
    </tr>
  
    
    @endforeach
</tbody>
</table>
{{$lists->links()}}

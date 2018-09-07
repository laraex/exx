<div class="widget draggable ui-widget-content" id="4">
  <div class="widget-header">
    <h2 class="widget-heading"><i class="fa fa-address-card" aria-hidden="true"></i>{{ trans('admin_dashboard.kyc_approve') }} <span class="pull-right"><i class="fa fa-arrows widget-move" aria-hidden="true"></i></span></h2>
  </div>
  <div class="widget-body">
  <p></p>
    @foreach($pendingkyclists as $list)
    <div class="widget-data">
        
        <div class="flex-left">
        <div class="widget-data-item widget-data-user"> 

        <a href="{{ url('admin/users/'.$list->user->id) }}">{{ $list->user->name }}</a></div>
        </div>
      <div class="flex-center">
            <div class="widget-data-item">
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
               </div>
        </div>
        
  </div>
@endforeach
 </div>
 @if($pending_kyc_count>5)
  <div class="widget-footer text-muted">
    <a href="{{ url('admin/kyc/') }}" class="btn btn-primary">{{ trans("admin_dashboard.view_all") }}</a>   
  </div>
  @endif
</div>


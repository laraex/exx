<div class="widget draggable ui-widget-content" id="4">
  <div class="widget-header">
    <h2 class="widget-heading"><i class="fa fa-address-card" aria-hidden="true"></i> KYC Waiting for Approval <span class="pull-right"><i class="fa fa-arrows widget-move" aria-hidden="true"></i></span></h2>
  </div>
  <div class="widget-body">
  <p></p>
    @foreach($pendingkyclists as $data)
    <div class="widget-data">
        @php 
          $request = json_decode($data['request'], true); 
        @endphp
        <div class="flex-left">
    		<div class="widget-data-item widget-data-user">From: <a href="{{ url('admin/users/'.$data->user->id) }}">
              {{ $data->user->name }}
                </a></div>
        </div>
     	<div class="flex-center">
            <div class="widget-data-item">Document:<!--  <a href="{{ url('admin/users/verifykyc/'.$data->id.'') }}"> -->
              {{ $data->kyc_doc }}
               <!--  </a> --></div>
        </div>
        <div class="flex-right">
           <!--  <div class="widget-data-item"> <a href="{{ url('admin/users/verifykyc/'.$data->id.'') }}" class="btn btn-success btn-xs flex-button" onclick="return (confirm('Do you want to approve this kyc?'))">CONFIRM</a>   </div> -->
           <form method="post" class="approvekyc" action="{{ url('admin/users/verifykyc/'.$data->id.'') }}">
                {{ csrf_field() }} 
                {!! Form::submit("Verify KYC", ['class' => 'btn btn-success btn-sm flex-button']) !!}
            </form>
            <div class="widget-data-item"><small>{{ $data->created_at->diffForHumans() }}</small></div>
        </div>
  </div>
@endforeach
 </div>
  <div class="widget-footer text-muted">
    <a href="{{ url('admin/action/kyc/') }}" class="btn btn-primary">View All</a>   
  </div>
</div>

@push('scripts')
<script>
  $(document).ready(function(){
      $(".approvekyc").on("submit", function(){
        return confirm("Do you want to approve the kyc document?");
      });  
  });
</script>
@endpush
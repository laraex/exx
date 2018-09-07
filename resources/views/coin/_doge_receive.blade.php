@extends('layouts.app')

@section('content')

<div class="flex container mt-40 mb-40">
          
        <div class="col col-md-9">
            <h1 class="page-title">DOGE Receive</h1>
                        <div class="panel-body">                  

                            <div class="row">
                               <div class="col-md-12">
                            <div style="background-color: #fff; padding: 20px; width: 250px">
                                     <div id="qrcode_doge" class="mb-20"></div>
                                     </div>
                                  <p class="doge-receive big-text"><b>{{ $doge_address }}</b></p>
                                  <input type="button" id="copy" value="Copy" class="btn btn-primary" onclick="copyToClipboard('.doge-receive')">
                            </div>    
                            </div>             
                 
                         </div>
       </div>
</div>
@endsection



@push('bottomscripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
<script type="text/javascript">

$(function() {

    $('#qrcode_doge').qrcode({ 
    
        text: "{{ $doge_address }}",
        ecLevel: 'L',
        width: 200,
        height: 200,
        

    });

});


function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
  $('#copy').val("Copied");
  $('#copy').addClass("copytext");
}

</script>
@endpush   
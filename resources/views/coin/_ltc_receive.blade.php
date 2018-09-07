@extends('layouts.app')

@section('content')

<div class="flex container mt-40 mb-40">
          
        <div class="col col-md-9">
            <h1 class="page-title">LTC Receive</h1>
                        <div class="panel-body">                  

                            <div class="row">
                               <div class="col-md-12">
                            <div style="background-color: #fff; padding: 20px; width: 250px">
                                     <div id="qrcode_ltc" class="mb-20"></div>
                                     </div>
                                  <p class="ltc-receive big-text"><b>{{ $ltc_address }}</b></p>
                                  <input type="button" id="copy" value="Copy" class="btn btn-primary" onclick="copyToClipboard('.ltc-receive')">
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

    $('#qrcode_ltc').qrcode({ 
    
        text: "{{ $ltc_address }}",
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
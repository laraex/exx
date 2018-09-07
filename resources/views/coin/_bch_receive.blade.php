@extends('layouts.myaccount')
@section('content')
<div class="flex flex-c mt-40 mb-40">
    <h1 class="page-title">{{ trans('myaccount.bch_receive') }}</h1>
    <div class="bcx-container">
        <div style="background-color: #fff; padding: 20px; width: 250px">
            <div id="qrcode_bch" class="mb-20"></div>
        </div>
        <p class="bch-receive big-text mb-20 mt-20"><b>{{ $bch_address }}</b></p>
        <p>{{ trans('myaccount.note') }}</p>
        <input type="button" id="copy" value="Copy" class="btn btn-theme" onclick="copyToClipboard('.bch-receive')">
    </div>
</div>
@endsection

@push('bottomscripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
<script type="text/javascript">
$(function() {

    $('#qrcode_bch').qrcode({

        text: "{{ $bch_address }}",
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
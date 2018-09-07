<div class="row">
    <div class="col-md-12">
        @if (session('successmessage'))
        <div class="alert alert-success">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('successmessage') }}
            {{ session()->forget('successmessage') }}
        </div>
        @endif
         @if (session('failmessage'))
        <div class="alert alert-danger">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('failmessage') }}
            {{ session()->forget('failmessage') }}
        </div>
        @endif
    </div> 
</div>    
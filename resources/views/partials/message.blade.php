           @if (session('successmessage'))

    <div class="flex flex-c p-20">
        <div id="success-alert" class="alert alert-success">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('successmessage') }}
            {{ session()->forget('successmessage') }}
        </div>
        </div>
        @endif
         @if (session('failmessage'))
         <div class="flex flex-c p-20">
        <div class="alert alert-danger">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('failmessage') }}
            {{ session()->forget('failmessage') }}
        </div>
         </div>
        @endif
   

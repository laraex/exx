<table class="table table-bordered table-striped dataTable"  id="kycdatatable">
<thead>
     <tr>
        <th>{{ trans('admin_action.username') }}</th>
        <th>{{ trans('admin_action.kyc_doc') }}</th>
        <th>{{ trans('admin_action.created_on') }}</th>
        <th>{{ trans('admin_action.action') }}</th>
    </tr>
</thead>
<tbody>
 @foreach($userlists as $userlist)
    <tr>
        <td>
            <a href="{{ url('admin/users/'.$userlist->user->id) }}">{{ $userlist->user->name }}</a>
        </td>
        <td>
            @if ($userlist->kyc_doc != '')
               <!--  <form method="post" action="{{ url('admin/users/attachdocdownload/'.$userlist->id.'') }}">
                    {{ csrf_field()}}
                <div class="form-group">
                          <button type="submit" class="btn btn-default btn-xs">{{ $userlist->kyc_doc }}</button>
                  </div>
                </form> -->

                 <img id="myImg{{ $userlist->id }}" class="Image" src="{{ url('uploads/'.$userlist->kyc_doc) }}"  width="50" height="50" rel="{{ $userlist->id }}">
                
            @else
                -
            @endif

            
           

        </td>
        <td>{{ $userlist->created_at }}</td>
        <td>
            @if ($userlist->kyc_doc != '')
            <div class="form-group">
                <div class="flex-button-group">                 
                    <div>
                        <form method="post" class="approvekyc" action="{{ url('admin/users/verifykyc/'.$userlist->id.'') }}">
                            {{ csrf_field() }} 
                            {!! Form::submit(trans('forms.verifykyc'), ['class' => 'btn btn-success btn-sm flex-button']) !!}
                        </form>
                    </div>
                    <div>
                         <form method="post" class="rejectkyc" action="{{ url('admin/users/rejectkyc/'.$userlist->id.'') }}">
                            {{ csrf_field() }} 
                            {!! Form::submit(trans('forms.rejectkyc'), ['class' => 'btn btn-danger btn-sm flex-button']) !!}
                        </form>

                </div>
            @else
                {{ trans('admin_action.not_upload') }}
            @endif
        </td>
    </tr>
        <!-- The Modal -->
    <div id="myModal{{ $userlist->id }}" class="modal" style="top: 124px;">
      <span class="close" id="closeid{{ $userlist->id }}">&times;</span>
      <img class="modal-content" id="img{{ $userlist->id }}">
    </div>
    
    @endforeach
</tbody>
</table>

@include('admin.datatable')

@push('styles')

<style>
#myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: -10px; /* Location of the box */
    left: 0;
    top: 200;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
    margin: auto;
    display: block;
    width: 200px;
    /*max-width: 700px;*/
}


@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function(){
        $('#kycdatatable').DataTable();    

});

$(".approvekyc").on("submit", function(){
        return confirm('{{ trans("admin_action.approve_kyc")}}');
    });

     $(".rejectkyc").on("submit", function(){
        return confirm('{{ trans("admin_action.reject_kyc")}}');
    });

    
$(".Image").click(function(){

var userid = $(this).attr('rel');

// Get the modal
var modal = document.getElementById('myModal'+userid);

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById('myImg'+userid);

var modalImg = document.getElementById("img"+userid);
img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
}

// Get the <span> element that closes the modal
var span = document.getElementById('closeid'+userid);

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
    modal.style.display = "none";
}

});
</script>
@endpush
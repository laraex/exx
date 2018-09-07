<div class="tab-container">
	<div class="row">
	<div class="col-md-12">
		<h4>{{ trans('admin_user.kyc_detail') }}</h4>

            @php
             $bank_data= json_decode($user->userprofile->bank_data);
             $flag=0;
            @endphp

    

     @if($approveflag==1)
	    <a href="{{ url('admin/kyc/approved/'.$user->userprofile->id) }}" class="btn btn-success">{{ trans('admin_user.kyc_approve') }}</a>
      @php 
       $flag=1;

       @endphp
     @endif

     @if($user->userprofile->kyc_approved==1)
      {{ trans('admin_user.kyc_approved') }}
      @php 
       $flag=1;

       @endphp

     @endif
    
		</div>
		
		@include('partials.message')
	</div>
  @if($flag==0)
	<div class="row">
		<div class="col-md-12 p-20">
			<table class="table">
			
				<tr>
                    <td>{{ trans('admin_user.passport') }} </td>
                    <td>
					<div class="form-group">
                      
                  
                    <form method="post" action="{{ url('admin/users/proofdownload/kyc/passport/'.$user->userprofile->id.'') }}">
                    {{ csrf_field()}}
                    <div class="form-group">
                    <button type="submit" class="btn btn-default btn-xs">{{ $user->userprofile->passport_attachment }}</button>
                      </div>
                    </form>
                    </div>
                    </td>
                       <td>
                    @if ($user->userprofile->passport_attachment != '') 
                             @if ( $user->userprofile->passport_verified== 0)            
                                    <div>
                                        <a href="#" rel="{{ url('admin/users/verify/kyc/passport/'.$user->userprofile->id.'') }}" class="btn btn-success btn-sm flex-button verifykyc">{{ trans('admin.verifykyc') }}</a>
                                     </div>
                                    <div>
                                        <a href="#" rel="{{ url('admin/users/reject/kyc/passport/'.$user->userprofile->id.'') }}" class="btn btn-danger btn-sm flex-button rejectkyc">{{ trans('admin.rejectkyc') }}</a>
                                       
                                    </div>
                    @elseif( $user->userprofile->passport_verified == 2)
                        <span class="label label-danger">{{ trans('admin.rejected') }}</span>
                    @else
                        <span class="label label-success">{{ trans('admin.verified') }}</span>
                             @endif
                    @endif


                    </td>
				</tr>
                    <tr>
                    <td>{{ trans('admin_user.id') }} </td>
                    <td>
                    <div class="form-group">
                      
                  
                    <form method="post" action="{{ url('admin/users/proofdownload/kyc/idcard/'.$user->userprofile->id.'') }}">
                    {{ csrf_field()}}
                    <div class="form-group">
                    <button type="submit" class="btn btn-default btn-xs">{{ $user->userprofile->id_card_attachment }}</button>
                      </div>
                    </form>
                    </div>
                    </td>
                    <td>
                    @if ($user->userprofile->id_card_attachment != '') 
                             @if ( $user->userprofile->id_card_verified== 0)            
                                    <div>
                                        <a href="#" rel="{{ url('admin/users/verify/kyc/idcard/'.$user->userprofile->id.'') }}" class="btn btn-success btn-sm flex-button verifykyc">{{ trans('admin.verifykyc') }}</a>
                                     </div>
                                    <div>
                                        <a href="#" rel="{{ url('admin/users/reject/kyc/idcard/'.$user->userprofile->id.'') }}" class="btn btn-danger btn-sm flex-button rejectkyc">{{ trans('admin.rejectkyc') }}</a>
                                       
                                    </div>
                    @elseif( $user->userprofile->id_card_verified == 2)
                        <span class="label label-danger">{{ trans('admin.rejected') }}</span>
                    @else
                        <span class="label label-success">{{ trans('admin.verified') }}</span>
                             @endif
                    @endif

                </td>
                </tr>
				    <tr>
                    <td>{{ trans('admin_user.driving_license') }}</td>
                    <td>
                    <div class="form-group">
                      
                  
                    <form method="post" action="{{ url('admin/users/proofdownload/kyc/drivinglicense/'.$user->userprofile->id.'') }}">
                    {{ csrf_field()}}
                    <div class="form-group">
                    <button type="submit" class="btn btn-default btn-xs">{{ $user->userprofile->driving_license_attachment }}</button>
                      </div>
                    </form>
                    </div>
                    </td>
                    <td>
                    @if ($user->userprofile->driving_license_attachment != '') 
                             @if ( $user->userprofile->driving_license_verified== 0)            
                                    <div>
                                        <a href="#" rel="{{ url('admin/users/verify/kyc/drivinglicense/'.$user->userprofile->id.'') }}" class="btn btn-success btn-sm flex-button verifykyc">{{ trans('admin.verifykyc') }}</a>
                                     </div>
                                    <div>
                                        <a href="#" rel="{{ url('admin/users/reject/kyc/drivinglicense/'.$user->userprofile->id.'') }}" class="btn btn-danger btn-sm flex-button rejectkyc">{{ trans('admin.rejectkyc') }}</a>
                                       
                                    </div>
                    @elseif( $user->userprofile->driving_license_verified == 2)
                        <span class="label label-danger">{{ trans('admin.rejected') }}</span>
                    @else
                        <span class="label label-success">{{ trans('admin.verified') }}</span>
                             @endif
                    @endif

                </td>
                </tr>
                    <tr>
                    <td>{{ trans('admin_user.photo_id') }}</td>
                    <td>
                    <div class="form-group">
                      
                  
                    <form method="post" action="{{ url('admin/users/proofdownload/kyc/photoid/'.$user->userprofile->id.'') }}">
                    {{ csrf_field()}}
                    <div class="form-group">
                    <button type="submit" class="btn btn-default btn-xs">{{ $user->userprofile->photo_id_attachment }}</button>
                      </div>
                    </form>
                    </div>
                    </td>
                    <td>
                    @if ($user->userprofile->photo_id_attachment != '') 
                             @if ( $user->userprofile->photo_id_verified== 0)            
                                    <div>
                                        <a href="#" rel="{{ url('admin/users/verify/kyc/photoid/'.$user->userprofile->id.'') }}" class="btn btn-success btn-sm flex-button verifykyc">{{ trans('admin.verifykyc') }}</a>
                                     </div>
                                    <div>
                                        <a href="#" rel="{{ url('admin/users/reject/kyc/photoid/'.$user->userprofile->id.'') }}" class="btn btn-danger btn-sm flex-button rejectkyc">{{ trans('admin.rejectkyc') }}</a>
                                       
                                    </div>
                    @elseif( $user->userprofile->photo_id_verified == 2)
                        <span class="label label-danger">{{ trans('admin.rejected') }}</span>
                    @else
                        <span class="label label-success">{{ trans('admin.verified') }}</span>
                             @endif
                    @endif

                </td>
                </tr>

		       	
				    <tr >
                    <td>{{ trans('admin_user.bank') }} </td>
                    <td>
                    <div class="form-group">
                      
                  
                    <form method="post" action="{{ url('admin/users/proofdownload/kyc/bank/'.$user->userprofile->id.'') }}">
                    {{ csrf_field()}}
                    <div class="form-group">
                    <button type="submit" class="btn btn-default btn-xs">{{ $user->userprofile->bank_attachment }}</button>
                      </div>
                    </form>
                    </div>
                    </td>
                    @if(count($bank_data)>0)
                  
                    <td><p>Bank Name:{{$bank_data->bank_name}}</p>
                    <p>Bank Country:{{$bank_data->country}} </p>
                   <p> Date:{{$bank_data->statement}}</p></td>  

                    @endunless  
                    <td>
                    @if ($user->userprofile->bank_attachment!= '') 
                             @if ( $user->userprofile->bank_verified== 0)            
                                    <div>
                                        <a href="#" rel="{{ url('admin/users/verify/kyc/bank/'.$user->userprofile->id.'') }}" class="btn btn-success btn-sm flex-button verifykyc">{{ trans('admin.verifykyc') }}</a>
                                     </div>
                                    <div>
                                        <a href="#" rel="{{ url('admin/users/reject/kyc/bank/'.$user->userprofile->id.'') }}" class="btn btn-danger btn-sm flex-button rejectkyc">{{ trans('admin.rejectkyc') }}</a>
                                       
                                    </div>
                    @elseif( $user->userprofile->bank_verified == 2)
                        <span class="label label-danger">{{ trans('admin.rejected') }}</span>
                    @else
                        <span class="label label-success">{{ trans('admin.verified') }}</span>
                             @endif
                    @endif

                </td>              
                    
                </tr>
			
				

			</table>
		</div>




        
	</div>
  @endif
	</div>

@push('scripts')

<link rel="stylesheet" href="/css/sweetalert2.min.css">
<script src="/js/sweetalert2.min.js"></script>  
<script>
$(document).ready(function(){

    $('.verifykyc').on('click', function(){
                  var link = $(this).attr('rel');
          swal({
          text: " {{ trans('admin_user.approve_kyc') }}",
          showCancelButton: true,
          showConfirmButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          allowOutsideClick: true,
        }).then(function(){
            window.location.href = link;
        });
    });     

    $('.rejectkyc').on('click', function(){
        var link = $(this).attr('rel');
          swal({
          text: "{{ trans('admin_user.reject_kyc') }}",
          showCancelButton: true,
          showConfirmButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          allowOutsideClick: true,
        }).then(function(){
            window.location.href = link;
        });
    });  
 
});
</script>
@endpush


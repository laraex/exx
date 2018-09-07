<form method="POST">
 {{ csrf_field() }}
    {{ trans('admin_user.email_verify') }} <input type="checkbox" name="emailquery" value="1"><br>
    
    <input type="Submit" class="btn btn-default" name="verifiedbutton">
</form> 

<div class="mt-20 mb-20">
    <table class="table table-bordered table-striped dataTable"  id="">
        <thead>
            <tr>                
                <th>{{ trans('admin_user.name') }}</th>
                <th>{{ trans('admin_user.security') }}</th>
                <th>{{ trans('admin_user.doj') }}</th>
                <th>{{ trans('admin_user.sponsor') }}</th>
                <th>{{ trans('admin_user.status') }}</th>
                <th>{{ trans('admin_user.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td width="220px">
                        <p class="trim">
                            <a href="{{ url('admin/users') }}/{{ $user->id }} ">
                                <strong>{{ $user->name }}</strong>
                            </a>
                        </p>

                        <p class="trim">
                         {{--@if($user->userprofile->email_verified == 0)
                                    <span class="label label-danger">{{ trans('admin_user.unverified') }}</span>
                                        <a id="resend" href="{{ url('/admin/users/resend/'.$user->id) }}" class="btn btn-xs btn-primary">{{ trans('admin_user.resend_mail') }}</a>
                                @else
                                    <span class="label label-success">{{ trans('admin_user.verified') }}</span>
                                @endif

                            @if( $user->emailVerified )--}}

                            @if(optional($user->userprofile)->email_verified == 1)
                                <a href="mailto:{{ $user->email }}" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-message" title="{{ $user->email }}"></span>{{ trans('admin_user.email') }}</a>
                            @else
                                <a href="mailto:{{ $user->email }}" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-message" title="{{ $user->email }}"></span>{{ trans('admin_user.email') }}</a>
                            @endif

                            @if( $user->active )
                                <span class="label label-success"><i class="glyphicon glyphicon-lock" title="verified"></i></span>
                            @else
                                 <span class="label label-danger"><i class="glyphicon glyphicon-lock" title="verified"></i></span>
                            @endif

                            @if( $user->isUserProfileCompleted )
                                <span class="label label-success">{{ trans('admin_user.profile') }}</span>
                            @else
                                <span class="label label-danger">{{ trans('admin_user.profile') }}</span>
                            @endif
                        </p>
                    </td>

                    <td>  
                        @if(($user->isKycApproved == 1)||(optional($user->userprofile)->kyc_approved==1))
                            <span class="label label-success">{{ trans('admin_user.kyc') }}</span>
                        @elseif($user->isKycApproved == 0 || $user->isKycApproved == 2)
                             <span class="label label-danger">{{ trans('admin_user.kyc') }}</span>
                        @endif

                        @if ((optional($user->userprofile)->bank_verified == '1')||(optional($user->userprofile)->kyc_approved==1))
                            <span class="label label-success">{{ trans('admin_user.kyc_bank') }}</span>
                        @elseif((optional($user->userprofile)->bank_verified != '1')||(!is_null(optional($user->userprofile)->bank_attachment)))
                             <span class="label label-danger">{{ trans('admin_user.kyc_bank') }}</span>
                        @endif
                    </td>

                    <td>
                        <span title="{{ $user->created_at }}">{{ $user->created_at->format('d-m-Y H:i:s') }}</span>
                    </td> 

                    <td> 
                        @unless(is_null($user->sponsor))
                            {{$user->sponsor->name}}
                        @endunless
                    </td>

                    <td>
                        @if($user->isOnline())
                            <span class="label label-success">{{ trans('admin_user.online') }}</span>
                        @else
                            <span class="label label-danger">{{ trans('admin_user.offline') }}</span>
                          
                        @endif
                    </td>
                    
                    <td>
                        <form method="post" class="deleteuser" action="{{ url('admin/users/destroy/'.$user->id.'') }}">
                            {{ csrf_field()}}  
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-trash" title="Delete"></i>
                            </button>
                        </form>
                        {{--<a class="btn btn-default sendmail" href="#" data-toggle='modal' data-target2='{{ $user->id }}'><i class="fa fa-envelope" title="Send Mail"></i></a>--}}

                        <a href="{{ url('/admin/users/sendmail/'.$user->id) }}" class="btn btn-default" ><i class="fa fa-envelope" title="Send Mail"></i></a>

                        <a href="{{ url('/admin/users/sendmsg/'.$user->id) }}" class="btn btn-default"><i class="fa fa-comment" title="Send Message"></i></a>

                        <a class='btn btn-default viewmessage' href="#" data-toggle='modal' data-target1='{{ $user->id }}'><i class="fa fa-eye" title="View Balance"></i></a>
    {{--<send-mail></send-mail>--}}

    
               
                    </td>              
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $users->links() }}

<div class="modal fade" id="message-modals" role="dialog"></div>
<div class="modal fade" id="mail-modals" role="dialog"></div>

@push('scripts')
    <script>
        $('.viewmessage').on('click', function () 
        {
            var $this = $(this).data('target1');
            $('#message-modals').load("{{url('admin/users/balance')}}/" + $this, function (response, status, xhr) 
            {
                if (status == "success") 
                {
                    $(response).modal('show');
                }
            });
        });
    </script>

     {{--<script>
        $('.sendmail').on('click', function () 
        {
            //alert('fk');
            var $this = $(this).data('target2');
            $('#mail-modals').load("{{url('admin/users/sendmail/')}}/" + $this, function (response, status, xhr) 
            {
                if (status == "success") 
                {
                    $(response).modal('show');
                }
            });
        });
    </script>--}}

    <script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
        <script>
            $(document).ready(function() 
            {
            CKEDITOR.replace('message');
            });
    </script>

    <script>
        $(".deleteuser").on("submit", function()
        {
            return confirm(" {{ trans('admin_user.delete_user') }}");
        });
    </script>
@endpush
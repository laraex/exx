@extends('backpack::layout') 
@section('header')
    <section class="content-header">
      <h1>
        {{ trans('admin_msg.msg_details') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('admin_msg.msg_details') }}</li>
      </ol>
    </section>
@endsection

@section('content')
<section class="section">
<div class="panel panel-default">
    <div class="panel-body">
          <div class="conversation-detail-box">
          <div class="conversation-box">
            @include('admin.message.details') 
          </div>
          <div class="participant-box">
                    @foreach ($participantDetails as  $data)
                    <div class="flex profile-section">
                     <div class="profile-image-section"> 
                      @if($data->profile_avatar === null)
                        <img src="http://placehold.it/60/60/?text=No+Image">
                      @else 
                        <img src="{{ url($data->profile_avatar) }}" width="60px" height="60px">
                      @endif
                      </div>
                      <div class="profile-data-section">
                        <h3 class="profile-full-name">
                          @if(!empty($data->firstname) && !empty($data->lastname))
                          {{ $data->firstname }} {{ $data->lastname }}
                          @else
                          <span style="color:#999">{{ trans('admin_msg.name') }}</span>
                          @endif
                        </h3>
                        <p>{{ $data->country_id }}</p>
                          <p> 
                          <div class="badge-group">
                            <div class="email-badge"> 
                              @if($data->email_verified) 
                              <span class="label label-success">{{ trans('admin_msg.email') }}</span> 
                              @else 
                              <span class="label label-default">{{ trans('admin_msg.email') }}</span> 
                              @endif
                            </div>
                             <div class="mobile-badge"> 
                                @if($data->mobile_verified) 
                                <span class="label label-success">{{ trans('admin_msg.mobile') }}</span> 
                                @else 
                                <span class="label label-default">{{ trans('admin_msg.mobile') }}</span> 
                                @endif
                            </div>
                            <div class="kyc-badge"> 
                                @if($data->mobile_verified) 
                                <span class="label label-success">{{ trans('admin_msg.kyc') }}</span> 
                                @else 
                                <span class="label label-default">{{ trans('admin_msg.kyc') }}</span> 
                                @endif
                            </div>
                          </div>
                        </p>
                      </div>
                    </div>
                    <hr>
                    @endforeach
            </div>
        </div>
    </div>
 </div>
</section>
@endsection



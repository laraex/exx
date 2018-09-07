@extends('layouts.app')
@section('content')
<div class="flex container mt-40 mb-40">
          <div class="col col-md-3">
                  @include('home.partials.settingsmenu')
          </div>
        <div class="col col-md-9">
            <h1 class="page-title">{{ trans('myaccount.viewprofile') }}</h1>
                        <div class="panel-body">
                            <table class="table table-striped"> 
                        <tr>
                            <td>{{ trans('myprofile.username') }} </td>
                            <td> <strong>{{ $myprofile->user->name }}</strong></td>
                        </tr>
                        <tr>
                            <td> {{ trans('myprofile.email') }} </td>
                            <td> <em>{{ $myprofile->user->email }}</em>
                                @if( $myprofile->email_verified )
                                    <span class="label label-success">{{ trans('myprofile.verified') }}</span>
                                @else
                                    <span class="label label-danger">{{ trans('myprofile.unverified') }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td> {{ trans('myprofile.firstname') }} </td>
                            <td> {{ $myprofile->firstname }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('myprofile.lastname') }}</td>
                            <td> {{ $myprofile->lastname }}</td>
                        </tr>
                        @if(Config::get('settings.address1'))
                        <tr>
                            <td>{{ trans('forms.address1_lbl') }} </td>
                            <td>{{ $myprofile->address1}} </td>
                        </tr>
                        @endif
                        @if(Config::get('settings.address2'))
                        <tr>
                            <td>{{ trans('forms.address2_lbl') }}</td>
                            <td>{{ $myprofile->address2}} </td>
                        </tr>
                        @endif
                        @if(Config::get('settings.city'))
                        <tr>
                            <td>{{ trans('forms.city_lbl') }} </td>
                            <td>{{ $myprofile->city}} </td>
                        </tr>
                        @endif
                        @if(Config::get('settings.state'))
                        <tr>
                            <td>{{ trans('forms.state_lbl') }} </td>
                            <td>{{ $myprofile->state}} </td>
                        </tr>
                        @endif
                        <tr>
                            <td>{{ trans('myprofile.country') }}</td>
                            <td>
                            @if ($myprofile->usercountry) 
                            {{ $myprofile->usercountry->name }}
                            @endif
                            </td>
                        </tr>
                      {{-- <tr>
                            <td>{{ trans('myprofile.mobile') }}</td>
                            <td> {{ $myprofile->mobile }}
                                @if( $myprofile->mobile_verified )
                                    <span class="label label-success">{{ trans('myprofile.verified') }}</span>
                                @else
                                    <span class="label label-danger">{{ trans('myprofile.unverified') }}</span>
                                @endif
                            </td>
                        </tr>--}}
                       {{--    <tr>
                            <td>{{ trans('myprofile.ssn') }}</td>
                            <td> {{ $myprofile->ssn }}</td>
                        </tr>

                     <tr>
                            <td>{{ trans('myprofile.kyc') }}</td>
                            <td> {{ $myprofile->kyc_doc }}
                                @if( $myprofile->kyc_verified == 1)
                                    <span class="label label-success">{{ trans('myprofile.verified') }}</span>
                                @elseif( $myprofile->kyc_verified == 0)
                                    <span class="label label-danger">{{ trans('myprofile.unverified') }}</span>
                                @elseif( $myprofile->kyc_verified == 2)
                                    <span class="label label-danger">{{ trans('myaccount.rejected') }}</span>
                                @endif
                            </td>
                        </tr>--}}
                        <tr>
                            <td>{{ trans('myprofile.mobile') }}</td>
                            <td>
                         
                            {{ $myprofile->mobile}}
                           
                            </td>
                        </tr>
                        <tr>
                            <td>{{ trans('myprofile.address1') }}</td>
                            <td>
                         
                            {{ $myprofile->address1}}
                           
                            </td>
                        </tr>
                         @if($myprofile->address2!='')
                        <tr>
                            <td></td>
                            <td>
                         
                            {{ $myprofile->address2}}
                           
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td>{{ trans('myprofile.city') }}</td>
                            <td>
                         
                            {{ $myprofile->city}}
                           
                            </td>
                        </tr>
                        <tr>
                            <td>{{ trans('myprofile.state') }}</td>
                            <td>
                         
                            {{ $myprofile->state}}
                           
                            </td>
                        </tr>
                        <tr>
                            <td>{{ trans('myprofile.zipcode') }}</td>
                            <td>
                         
                            {{ $myprofile->zipcode}}
                           
                            </td>
                        </tr>
                         <tr>

                            <td>{{ trans('myprofile.dateofbirth') }}</td>
                            <td>
                              @unless(is_null($myprofile->dateofbirth))
                                      {{ $myprofile->dateofbirth}}
                              @endunless
                          
                           
                        </td>
                        </tr>
                         <tr>
                            <td>{{ trans('myprofile.gender') }}</td>
                            <td>
                         
                            {{ ucfirst($myprofile->gender)  }}
                           
                            </td>
                        </tr>
                         <tr>
                            <td>{{ trans('myprofile.identity') }}</td>
                            <td>
                            @if($myprofile->passport_no!='')
                               {{ trans('myprofile.passport') }} : 
                               {{ $myprofile->passport_no}}
                            @endif
                            @if($myprofile->identity_no!='')
                               {{ trans('myprofile.idcard') }} : 
                               {{ $myprofile->identity_no}}
                            @endif
                             @if($myprofile->driving_license_no!='')
                               {{ trans('myprofile.driving_license_no') }} : 
                               {{ $myprofile->driving_license_no}}
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ trans('myprofile.occupation') }}</td>
                            <td>
                          
                            {{ $myprofile->occupation }}
                          
                            </td>
                        </tr>
                        <tr>
                            <td>{{ trans('myprofile.nationality') }}</td>
                            <td>
                            @if ($myprofile->nationality) 
                            {{ $myprofile->nationality->name }}
                            @endif
                            </td>
                        </tr>


                    </table>
                    <div>
                        <p class="bg-info p-20">{{ trans('myprofile.profile_note') }} </p>
                    </div>
        </div>
      </div>
</div>
@endsection
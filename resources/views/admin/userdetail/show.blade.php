@extends('backpack::layout')
@section('header')
    <section class="content-header">
      <h1>
        {{ trans('admin_user.user_detail') }} ( {{ $user->name }} )
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('admin_user.user_detail') }} </li>
      </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                {{-- <div class="box-header with-border">
                    <div class="box-title">Details about <small>( {{ $user->name }} )</div>
                </div> --}}
                <div class="row">
                    <div class="col-sm-12">
                      @include('adminpartials.userdetailsummary')
                      @include('adminpartials.userdetailtabs')
                      <!-- @include('admin.userdetail.show_form') -->
                     </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('#datatable').DataTable();
    });

      $('[data-toggle="popover"]').popover({
        placement : 'top',
        trigger : 'hover'
    });
</script>
@endpush

@section('after_scripts')

@endsection

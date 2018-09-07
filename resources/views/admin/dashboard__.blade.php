@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1> Dashboard </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">

                <div class="row">
                  <div class="col-sm-12">
                  @include('partials.message')
                  @include('admin.partials.stats_ebuck')

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget-groups">
                            @include('admin.partials.widget_pending_deposits')
                            @include('admin.partials.widget_pending_withdraws')
                            @include('admin.partials.widget_quick_message')
                            @include('admin.partials.widget_pending_kyc')
                            @include('admin.partials.widget_giftcard_orders')
                            @include('admin.partials.widget_support_tickets')
                            @include('admin.partials.widget_recent_ebuckbuys')
                            @include('admin.partials.widget_recent_ebucksales')
                            @include('admin.partials.widget_recent_fundtransfers')
                            @include('admin.partials.widget_recent_signups')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

        @include('admin.datatable')

        @push('scripts')
        <script>
            $(document).ready(function(){
                $('#userdatatable').DataTable();
            });
        </script>
    @endpush



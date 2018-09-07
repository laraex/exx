@extends('backpack::layout') 
@section('content')
    <section class="section">
        <div class="row">
            <div class="container">
            <h3>{{ trans('admin_msg.msg_from')}} </h3>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                @include('partials.message')
                                @include('admin.sendmsg.sendmsg_form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@extends('backpack::layout') 
@section('content')
    <section class="section">
        <div class="row">
            <div class="container">
                <div class="col-md-6 col-md-offset-3">
                    <h3>{{ trans('admin_usercreate.add_admin') }}</h3>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    @include('partials.message')
                                    @include('admin.main.create_form')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection













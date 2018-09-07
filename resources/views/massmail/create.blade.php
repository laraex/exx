@extends('backpack::layout')
@section('content')
<section class="section">
    <div class="row">
        <div class="container">
            <h3>{{ trans('mail.send_mail') }}</h3>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                @include('massmail.create_form')
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>
@endsection

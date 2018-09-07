@extends('backpack::layout')
@section('content')
    <section class="section">
        <div class="row">
            <div class="container">
            <h3>Approve</h3>
      
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                @include('admin.cryptowithdraw.approve_transfer_form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

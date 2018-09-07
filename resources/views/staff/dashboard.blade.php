@extends('backpack::layout')
@section('content')
<section class="section">
    <div class="container">
        <h3>Dashboard</h3>
    </div>
    <div class="row">
        <div class="container">
            <div class="col-md-3">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Tickets
                        </p>
                        <a class="card-header-icon">
                            <span class="icon">
                            <i class="fa fa-angle-down"></i>
                          </span>
                        </a>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <p>Total Tickets: <a href="{{ url('staff/ticket') }}">{{ $totaltickets }}</a></p>
                           
                        </div>
                    </div>
                   
                </div>
            </div>
            
            
            
        </div>
    </div>
    <hr>
   
</section>
@endsection

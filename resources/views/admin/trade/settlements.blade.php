@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
         Trade Settlements List
      </h1>
     
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title"> Trade Settlements List</div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                  @include('partials.message')
                  @include('admin.trade.settlements_list')
   
                </div>
            </div>
        </div>
    </div>
@endsection



        


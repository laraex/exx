@extends('layouts.app')

@section('content')
    <div class="member-content">
            <div class="inner-wrapper accounts mt-40 mb-40">
                    <div class="container">
                                <div class="flex flex-page-head">
                                    <div class="flex flex-page-left">
                                        <h1 class="page-title">{{ trans('myaccount.my_fund_list') }}</h1>
                                    </div>
                                   
                            
                            </div>
                            <hr>
                            <div  class="flex flex-page-content">
                                   @include('fund.partials._sidebar_fund')
                                    <div class="fund-info">
                                        @include('fund._myfund_table')
                                   </div>
                            </div>
                    </div>
            </div>
    </div>
@endsection
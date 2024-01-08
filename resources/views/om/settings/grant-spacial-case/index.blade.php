@extends('layouts.app')

@section('title', 'OMS0021')

@section('page-title')
    <h2>OMS0021: กำหนดสิทธิ์สั่งซื้อพิเศษ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.grant-spacial-case.index') }}">กำหนดสิทธิ์สั่งซื้อพิเศษ</a>
        </li>
    </ol>
@stop
@if (canEnter('/om/settings/grant-spacial-case'))
    @section('page-title-action')
        <a href="{{ route('om.settings.grant-spacial-case.create') }}" class="btn btn-success btn-xs">
            <i class="fa fa-plus"></i> สร้าง
        </a>
    @stop
@endif
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="text-center">
                <h1 class="tw-mt-0"></h1>
                <div class="ibox-content">
                   <form action="" method="GET" autocomplete="off">
                        <search-grant-spacial :customers="{{ json_encode($customers) }}"
                                :default-customer="{{ json_encode($defaultCustomer) }}"
                                :default-date="{{ json_encode($defaultDate) }}"
                                :action-url="{{ json_encode(route('om.settings.grant-spacial-case.index')) }}">
                        </search-grant-spacial>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>กำหนดสิทธิ์สั่งซื้อพิเศษ</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.grant-spacial-case._table')
                </div>
            </div>
        </div>
    </div>
@endsection

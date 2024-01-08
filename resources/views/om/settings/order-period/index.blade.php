@extends('layouts.app')

{{-- @section('title', 'OMS0002') --}}

@section('page-title')
    <h2>กำหนดงวดการสั่งซื้อ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.order-period.index') }}">กำหนดงวดการสั่งซื้อ</a>
        </li>
    </ol>
@stop
{{-- @if (canEnter('/om/settings/order-period')) --}}
    @section('page-title-action')
        <a href="{{ route('om.settings.order-period.create') }}" class="btn btn-success btn-xs">
            <i class="fa fa-plus"></i> สร้าง
        </a>
    @stop
{{-- @endif --}}
{{-- @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>กำหนดงวดการสั่งซื้อ</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.order-period._table')
                </div>
            </div>
        </div>
    </div>
@endsection --}}

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div>
                    <h1 class="tw-mt-0"></h1>
                    <div class="ibox-content">
                        <h4>กำหนดงวดการสั่งซื้อ</h4>
                       <form action="" method="GET" autocomplete="off">
                            {{-- <search-order-period
                                inline-template>
                                <div v-loading="loading">
                                    @include('om.settings.order-period._search', ['actionUrl' => route('om.settings.order-period.index')])
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-content">
                                            @include('om.settings.order-period._table')
                                        </div>
                                    </div>
                                </div>
                            </search-order-period> --}}

                            <search-order-period
                                :headers="{{json_encode($headers)}}"
                                inline-template>
                                <div v-loading="loading">
                                    @include('om.settings.order-period._search', ['actionUrl' => route('om.settings.order-period.index')])
                                    <div class="ibox float-e-margins" v-if="periodLists.length">
                                        <div class="mt-3">
                                            <h4>งวดการสั่งซื้อ</h4>
                                        </div>
                                        <div class="ibox-content">
                                            <div v-html="html"></div>
                                            {{-- @include('om.settings.order-period._table') --}}
                                        </div>
                                    </div>
                                </div>
                            </search-order-period>

                        </form>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

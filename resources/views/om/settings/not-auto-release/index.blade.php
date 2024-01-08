@extends('layouts.app')

@section('title', 'OMS0029')

@section('page-title')
    <h2>OMS0029: ร้านค้าที่ไม่ต้องการให้ปลดรายการพิมพ์ใบเสร็จรับเงินอัตโนมัติ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.not-auto-release.index') }}">ร้านค้าที่ไม่ต้องการให้ปลดรายการพิมพ์ใบเสร็จรับเงินอัตโนมัติ</a>
        </li>
    </ol>
@stop
@if (canEnter('/om/settings/not-auto-release'))
    @section('page-title-action')
        <a href="{{ route('om.settings.not-auto-release.create') }}" class="btn btn-success btn-xs">
            <i class="fa fa-plus"></i> สร้าง
        </a>
    @stop
@endif
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>ร้านค้าที่ไม่ต้องการให้ปลดรายการพิมพ์ใบเสร็จรับเงินอัตโนมัติ</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.not-auto-release._table')
                </div>
            </div>
        </div>
    </div>
@endsection

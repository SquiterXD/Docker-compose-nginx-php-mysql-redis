@extends('layouts.app')

@section('title', 'OMS0030')

@section('page-title')
    <h2>OMS0030: กำหนดผู้อนุมัติใบเตรียมการขาย / ใบสั่งซื้อ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.approver-order.index') }}">กำหนดผู้อนุมัติใบเตรียมการขาย / ใบสั่งซื้อ</a>
        </li>
    </ol>
@stop
@if (canEnter('/om/settings/approver-order'))
    @section('page-title-action')
        <a href="{{ route('om.settings.approver-order.create') }}" class="btn btn-success btn-xs">
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
                    <h5>กำหนดผู้อนุมัติใบเตรียมการขาย / ใบสั่งซื้อ</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.approver-order._table')
                </div>
            </div>
        </div>
    </div>
@endsection

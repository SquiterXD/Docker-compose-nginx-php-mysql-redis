@extends('layouts.app')

@section('title', 'OMS0023')

@section('page-title')
    <h2>OMS0023: กำหนดข้อมูลกลุ่มโควต้าและกลุ่มวงเงินเชื่อรายผลิตภัณฑ์</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.quota-credit-group.index') }}">กำหนดข้อมูลกลุ่มโควต้าและกลุ่มวงเงินเชื่อรายผลิตภัณฑ์</a>
        </li>
    </ol>
@stop
@if (canEnter('/om/settings/quota-credit-group'))
    @section('page-title-action')
        <a href="{{ route('om.settings.quota-credit-group.create') }}" class="btn btn-success btn-xs">
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
                    <h5>กำหนดข้อมูลกลุ่มโควต้าและกลุ่มวงเงินเชื่อรายผลิตภัณฑ์</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.quota-credit-group._table')
                </div>
            </div>
        </div>
    </div>
@endsection

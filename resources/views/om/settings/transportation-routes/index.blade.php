@extends('layouts.app')

@section('title', 'OMS0028')

@section('page-title')
    <h2>OMS0028: กำหนดช่วงเวลามาตรฐานการส่งมอบ (สำหรับขายในประเทศ)</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.transportation-route.index') }}">กำหนดช่วงเวลามาตรฐานการส่งมอบ (สำหรับขายในประเทศ)</a>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a href="{{ route('om.settings.transportation-route.create') }}" class="btn btn-success btn-xs">
        <i class="fa fa-plus"></i> สร้าง
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>กำหนดช่วงเวลามาตรฐานการส่งมอบ (สำหรับขายในประเทศ)</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.transportation-routes._table')
                </div>
            </div>
        </div>
    </div>
@endsection

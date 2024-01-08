@extends('layouts.app')

@section('title', 'OMS0025')

@section('page-title')
    <h2>OMS0025: กำหนดผู้อนุมัติใบคำร้องขอเพิ่มเพดานโควต้า</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">OM</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('om.settings.over-quota-approval.index') }}">กำหนดผู้อนุมัติใบคำร้องขอเพิ่มเพดานโควต้า</a>
        </li>
    </ol>
@stop
@if (canEnter('/om/settings/over-quota-approval'))
    @section('page-title-action')
        <a href="{{ route('om.settings.over-quota-approval.create') }}" class="btn btn-success btn-xs">
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
                    <h5>กำหนดผู้อนุมัติใบคำร้องขอเพิ่มเพดานโควต้า</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.over-quota-approval._table')
                </div>
            </div>
        </div>
    </div>
@endsection

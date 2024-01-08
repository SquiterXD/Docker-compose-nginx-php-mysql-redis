@extends('layouts.app')

@section('title', 'OMS0027')

@section('page-title')
    <h2>OMS0027: บันทึกข้อมูลเจ้าของรถขนส่ง</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <a>บันทึกข้อมูลเจ้าของรถขนส่ง</a>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a href="{{ route('om.settings.transport-owner.create') }}" class="btn btn-success btn-xs">
        <i class="fa fa-plus"></i> สร้าง
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>บันทึกข้อมูลเจ้าของรถขนส่ง</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.transport-owners._table')
                </div>
            </div>
        </div>
    </div>
@endsection

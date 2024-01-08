@extends('layouts.app')

@section('title', 'นำเข้าข้อมูลราคาซื้อ')

@section('page-title')
    <h2>นำเข้าข้อมูลราคาซื้อ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>นำเข้าข้อมูลราคาซื้อ</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a href="{{ route('ct.purchase_price_info.create') }}" class="btn btn-primary">
        สร้างรายการ
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <purchase-price-info-component :is_create="false"></purchase-price-info-component>
                </div>
            </div>
        </div>
    </div>
@endsection

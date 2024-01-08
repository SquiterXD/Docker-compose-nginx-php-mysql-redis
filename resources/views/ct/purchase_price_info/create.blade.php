@extends('layouts.app')

@section('title', 'นำเข้าข้อมูลราคาซื้อ')

@section('page-title')
    <h2>สร้างข้อมูลนำเข้าราคาซื้อ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>สร้างข้อมูลนำเข้าราคาซื้อ</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <purchase-price-info-component :is_create="true"></purchase-price-info-component>
                </div>
            </div>
        </div>
    </div>
@endsection

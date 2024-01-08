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

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                  <purchase-price-info-import-xlsx-component></purchase-price-info-import-xlsx-component>
                </div>
            </div>
        </div>
    </div>
@endsection

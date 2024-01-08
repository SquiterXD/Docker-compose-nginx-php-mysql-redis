@extends('layouts.app')

@section('title', 'รับสินค้าคืน สำหรับ Sale Order')

@section('page-title')
    <h2>
        <x-get-program-code url="/om/product-return"/> รับสินค้าคืน สำหรับ Sale Order
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>รับสินค้าคืน สำหรับ Sale Order</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h3>รับสินค้าคืน สำหรับ Sale Order</h3>
        </div>
        <div class="ibox-content">
            <product-return 
                :segment="{{ json_encode($segment) }}"
                :transaction-types-all="{{ json_encode($transactionTypes) }}">
            </product-return>
        </div>
    </div>
@endsection
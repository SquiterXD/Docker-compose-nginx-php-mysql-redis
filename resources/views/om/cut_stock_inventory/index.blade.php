@extends('layouts.app')

@section('title', 'ตัด Stock Inventory สำหรับ Sale Order')

@section('page-title')
    <h2>
        <x-get-program-code url="/om/cut-stock-inventory"/> ตัด Stock Inventory สำหรับ Sale Order
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>ตัด Stock Inventory สำหรับ Sale Order</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h3>ตัด Stock Inventory สำหรับ Sale Order</h3>
        </div>
        <div class="ibox-content">
            <cut-stock-inventory 
                :segment="{{ json_encode($segment) }}"
                :transaction-types-all="{{ json_encode($transactionTypes) }}">
            </cut-stock-inventory>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('title', 'PAO TAX')

@section('page-title')
    <h2>
        <x-get-program-code url="/om/pao-tax-mt" /> ผ่านข้อมูลภาษี อบจ. สำหรับ Modern Trade ให้บัญชีเจ้าหนี้
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>ผ่านข้อมูลภาษี อบจ. สำหรับ Modern Trade ให้บัญชีเจ้าหนี้</strong>
        </li>
    </ol>
@endsection

@section('page-title-action')
    
@endsection

@section('content')
<div class="ibox">
    <div class="ibox-content">
        <poa-tax-mt
            :customer-lists="{{ json_encode($customerLists) }}"
            :bank-lists="{{ json_encode($bankLists) }}"
            :default-bank="{{ json_encode($defaultBank) }}">
        </poa-tax-mt>
    </div>
</div>
@endsection
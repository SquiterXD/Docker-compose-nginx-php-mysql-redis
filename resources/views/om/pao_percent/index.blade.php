@extends('layouts.app')

@section('title', 'PAO Percent')

@section('page-title')
    <h2>
        <x-get-program-code url="/om/pao-percent" /> กำหนดส่วนแบ่ง % ภาษีอบจ.
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>กำหนดส่วนแบ่ง % ภาษีอบจ.</strong>
        </li>
    </ol>
@endsection

@section('page-title-action')
    
@endsection

@section('content')
<div class="ibox">
    <div class="ibox-content">
        <pao-percent>
        </pao-percent>
    </div>
</div>
@endsection
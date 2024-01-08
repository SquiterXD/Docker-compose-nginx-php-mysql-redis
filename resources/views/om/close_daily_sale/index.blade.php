@extends('layouts.app')

@section('title', 'ปิดการขายประจำวัน')

@section('page-title')
    <h2>
        <x-get-program-code url="/om/close-daily-sale" /> ปิดการขายประจำวัน สำหรับขายในประเทศ
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>ปิดการขายประจำวัน สำหรับขายในประเทศ</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h3>ปิดการขายประจำวัน สำหรับขายในประเทศ</h3>
        </div>
        <div class="ibox-content">
            <close-daily-sale>
            </close-daily-sale>
        </div>
    </div>
@endsection
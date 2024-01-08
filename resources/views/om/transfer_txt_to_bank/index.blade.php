@extends('layouts.app')

@section('title', 'โอนข้อมูล และ Generate Text file ภาษี อบจ. เพื่อนำส่งธนาคาร')

@section('page-title')
    <h2>
        <x-get-program-code url="/om/transfer-txt-to-bank" /> โอนข้อมูล และ Generate Text file ภาษี อบจ. เพื่อนำส่งธนาคาร
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>โอนข้อมูล และ Generate Text file ภาษี อบจ. เพื่อนำส่งธนาคาร</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h3>โอนข้อมูล และ Generate Text file ภาษี อบจ. เพื่อนำส่งธนาคาร</h3>
        </div>
        <div class="ibox-content">
            <transfer-txt-to-bank
                :bank-lists="{{ json_encode($bankLists) }}">
            </transfer-txt-to-bank>
        </div>
    </div>
@endsection
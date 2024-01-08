@extends('layouts.app')

@section('title', 'รายการฝากขายสโมสรกรุงเทพ')

@section('custom_css')
    <style>
        .bg-readonly {
            background-color: #e9ecef;
        }
    </style>
@stop

@section('page-title')
    <h2>
        <x-get-program-code url="/om/consignment-bkk" /> รายการฝากขายสโมสรกรุงเทพ
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>รายการฝากขายสโมสรกรุงเทพ</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h3>รายการฝากขายสโมสรกรุงเทพ</h3>
        </div>
        <div class="ibox-content">
            <consignment-bkk
                :customer-lists="{{ json_encode($customerLists) }}"
                :convert-lists="{{ json_encode($convertLists) }}"
            ></consignment-bkk>
        </div>
    </div>
@endsection

@section('scripts')

@stop

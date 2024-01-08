@extends('layouts.app')

@section('title', 'ปิดการรับเงินประจำวัน')

@section('page-title')
    <h2>
        <x-get-program-code url="/om/close-daily-payoff/{{$saleClass}}"/> ปิดการรับเงินประจำวัน {{ $saleClass === 'domestic' ? 'สำหรับขายในประเทศ' : ($saleClass === 'export' ? 'สำหรับขายต่างประเทศ' : '') }}
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>ปิดการรับเงินประจำวัน {{ $saleClass === 'domestic' ? 'สำหรับขายในประเทศ' : ($saleClass === 'export' ? 'สำหรับขายต่างประเทศ' : '') }}</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h3>ปิดการรับเงินประจำวัน {{ $saleClass === 'domestic' ? 'สำหรับขายในประเทศ' : ($saleClass === 'export' ? 'สำหรับขายต่างประเทศ' : '') }}</h3>
        </div>
        <div class="ibox-content">
            <close-daily-payoff
                :sale-class="{{ json_encode($saleClass) }}">
            </close-daily-payoff>
        </div>
    </div>
@endsection
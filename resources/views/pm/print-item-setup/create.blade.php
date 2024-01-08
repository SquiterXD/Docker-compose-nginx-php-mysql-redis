@extends('layouts.app')

@section('title', 'กำหนดสีแบรนด์และผลิตภัณฑ์สำหรับการวางแผนรายวัน')

@section('page-title')
    <h2> <x-get-program-code url="/pm/settings/print-item-setup" />: กำหนดสีแบรนด์และผลิตภัณฑ์สำหรับการวางแผนรายวัน </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">Setting</a>
        </li>
        <li class="breadcrumb-item ">
            <x-get-program-code url="/pm/settings/print-item-setup" />: กำหนดสีแบรนด์และผลิตภัณฑ์สำหรับการวางแผนรายวัน
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/pm/settings/print-item-setup" />: สร้างกำหนดสีแบรนด์และผลิตภัณฑ์สำหรับการวางแผนรายวัน</strong>
        </li>
    </ol>
@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h5><x-get-program-code url="/pm/settings/print-item-setup" />: สร้างกำหนดสีแบรนด์และผลิตภัณฑ์สำหรับการวางแผนรายวัน</h5>
        </div>

        <div class="ibox-content qm-content">
            {!! Form::open(['route' => ['pm.settings.print-item-setup.store'], 'method' => 'get', 'autocomplete' => 'off', 'class' => 'form-horizontal']) !!}
            <print-item-setup-create    :item-number-list = "{{ json_encode($itemNumberList) }}"
                                        :size-list = "{{ json_encode($sizeList) }}"
                                        :print-type-list = "{{ json_encode($printTypeList) }}">
            </print-item-setup-create>
            <div class="col-12 mt-5">
                <hr>
                <div class="row clearfix m-t-lg text-right">
                    <div class="col-sm-12">
                        <button class="{{$btnTrans['save']['class']}}" type="submit">
                            <i class="{{$btnTrans['save']['icon']}}"></i> {{ $btnTrans['save']['text'] }} 
                        </button>
                        <a  href="{{ route('pm.settings.print-item-setup.index') }}" 
                            type="button" 
                            class="{{$btnTrans['cancel']['class']}}">
                            <i class="{{$btnTrans['cancel']['icon']}}"></i> {{$btnTrans['cancel']['text']}}
                        </a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection

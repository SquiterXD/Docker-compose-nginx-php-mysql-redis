@extends('layouts.app')

@section('title', 'กำหนดจุดตรวจสอบด้านมอดยาสูบ: เพิ่มรายการ')

@section('page-title')
    <h2>QMS0005 : กำหนดจุดตรวจสอบมอดยาสูบ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">QM</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">Settings</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{ route('qm.settings.check-points-tobacco-beetle.index') }}">กำหนดจุดตรวจสอบมอดยาสูบ</a>
        </li>
        <li class="breadcrumb-item">
            <strong><a href="/">สร้าง</a></strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนดจุดตรวจสอบด้านมอดยาสูบ</h5>
                </div>
                <div class="ibox-content">
                    {{-- {!! Form::open(['route' => ['qm.settings.check-points-tobacco-beetle.store'], 
                                    "method" => "post" , 
                                    "autocomplete" => "off", 
                                    'class' => 'form-horizontal', 
                                    "enctype" => "multipart/form-data"]) !!} --}}
                        
                        {{-- <check-points-tobacco-beetle-create :location-codes = "{{ json_encode($locationCodes) }}">
                        </check-points-tobacco-beetle-create> --}}

                        <check-points-tobacco-beetle-create :btn-trans = "{{ json_encode($btnTrans) }}">
                        </check-points-tobacco-beetle-create>

                    {{-- {!! Form::close() !!} --}}
                </div>
            </div>
        </div>
    </div>
@endsection
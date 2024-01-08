@extends('layouts.app')

@section('title', 'กำหนดกระบวนการตรวจคุณภาพบุหรี่ และตรวจสอบคุณภาพบุหรี่')

@section('page-title')
    <h2>: กำหนดกระบวนการตรวจคุณภาพบุหรี่ และตรวจสอบคุณภาพบุหรี่</h2>
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
            <a href="{{ route('qm.settings.quality-assurance.index') }}">กำหนดกระบวนการตรวจคุณภาพบุหรี่ และตรวจสอบคุณภาพบุหรี่</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><a href="/">สร้าง</a></strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>สร้างกำหนดกระบวนการตรวจคุณภาพบุหรี่ และตรวจสอบคุณภาพบุหรี่</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['qm.settings.quality-assurance.store'], 
                                    "method" => "post", 
                                    "autocomplete" => "off", 
                                    'class' => 'form-horizontal', 
                                    'enctype' => 'multipart/form-data' ]) !!}
                        
                        <quality-assurance-create-table>
                        </quality-assurance-create-table>
                        <div class="col-12 mt-3">
                            <hr>
                            <div class="row clearfix m-t-lg text-right">
                                <div class="col-sm-12">
                                    <button class="{{ $btnTrans['save']['class'] }}" type="submit">
                                        <i class="{{ $btnTrans['save']['icon'] }}" aria-hidden="true"></i>  
                                        {{ $btnTrans['save']['text'] }} 
                                    </button>
                                    <a href="{{ route('qm.settings.quality-assurance.index') }}" type="button" class="{{ $btnTrans['cancel']['class'] }}">
                                        <i class="{{ $btnTrans['cancel']['icon'] }}" aria-hidden="true"></i> {{ $btnTrans['cancel']['text'] }} 
                                    </a>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
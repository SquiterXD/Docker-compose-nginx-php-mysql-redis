@extends('layouts.app')

@section('title', 'กำหนดหัวข้อการทดสอบ : กลุ่มผลิตด้านใบยา')

{{-- @section('page-title')
    <h2>QMS0007 : กำหนดหัวข้อการทดสอบ : กลุ่มผลิตด้านใบยา</h2>
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
            <a href="{{ route('qm.settings.define-tests-tobacco-leaf.index') }}">กำหนดหัวข้อการทดสอบ : กลุ่มผลิตด้านใบยา</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><a href="/">สร้าง</a></strong>
        </li>
    </ol>
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/qm/settings/define-tests-tobacco-leaf" />
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนดหัวข้อการทดสอบ : กลุ่มผลิตด้านใบยา</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['qm.settings.define-tests-tobacco-leaf.store'], 
                                    "method" => "post", 
                                    "autocomplete" => "off", 
                                    'class' => 'form-horizontal', 
                                    'enctype' => 'multipart/form-data',
                                    'files'=> true, ]) !!}
                        
                        <define-tests-create    :units = "{{ json_encode($units) }}" 
                                                :data-types = "{{ json_encode($dataTypes) }}"
                                                :result-severites = "{{ json_encode($resultSeverites) }}"
                                                :test-type-code = "{{ json_encode($testTypeCode) }}"
                                                :old-input="{{ json_encode(Session::getOldInput()) }}">
                        </define-tests-create>

                        <div class="col-12 mt-3">
                            <hr>
                            <div class="row clearfix m-t-lg text-right">
                                <div class="col-sm-12">
                                    <button class="{{ $btnTrans['save']['class'] }}" 
                                            type="submit"
                                            id="btnSaveCreate">
                                        <i class="{{ $btnTrans['save']['icon'] }}" aria-hidden="true"></i>  
                                        {{ $btnTrans['save']['text'] }} 
                                    </button>
                                    <a href="{{ route('qm.settings.define-tests-tobacco-leaf.index') }}" type="button" class="{{ $btnTrans['cancel']['class'] }}">
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
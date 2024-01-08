@extends('layouts.app')

@section('title', 'กำหนดปัญหา/ข้อบกพร่อง : กลุ่มผลิตภัณฑ์สำเร็จรูป')

{{-- @section('page-title')
    <h2>QMS0009 : กำหนดปัญหา/ข้อบกพร่อง : กลุ่มผลิตภัณฑ์สำเร็จรูป</h2>
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
            <strong><a href="{{ route('qm.settings.define-tests-finished-products.index') }}">กำหนดปัญหา/ข้อบกพร่อง : กลุ่มผลิตภัณฑ์สำเร็จรูป</a></strong>
        </li>
    </ol>
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/qm/settings/define-tests-finished-products" />
@stop

@section('page-title-action')
    <a href="{{ route('qm.settings.define-tests-finished-products.create') }}" class="{{ $btnTrans['create']['class'] }}">
        <i class="{{ $btnTrans['create']['icon'] }}"></i> {{ $btnTrans['create']['text'] }}
    </a>
@stop

@section('content')
{!! Form::open(['route' => ['qm.settings.define-tests-finished-products.index'] , "method" => "get" , "autocomplete" => "off", 'class' => 'form-horizontal'])!!}
    <define-tests-search    :btn-trans = "{{ json_encode($btnTrans) }}"
                            :result-severites = "{{ json_encode($resultSeverites) }}"
                            :units = "{{ json_encode($units) }}"
                            :search = "{{ json_encode($search) }}"
                            :test-desc-list = "{{ json_encode($testDescList) }}"
                            :test-type-code = "{{ json_encode($testTypeCode) }}"
                            :process-test-list = "{{ json_encode($processTestList) }}"
                            :entity-test-list = "{{ json_encode($entityTestList) }}"
                            :process-distinct-test-list = "{{ json_encode($processDistinctTestList) }}">
    </define-tests-search>
{!! Form::close() !!}
{!! Form::open(['route' => [    'qm.settings.define-tests-finished-products.update'], 
                                "method" => "put", 
                                "autocomplete" => "off", 
                                'class' => 'form-horizontal', 
                                'enctype' => 'multipart/form-data',
                                'files'=> true, ]) !!}
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center m-t-lg">
                <div class="ibox-title" style="text-align:left;">
                    <h5>กำหนดปัญหา/ข้อบกพร่อง : กลุ่มผลิตภัณฑ์สำเร็จรูป</h5>
                </div>
                <div class="ibox-content">
                    <define-tests-index     :tests = "{{ json_encode($tests) }}"
                                            :result-severites = "{{ json_encode($resultSeverites) }}"
                                            :units = "{{ json_encode($units) }}"
                                            :data-types = "{{ json_encode($dataTypes) }}"
                                            :process-test-list = "{{ json_encode($processTestList) }}"
                                            :entity-test-list = "{{ json_encode($entityTestList) }}"
                                            :process-distinct-test-list = "{{ json_encode($processDistinctTestList) }}">
                    </define-tests-index>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end md:tw-my-0 tw-my-2 lg:tw-px-0 tw-px-2" style="padding-top: 20px;">
        {!! $tests->links('shared._pagination') !!}
    </div>

    <div class="col-12"style="padding-bottom: 20px;">
        <div class="row clearfix text-center">
            <div class="col-sm-12">
                <button class="{{ $btnTrans['save']['class'] }}" 
                        type="submit"
                        id="btnSaveIndex">
                    <i class="{{ $btnTrans['save']['icon'] }}" aria-hidden="true"></i>  
                    {{ $btnTrans['save']['text'] }} 
                </button>
                <a href="{{ route('qm.settings.define-tests-finished-products.index') }}" type="button" class="{{ $btnTrans['cancel']['class'] }}">
                    <i class="{{ $btnTrans['cancel']['icon'] }}" aria-hidden="true"></i> {{ $btnTrans['cancel']['text'] }} 
                </a>
            </div>
        </div>
    </div>
{!! Form::close() !!}
@endsection



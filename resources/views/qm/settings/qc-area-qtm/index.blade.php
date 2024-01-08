@extends('layouts.app')

@section('title', 'เขตการตรวจสอบคุณภาพ : ผลิตภัณฑ์สำเร็จรูป')

@section('page-title')
    <h2><x-get-program-code url="/qm/settings/qc-area-qtm"/> : เขตการตรวจสอบคุณภาพ : QTM</h2>
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
            <strong><x-get-program-code url="/qm/settings/qc-area-qtm"/> : เขตการตรวจสอบคุณภาพ : QTM</a></strong>
        </li>
    </ol>
@stop

 @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <h1 class="tw-mt-0"></h1>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['qm.settings.qc-area-qtm.index'], 
                                    "method" => "get" , 
                                    "autocomplete" => "off", 
                                    'class' => 'form-horizontal',
                                    'id' => "formSearch"]) !!}
                        <qc-area-qtm-search     :search = "{{ json_encode($search) }}"
                                                :list-search-step-description = "{{ json_encode($listSearchStepDescription) }}"
                                                :list-search-machine-description = "{{ json_encode($listSearchMachineDescription) }}"
                                                :list-search-machine-set = "{{ json_encode($listSearchMachineSet) }}"
                                                :list-search-qc-area = "{{ json_encode($listSearchQcArea) }}">
                        </qc-area-qtm-search>

                        <div class="row clearfix text-right">
                            <div class="col" style="margin-top: 15px; margin-right: 5px;">
                                <button class="{{ $btnTrans['search']['class'] }}" type="submit"> 
                                    <i class="{{ $btnTrans['search']['icon'] }}" aria-hidden="true"></i> {{ $btnTrans['search']['text'] }} 
                                </button>
                                <a type="button" href="{{ route('qm.settings.qc-area-qtm.index') }}" class="btn btn-danger">
                                    ล้าง
                                </a>
                            </div>
                        </div>
                        
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="text-center m-t-lg">
                <div class="ibox-title" style="text-align:left;">
                    <h5><x-get-program-code url="/qm/settings/qc-area-qtm"/> : เขตการตรวจสอบคุณภาพ : QTM</h5>
                </div>
                <div class="ibox-content">
                    @include('qm.settings.qc-area-qtm._table')
                </div>
            </div>
        </div>
    </div>
@endsection


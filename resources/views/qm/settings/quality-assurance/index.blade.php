@extends('layouts.app')

@section('title', 'กำหนดกระบวนการตรวจคุณภาพบุหรี่ และตรวจสอบคุณภาพบุหรี่')

@section('page-title')
    <h2> : กำหนดกระบวนการตรวจคุณภาพบุหรี่ และตรวจสอบคุณภาพบุหรี่</h2>
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
            <strong><a href="{{ route('qm.settings.quality-assurance.index') }}">กำหนดกระบวนการตรวจคุณภาพบุหรี่ และตรวจสอบคุณภาพบุหรี่</a></strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a href="{{ route('qm.settings.quality-assurance.create') }}" class="{{ $btnTrans['create']['class'] }}">
        <i class="{{ $btnTrans['create']['icon'] }}"></i> {{ $btnTrans['create']['text'] }}
    </a>
@stop

@section('content')
{{-- {!! Form::open(['route' => [    'qm.settings.define-tests-tobacco-leaf.update'], 
                                "method" => "put", 
                                "autocomplete" => "off", 
                                'class' => 'form-horizontal', 
                                'enctype' => 'multipart/form-data',
                                'files'=> true, ]) !!} --}}
                                
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center m-t-lg">
                <div class="ibox-title" style="text-align:left;">
                    <h5>กำหนดกระบวนการตรวจคุณภาพบุหรี่ และตรวจสอบคุณภาพบุหรี่</h5>
                </div>
                <div class="ibox-content">
                    <quality-assurance-table :quality-assurance-list = "{{ json_encode($qualityAssuranceList) }}">

                    </quality-assurance-table>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end md:tw-my-0 tw-my-2 lg:tw-px-0 tw-px-2" style="padding-top: 20px;">
        {!! $qualityAssuranceList->links('shared._pagination') !!}
    </div>

{{-- {!! Form::close() !!} --}}
@endsection

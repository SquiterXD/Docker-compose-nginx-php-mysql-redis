@extends('layouts.app')

@section('title', 'กำหนดหน่วยการทดสอบ')

@section('page-title')
    <h2><x-get-program-code url="/qm/settings/test-unit"/>: กำหนดหน่วยการทดสอบ</h2>
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
            <strong><x-get-program-code url="/qm/settings/test-unit"/>: กำหนดหน่วยการทดสอบ</a></strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>แก้ไขกำหนดหน่วยการทดสอบ</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['qm.settings.test-unit.update'], 
                                    "method" => "put", 
                                    "autocomplete" => "off", 
                                    'class' => 'form-horizontal', 
                                    'enctype' => 'multipart/form-data',
                                    'files'=> true, ]) !!}

                        <test-unit-edit :units = "{{ json_encode($units) }}">
                            
                        </test-unit-edit>

                        <div class="col-12 mt-3">
                            <hr>
                            <div class="row clearfix m-t-lg text-right">
                                <div class="col-sm-12">
                                    <button class="{{ $btnTrans['save']['class'] }}" 
                                            type="submit">
                                            <i class="{{ $btnTrans['save']['icon'] }}" aria-hidden="true"></i>  
                                            {{ $btnTrans['save']['text'] }} 
                                    </button>
                                    <a  href="{{ route('qm.settings.test-unit.index') }}" 
                                        type="button" 
                                        class="{{ $btnTrans['cancel']['class'] }}">
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
@extends('layouts.app')

@section('title', 'กำหนดจุดตรวจสอบใบยา')

@section('page-title')
    <h2>QMS0018 : กำหนดจุดตรวจสอบใบยา</h2>
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
            <a href="{{ route('qm.settings.check-points-tobacco-leaf.index') }}">กำหนดจุดตรวจสอบใบยา</a>
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
                    <h5>กำหนดจุดตรวจสอบด้านใบยา</h5>
                </div>
                <div class="ibox-content">
                    {{-- {!! Form::open(['route' => ['qm.settings.check-points-tobacco-leaf.store'], 
                                    "method" => "post", 
                                    "autocomplete" => "off", 
                                    'class' => 'form-horizontal', 
                                    'enctype' => 'multipart/form-data',
                                    'files'=> true, ]) !!} --}}
                
                        <check-points-tobacco-leaf-create   :work-list = "{{ json_encode($workList) }}"
                                                            :old-input = "{{ json_encode(Session::getOldInput()) }}"
                                                            :btn-trans = "{{ json_encode($btnTrans) }}">
                        </check-points-tobacco-leaf-create>

                    {{-- {!! Form::close() !!} --}}

                </div>
            </div>
        </div>
    </div>
@endsection
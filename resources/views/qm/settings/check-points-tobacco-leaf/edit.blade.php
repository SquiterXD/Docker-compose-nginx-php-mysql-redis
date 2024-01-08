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
            <strong><a href="/">แก้ไข</a></strong>
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
                    {{-- {!! Form::open(['route' => ['qm.settings.check-points-tobacco-leaf.update'], 
                                    "method" => "post", 
                                    "autocomplete" => "off", 
                                    'class' => 'form-horizontal', 
                                    'enctype' => 'multipart/form-data',
                                    'files'=> true, ]) !!} --}}

                        <check-points-tobacco-leaf-edit :check-points = "{{ json_encode($checkPoints) }}"
                                                        :work-list = "{{ json_encode($workList) }}"
                                                        :btn-trans = "{{ json_encode($btnTrans) }}">
                        </check-points-tobacco-leaf-edit>

                        {{-- <div class="col-12 mt-3">
                            <hr>
                            <div class="row clearfix m-t-lg text-right">
                                <div class="col-sm-12">
                                    <button class="{{$btnTrans['save']['class']}}" 
                                            type="submit">
                                            <i class="{{$btnTrans['save']['icon']}}" aria-hidden="true"></i>  
                                            {{$btnTrans['save']['text']}}
                                    </button>
                                    <a  href="{{ route('qm.settings.check-points-tobacco-leaf.index') }}" 
                                        type="button" 
                                        class="{{$btnTrans['cancel']['class']}}"> 
                                        <i class="{{$btnTrans['cancel']['icon']}}" aria-hidden="true"></i> 
                                        {{$btnTrans['cancel']['text']}}
                                    </a>
                                </div>
                            </div>
                        </div> --}}
                    {{-- {!! Form::close() !!} --}}
                </div>
            </div>
        </div>
    </div>
@endsection
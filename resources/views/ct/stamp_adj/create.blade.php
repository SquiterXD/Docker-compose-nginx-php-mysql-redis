@extends('layouts.app')

@section('title', 'กำหนดการปันส่วนแสตมป์')

@section('page-title')
    <x-get-page-title menu="" url="/ct/stamp_adj" />
    {{-- <h2>CTM0020 : กำหนดการปันส่วนแสตมป์ </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>กำหนดการปันส่วนแสตมป์</strong>
        </li>
    </ol> --}}
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <stamp-adj-form-component 
                        :trans_btn="{{ json_encode(trans('btn')) }}"
                        :default-value-set-name="{{ json_encode($defaultValueSetName) }}"
                        :segment-data="{{ json_encode($segmentData) }}"
                        :stamp-types="{{ json_encode($stampTypes) }}">
                    </stamp-adj-form-component>
                </div>
            </div>
        </div>
    </div>
@endsection
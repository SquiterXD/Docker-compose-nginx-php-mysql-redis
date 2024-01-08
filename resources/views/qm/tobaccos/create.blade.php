@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2> <x-get-program-code url="/qm/tobaccos/create" /> สร้างตัวอย่างการตรวจสอบ : กลุ่มผลิตด้านใบยา </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">QM</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('qm.tobaccos.result') }}"> กลุ่มผลิตด้านใบยา </a>
        </li>
        <li class="breadcrumb-item">
            สร้างตัวอย่างการตรวจสอบ
        </li>
    </ol>

@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h5> สร้างตัวอย่างการตรวจสอบ : กลุ่มผลิตด้านใบยา </h5>
        </div>

        <div class="ibox-content qm-content">

            {!! Form::open(['route' => ['qm.tobaccos.store'], 'method' => 'post', 'autocomplete' => 'off', 'class' => 'form-horizontal']) !!}

            @include('qm.tobaccos._form')

            {!! Form::close() !!}

        </div>
    </div>

@endsection

@section('scripts')

    <script type="text/javascript">
        setTimeout( function() {
            var body = $('body');
            if (body.hasClass('fixed-sidebar')) {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }
            } else {
                if (!body.hasClass('body-small')) {
                    body.addClass('mini-navbar');
                }
            }
        },500)
    </script>
    
@stop
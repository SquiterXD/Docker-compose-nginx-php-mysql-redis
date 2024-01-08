@extends('layouts.app')

@section('title', 'กำหนดค่าเกณฑ์มาตรฐานในการตรวจสอบ')

{{-- @section('page-title')
    <h2>
        <x-get-program-code url="/qm/settings/specifications?test_type={{ $testType->lookup_code }}" /> กำหนดค่าเกณฑ์มาตรฐานในการตรวจสอบ - {{ $testType->meaning }}
    </h2>
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
        <li class="breadcrumb-item">
            กำหนดค่าเกณฑ์มาตรฐานในการตรวจสอบ - {{ $testType->meaning }}
        </li>
    </ol>
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/qm/settings/specifications?test_type={{ $testType->lookup_code }}" />
@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h5> กำหนดค่าเกณฑ์มาตรฐานในการตรวจสอบ - {{ $testType->meaning }} </h5>
        </div>

        <div class="ibox-content qm-content">

            <div class="qm-form justify-content-center clearfix">

                {!! Form::open(['route' => ['qm.settings.specifications.index'], 
                                'method' => 'get', 
                                'autocomplete' => 'off', 
                                'class' => 'form-horizontal', 
                                'id' =>  'fromSearch']) !!}

                {{-- @include('qm.tobaccos._result_search_form') --}}
                @include('qm.settings.specifications._search')

                {!! Form::close() !!}
                
                @if($testType->lookup_code != 5)
                    <hr style="border-color: rgba(0, 0, 0, 0.04);">
                @endif

                <qm-settings-spec
                    :url="{{ json_encode($url) }}"
                    :btn-trans="{{ json_encode(trans('btn')) }}"
                    :p-specifications="{{ json_encode($specifications) }}"
                    :p-result-severity-code="{{ json_encode($resultSeverityCode) }}"
                    :p-test-type="{{ json_encode($testType) }}"
                    :p-test-list="{{ json_encode($testList) }}"
                    :p-request="{{ json_encode(request()->all()) }}"
                    >
                </qm-settings-spec>

            </div>

            {{-- @if($samples->total() > $samples->perPage())
                <div class="d-flex justify-content-end md:tw-my-6 tw-my-2 lg:tw-px-0 tw-px-2">
                    {{ $samples->appends(Request::all())->links('shared._pagination') }}
                </div>
            @endif --}}

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
@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2>
        <x-get-program-code url="/qm/tobaccos/track" /> การติดตามผลการตรวจสอบคุณภาพ : กลุ่มผลิตด้านใบยา
    </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">QM</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('qm.tobaccos.track') }}"> กลุ่มผลิตด้านใบยา </a>
        </li>
        <li class="breadcrumb-item">
            การติดตามผลการตรวจสอบคุณภาพ
        </li>
    </ol>

@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h5> การติดตามผลการตรวจสอบคุณภาพ : กลุ่มผลิตด้านใบยา </h5>
        </div>

        <div class="ibox-content qm-content">

            <div class="qm-form justify-content-center clearfix">

                {!! Form::open(['route' => ['qm.tobaccos.track'], 'method' => 'get', 'autocomplete' => 'off', 'class' => 'form-horizontal']) !!}

                @include('qm.tobaccos._track_search_form')

                <hr style="border-color: rgba(0,0,0,.04);">

                <div class="row form-group text-center justify-content-center clearfix tw-my-6">

                    <div class="col-lg-4 col-md-6">
                        <button class="btn btn-lg btn-white tw-w-32" type="submit">
                            <i class="fa fa-search"></i> ค้นหา
                        </button>
                        <a type="button" href="{{ route('qm.tobaccos.track') }}"
                            class="btn btn-lg tw-bg-gray-100 tw-bg-opacity-60 btn-white tw-w-32 tw-ml-4">
                            <i class="fa fa-times"></i> ล้าง
                        </a>
                    </div>

                </div>

                {!! Form::close() !!}

                <hr class="tw-my-10" />

                <div class="justify-content-center clearfix">
                    <qm-table-tobaccos show-type="track"
                        items="{{ json_encode($sampleItems) }}" 
                        {{-- total="{{ $samples->total() }}"
                        page="{{ $samples->currentPage() }}"
                        per-page="{{ $samples->perPage() }}"  --}}
                        :auth-user="{{ json_encode($authUser) }}"
                        :locators="{{ json_encode($locators) }}"
                        :approval-role="{{ json_encode($approvalRole) }}"
                        :approval-data="{{ json_encode($approvalData) }}"
                    >
                    </qm-table-tobaccos>
                </div>

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
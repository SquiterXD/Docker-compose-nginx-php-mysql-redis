@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2>
        <x-get-program-code url="/qm/finished-products/defect" /> บันทึกสาเหตุความผิดปกติทางคุณภาพของบุหรี่ : กลุ่มผลิตภัณฑ์สำเร็จรูป
    </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">QM</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('qm.finished-products.result') }}"> กลุ่มผลิตภัณฑ์สำเร็จรูป </a>
        </li>
        <li class="breadcrumb-item">
            บันทึกสาเหตุความผิดปกติทางคุณภาพของบุหรี่
        </li>
    </ol>

@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h5> บันทึกสาเหตุความผิดปกติทางคุณภาพของบุหรี่ : กลุ่มผลิตภัณฑ์สำเร็จรูป </h5>
        </div>

        <div class="ibox-content qm-content">

            <div class="qm-form justify-content-center clearfix">

                {!! Form::open(['route' => ['qm.finished-products.defect'], 'method' => 'get', 'autocomplete' => 'off', 'class' => 'form-horizontal']) !!}

                @include('qm.finished-products._defect_search_form')

                <hr style="border-color: rgba(0,0,0,.04);">

                <div class="row form-group text-center justify-content-center clearfix tw-my-6">

                    <div class="col-lg-4 col-md-6">
                        <button class="btn btn-lg btn-white tw-w-32" type="submit">
                            <i class="fa fa-search"></i> ค้นหา
                        </button>
                        <a type="button" href="{{ route('qm.finished-products.defect') }}"
                            class="btn btn-lg tw-bg-gray-100 tw-bg-opacity-60 btn-white tw-w-32 tw-ml-4">
                            <i class="fa fa-times"></i> ล้าง
                        </a>
                    </div>

                </div>

                {!! Form::close() !!}

                <hr class="tw-my-10" />

                <div class="justify-content-center clearfix">

                    <qm-table-finished-products items="{{ json_encode($sampleItems) }}" 
                        total="{{ count($sampleItems) }}"
                        {{-- total="{{ $samples->total() }}"
                        page="{{ $samples->currentPage() }}"
                        per-page="{{ $samples->perPage() }}" --}}
                        show-type="defect"
                        :auth-user="{{ json_encode($authUser) }}"
                        :list-test-serverity-codes="{{ json_encode($listTestServerityCodes) }}"
                        :list-brands="{{ json_encode($listBrands) }}"
                        :approval-role="{{ json_encode($approvalRole) }}"
                        :approval-data="{{ json_encode($approvalData) }}"
                    >
                    </qm-table-finished-products>

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
@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2>
        <x-get-program-code url="/qm/qtm-machines/report-summary" /> รายงานสรุปผลการตรวจสอบด้วยเครื่อง QTM
    </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">QM</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('qm.qtm-machines.result') }}"> การตรวจสอบด้วยเครื่อง QTM </a>
        </li>
        <li class="breadcrumb-item">
            รายงานสรุปผลการตรวจสอบ
        </li>
    </ol>

@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h5> รายงานสรุปผลการตรวจสอบด้วยเครื่อง QTM </h5>
        </div>

        <div class="ibox-content qm-content">

            <div class="qm-form justify-content-center clearfix">

                {!! Form::open(['route' => ['qm.qtm-machines.report-summary'], 'method' => 'get', 'autocomplete' => 'off', 'class' => 'form-horizontal']) !!}

                @include('qm.qtm-machines._report_summary_search_form')

                <hr style="border-color: rgba(0,0,0,.04);">

                <div class="row form-group text-center justify-content-center clearfix tw-my-6">

                    <div class="col-lg-4 col-md-6">
                        <button class="btn btn-lg btn-white tw-w-32" type="submit">
                            <i class="fa fa-search"></i> ค้นหา
                        </button>
                        <a type="button" href="{{ route('qm.qtm-machines.report-summary') }}"
                            class="btn btn-lg tw-bg-gray-100 tw-bg-opacity-60 btn-white tw-w-32 tw-ml-4">
                            <i class="fa fa-times"></i> ล้าง
                        </a>
                    </div>

                </div>

                {!! Form::close() !!}

                <hr class="tw-my-10" />

                @if ($searched)

                    <qm-chart-qtm-machine-report-summary
                        sample-date-from="{{ old('sample_date_from') ? old('sample_date_from') : (isset($searchInputs['sample_date_from']) ? $searchInputs['sample_date_from'] : '') }}"
                        sample-date-to="{{ old('sample_date_to') ? old('sample_date_to') : (isset($searchInputs['sample_date_to']) ? $searchInputs['sample_date_to'] : '') }}"
                        :record-count="{{ $recordCount }}"
                        :data-weight-details="{{ json_encode($dataWeightDetails) }}"
                        :data-weight-summary="{{ json_encode($dataWeightSummary) }}"
                        :data-sizel-details="{{ json_encode($dataSizelDetails) }}"
                        :data-sizel-summary="{{ json_encode($dataSizelSummary) }}"
                        :data-pd-open-details="{{ json_encode($dataPdOpenDetails) }}"
                        :data-pd-open-summary="{{ json_encode($dataPdOpenSummary) }}"
                        :data-tip-vent-details="{{ json_encode($dataTipVentDetails) }}"
                        :data-tip-vent-summary="{{ json_encode($dataTipVentSummary) }}"
                    ></qm-chart-qtm-machine-report-summary>

                @endif

            </div>

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
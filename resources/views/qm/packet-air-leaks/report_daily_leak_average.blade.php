@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2>
        <x-get-program-code url="/qm/packet-air-leaks/report-daily-leak-average" /> รายงานค่าเฉลี่ยผลการตรวจวัดอัตรารั่วฟิล์มห่อซองบุหรี่
    </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">QM</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('qm.packet-air-leaks.result') }}"> การตรวจอัตราลมรั่ว ของซองบุหรี่ </a>
        </li>
        <li class="breadcrumb-item">
            รายงานค่าเฉลี่ยผลการตรวจวัดอัตรารั่วฟิล์มห่อซองบุหรี่
        </li>
    </ol>

@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h5> รายงานค่าเฉลี่ยผลการตรวจวัดอัตรารั่วฟิล์มห่อซองบุหรี่ </h5>
        </div>

        <div class="ibox-content qm-content">

            <div class="qm-form justify-content-center clearfix">

                {!! Form::open(['route' => ['qm.packet-air-leaks.report-daily-leak-average'], 'method' => 'get', 'autocomplete' => 'off', 'class' => 'form-horizontal']) !!}

                @include('qm.packet-air-leaks._report_daily_leak_average_search_form')

                <hr style="border-color: rgba(0,0,0,.04);">

                <div class="row form-group text-center justify-content-center clearfix tw-my-6">

                    <div class="col-lg-4 col-md-6">
                        <button class="btn btn-lg btn-white tw-w-32" type="submit">
                            <i class="fa fa-search"></i> ค้นหา
                        </button>
                        <a type="button" href="{{ route('qm.packet-air-leaks.report-daily-leak-average') }}"
                            class="btn btn-lg tw-bg-gray-100 tw-bg-opacity-60 btn-white tw-w-32 tw-ml-4">
                            <i class="fa fa-times"></i> ล้าง
                        </a>
                    </div>

                </div>

                {!! Form::close() !!}

                <hr class="tw-my-10" />

                @if ($searched)

                    <qm-chart-packet-air-leak-report-daily-leak-average 
                        sample-date-from="{{ old('sample_date_from') ? old('sample_date_from') : (isset($searchInputs['sample_date_from']) ? $searchInputs['sample_date_from'] : '') }}"
                        sample-date-to="{{ old('sample_date_to') ? old('sample_date_to') : (isset($searchInputs['sample_date_to']) ? $searchInputs['sample_date_to'] : '') }}"
                        :report-items="{{ json_encode($reportItems) }}"
                        :report-by-date-items="{{ json_encode($reportByDateItems) }}"
                        :report-by-position-items="{{ json_encode($reportByPositionItems) }}"
                        :summarized-report-item="{{ json_encode($summarizedReportItem) }}"
                        >
                    </qm-chart-packet-air-leak-report-daily-leak-average>

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
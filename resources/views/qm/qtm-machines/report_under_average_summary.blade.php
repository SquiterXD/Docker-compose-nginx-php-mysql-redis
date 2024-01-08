@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2>
        <x-get-program-code url="/qm/qtm-machines/report-under-average-summary" /> สรุปผลการตรวจสอบคุณภาพทางฟิสิกส์ของบุหรี่/ก้นกรองที่ไม่ผ่านค่ามาตรฐาน
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
            สรุปผลการตรวจสอบคุณภาพทางฟิสิกส์ของบุหรี่/ก้นกรองที่ไม่ผ่านค่ามาตรฐาน
        </li>
    </ol>

@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h5> สรุปผลการตรวจสอบคุณภาพทางฟิสิกส์ของบุหรี่/ก้นกรองที่ไม่ผ่านค่ามาตรฐาน </h5>
        </div>

        <div class="ibox-content qm-content">

            <div class="qm-form justify-content-center clearfix">

                {!! Form::open(['route' => ['qm.qtm-machines.report-under-average-summary'], 'method' => 'get', 'autocomplete' => 'off', 'class' => 'form-horizontal']) !!}

                @include('qm.qtm-machines._report_under_average_summary_search_form')

                <hr style="border-color: rgba(0,0,0,.04);">

                <div class="row form-group text-center justify-content-center clearfix tw-my-6">

                    <div class="col-lg-4 col-md-6">
                        <button class="btn btn-lg btn-white tw-w-32" type="submit">
                            <i class="fa fa-search"></i> ค้นหา
                        </button>
                        <a type="button" href="{{ route('qm.qtm-machines.report-under-average-summary') }}"
                            class="btn btn-lg tw-bg-gray-100 tw-bg-opacity-60 btn-white tw-w-32 tw-ml-4">
                            <i class="fa fa-times"></i> ล้าง
                        </a>
                    </div>

                </div>

                {!! Form::close() !!}

                <hr class="tw-my-10" />

                @if ($searched)

                    <div class="tw-mb-4 tw-h-5">

                        <div class="tw-inline-block pull-right">

                            {!! Form::open(['route' => ['qm.qtm-machines.export-pdf.report-under-average-summary'], 'method' => 'post']) !!}
                                    
                                    <input type="hidden" name="report_machine_cig_items" value="{{ json_encode($reportMachineCigItems) }}" />
                                    <input type="hidden" name="report_machine_filter_items" value="{{ json_encode($reportMachineFilterItems) }}" />

                                    <input type="hidden" name="report_summarized_machine_cig_item" value="{{ json_encode($reportSummarizedMachineCigItem) }}" />
                                    <input type="hidden" name="report_summarized_machine_filter_item" value="{{ json_encode($reportSummarizedMachineFilterItem) }}" />

                                    <input type="hidden" name="sample_date_from" value="{{ old('sample_date_from') ? old('sample_date_from') : (isset($searchInputs['sample_date_from']) ? $searchInputs['sample_date_from'] : '') }}" />
                                    <input type="hidden" name="sample_date_to" value="{{ old('sample_date_to') ? old('sample_date_to') : (isset($searchInputs['sample_date_to']) ? $searchInputs['sample_date_to'] : '') }}" />
                                    <input type="hidden" name="task_type_code" value="{{ old('task_type_code') ? old('task_type_code') : (isset($searchInputs['task_type_code']) ? $searchInputs['task_type_code'] : '200') }}" />

                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fa fa fa-file-pdf-o tw-mr-1"></i> Export PDF
                                    </button>

                                {!! Form::close() !!}

                        </div>

                        <div class="tw-inline-block pull-right tw-mx-2">
                        
                            {!! Form::open(['route' => ['qm.qtm-machines.export-excel.report-under-average-summary'], 'method' => 'post']) !!}
                                
                                <input type="hidden" name="report_machine_cig_items" value="{{ json_encode($reportMachineCigItems) }}" />
                                <input type="hidden" name="report_machine_filter_items" value="{{ json_encode($reportMachineFilterItems) }}" />

                                <input type="hidden" name="report_summarized_machine_cig_item" value="{{ json_encode($reportSummarizedMachineCigItem) }}" />
                                <input type="hidden" name="report_summarized_machine_filter_item" value="{{ json_encode($reportSummarizedMachineFilterItem) }}" />

                                <input type="hidden" name="sample_date_from" value="{{ old('sample_date_from') ? old('sample_date_from') : (isset($searchInputs['sample_date_from']) ? $searchInputs['sample_date_from'] : '') }}" />
                                <input type="hidden" name="sample_date_to" value="{{ old('sample_date_to') ? old('sample_date_to') : (isset($searchInputs['sample_date_to']) ? $searchInputs['sample_date_to'] : '') }}" />
                                <input type="hidden" name="task_type_code" value="{{ old('task_type_code') ? old('task_type_code') : (isset($searchInputs['task_type_code']) ? $searchInputs['task_type_code'] : '200') }}" />

                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fa fa fa-file-excel-o tw-mr-1"></i> Export Excel
                                </button>

                            {!! Form::close() !!}

                        </div>
                        
                    </div>

                    {{-- CIG --}}
                    @if($searchInputs['task_type_code'] == "200")

                        <div class="tw-py-2">
                            <h4 class="text-center"> 
                                <span> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }}  </span>
                                <span class="tw-ml-4"> ประเภท : บุหรี่ </span>
                            </h4>
                        </div>
                        <qm-table-qtm-machine-report-under-average-summary 
                            task-type-code="{{ old('task_type_code') ? old('task_type_code') : (isset($searchInputs['task_type_code']) ? $searchInputs['task_type_code'] : '') }}"
                            :report-items="{{ json_encode($reportMachineCigItems) }}"
                            :report-summarized="{{ json_encode($reportSummarizedMachineCigItem) }}"
                        ></qm-table-qtm-machine-report-under-average-summary>


                    @endif

                    {{-- FILTER --}}
                    @if($searchInputs['task_type_code'] == "300")

                        <div class="tw-py-2">
                            <h4 class="text-center"> 
                                <span> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }}  </span>
                                <span class="tw-ml-4"> ประเภท : ก้นกรอง </span>
                            </h4>
                        </div>
                        <qm-table-qtm-machine-report-under-average-summary 
                            task-type-code="{{ old('task_type_code') ? old('task_type_code') : (isset($searchInputs['task_type_code']) ? $searchInputs['task_type_code'] : '') }}"
                            :report-items="{{ json_encode($reportMachineFilterItems) }}"
                            :report-summarized="{{ json_encode($reportSummarizedMachineFilterItem) }}"
                        ></qm-table-qtm-machine-report-under-average-summary>

                    
                    @endif

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
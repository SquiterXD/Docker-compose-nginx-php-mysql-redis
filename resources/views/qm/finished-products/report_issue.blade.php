@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2>
        <x-get-program-code url="/qm/finished-products/report-issue" /> รายงานแบบบันทึกการตรวจพบข้อบกพร่อง
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
            รายงานแบบบันทึกการตรวจพบข้อบกพร่อง
        </li>
    </ol>

@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h5> รายงานแบบบันทึกการตรวจพบข้อบกพร่อง : กลุ่มผลิตภัณฑ์สำเร็จรูป </h5>
        </div>

        <div class="ibox-content qm-content">

            <div class="qm-form justify-content-center clearfix">

                {!! Form::open(['route' => ['qm.finished-products.report-issue'], 'method' => 'get', 'autocomplete' => 'off', 'class' => 'form-horizontal']) !!}

                @include('qm.finished-products._report_issue_search_form')

                <hr style="border-color: rgba(0,0,0,.04);">

                <div class="row form-group text-center justify-content-center clearfix tw-my-6">

                    <div class="col-lg-4 col-md-6">
                        <button class="btn btn-lg btn-white tw-w-32" type="submit">
                            <i class="fa fa-search"></i> ค้นหา
                        </button>
                        <a type="button" href="{{ route('qm.finished-products.report-issue') }}"
                            class="btn btn-lg tw-bg-gray-100 tw-bg-opacity-60 btn-white tw-w-32 tw-ml-4">
                            <i class="fa fa-times"></i> ล้าง
                        </a>
                    </div>

                </div>

                {!! Form::close() !!}

                <hr class="tw-my-10" />

                @if ($searched)

                    <div class="text-right tw-mb-4">
                        {!! Form::open(['route' => ['qm.finished-products.export-pdf.report-issue'], 'method' => 'post']) !!}
                            <input type="hidden" name="search_inputs" value="{{ json_encode($searchInputs) }}" />
                            <input type="hidden" name="report_machine_sets" value="{{ json_encode($reportMachineSets) }}" />
                            <input type="hidden" name="report_qm_processes" value="{{ json_encode($reportQmProcesses) }}" />
                            <input type="hidden" name="report_qm_process_check_lists" value="{{ json_encode($reportQmProcessCheckLists) }}" />
                            <input type="hidden" name="report_items" value="{{ json_encode($reportItems) }}" />
                            <input type="hidden" name="sample_date_from" value="{{ old('sample_date_from') ? old('sample_date_from') : (isset($searchInputs['sample_date_from']) ? $searchInputs['sample_date_from'] : '') }}" />
                            <input type="hidden" name="sample_date_to" value="{{ old('sample_date_to') ? old('sample_date_to') : (isset($searchInputs['sample_date_to']) ? $searchInputs['sample_date_to'] : '') }}" />
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fa fa fa-file-pdf-o tw-mr-1"></i> Export PDF
                            </button>
                        {!! Form::close() !!}
                    </div>

                    <qm-table-finished-product-report-issue 
                        query-string-search-inputs="{{ http_build_query($searchInputs) }}"
                        :report-machine-sets="{{ json_encode($reportMachineSets) }}"
                        :report-qm-processes="{{ json_encode($reportQmProcesses) }}"
                        :report-qm-process-check-lists="{{ json_encode($reportQmProcessCheckLists) }}"
                        :report-items="{{ json_encode($reportItems) }}"
                    >
                    </qm-table-finished-product-report-issue>

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
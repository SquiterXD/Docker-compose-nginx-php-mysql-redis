@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2>
        <x-get-program-code url="/qm/qtm-machines/report-physical-value" /> สรุปรายงานค่าทางฟิสิกส์ ของบุหรี่ 
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
            สรุปรายงานค่าทางฟิสิกส์ ของบุหรี่ 
        </li>
    </ol>

@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h5> สรุปรายงานค่าทางฟิสิกส์ ของบุหรี่  </h5>
        </div>

        <div class="ibox-content qm-content">

            <div class="qm-form justify-content-center clearfix">

                {!! Form::open(['route' => ['qm.qtm-machines.report-physical-value'], 'method' => 'get', 'autocomplete' => 'off', 'class' => 'form-horizontal']) !!}

                @include('qm.qtm-machines._report_physical_value_search_form')

                <hr style="border-color: rgba(0,0,0,.04);">

                <div class="row form-group text-center justify-content-center clearfix tw-my-6">

                    <div class="col-lg-4 col-md-6">
                        <button class="btn btn-lg btn-white tw-w-32" type="submit">
                            <i class="fa fa-search"></i> ค้นหา
                        </button>
                        <a type="button" href="{{ route('qm.qtm-machines.report-physical-value') }}"
                            class="btn btn-lg tw-bg-gray-100 tw-bg-opacity-60 btn-white tw-w-32 tw-ml-4">
                            <i class="fa fa-times"></i> ล้าง
                        </a>
                    </div>

                </div>

                {!! Form::close() !!}

                <hr class="tw-my-10" />

                @if ($searched)

                    <div class="text-right tw-mb-4">
                        
                        {!! Form::open(['route' => ['qm.qtm-machines.export-pdf.report-physical-value'], 'method' => 'post']) !!}

                            <input type="hidden" name="report_machine_cig_weight_items" value="{{ json_encode($reportMachineCigWeightItems) }}" />
                            <input type="hidden" name="report_machine_cig_sizel_items" value="{{ json_encode($reportMachineCigSizeLItems) }}" />
                            <input type="hidden" name="report_machine_cig_pdopen_items" value="{{ json_encode($reportMachineCigPdOpenItems) }}" />
                            <input type="hidden" name="report_machine_cig_tipvent_items" value="{{ json_encode($reportMachineCigTipVentItems) }}" />
                            <input type="hidden" name="report_machine_filter_weight_items" value="{{ json_encode($reportMachineFilterWeightItems) }}" />
                            <input type="hidden" name="report_machine_filter_sizel_items" value="{{ json_encode($reportMachineFilterSizeLItems) }}" />
                            <input type="hidden" name="report_machine_filter_pdopen_items" value="{{ json_encode($reportMachineFilterPdOpenItems) }}" />
                            {{-- <input type="hidden" name="report_machine_filter_tipvent_items" value="{{ json_encode($reportMachineFilterTipVentItems) }}" /> --}}

                            <input type="hidden" name="report_summary_machine_cig_weight_item" value="{{ json_encode($reportSummaryMachineCigWeightItem) }}" />
                            <input type="hidden" name="report_summary_machine_cig_sizel_item" value="{{ json_encode($reportSummaryMachineCigSizeLItem) }}" />
                            <input type="hidden" name="report_summary_machine_cig_pdopen_item" value="{{ json_encode($reportSummaryMachineCigPdOpenItem) }}" />
                            <input type="hidden" name="report_summary_machine_cig_tipvent_item" value="{{ json_encode($reportSummaryMachineCigTipVentItem) }}" />
                            <input type="hidden" name="report_summary_machine_filter_weight_item" value="{{ json_encode($reportSummaryMachineFilterWeightItem) }}" />
                            <input type="hidden" name="report_summary_machine_filter_sizel_item" value="{{ json_encode($reportSummaryMachineFilterSizeLItem) }}" />
                            <input type="hidden" name="report_summary_machine_filter_pdopen_item" value="{{ json_encode($reportSummaryMachineFilterPdOpenItem) }}" />
                            {{-- <input type="hidden" name="report_summary_machine_filter_tipvent_item" value="{{ json_encode($reportSummaryMachineFilterTipVentItem) }}" /> --}}

                            <input type="hidden" name="sample_date_from" value="{{ old('sample_date_from') ? old('sample_date_from') : (isset($searchInputs['sample_date_from']) ? $searchInputs['sample_date_from'] : '') }}" />
                            <input type="hidden" name="sample_date_to" value="{{ old('sample_date_to') ? old('sample_date_to') : (isset($searchInputs['sample_date_to']) ? $searchInputs['sample_date_to'] : '') }}" />

                            <input type="hidden" name="task_type_code" value="{{ old('task_type_code') ? old('task_type_code') : (isset($searchInputs['task_type_code']) ? $searchInputs['task_type_code'] : '') }}" />

                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fa fa fa-file-pdf-o tw-mr-1"></i> Export PDF
                            </button>

                        {!! Form::close() !!}
                        
                    </div>

                    @if(isset($searchInputs['task_type_code']))

                        @if($searchInputs['task_type_code'] == "200" || $searchInputs['task_type_code'] == "")

                            {{-- CIG : WEIGHT --}}

                            <div class="tw-py-2">
                                <h3 class="text-center tw-pb-2"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_Weight (g) </h3>
                                <h4 class="text-center"> 
                                    <span> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }}  </span>
                                    <span class="tw-ml-4"> ประเภท : บุหรี่ </span>
                                </h4>
                            </div>
                            <qm-table-qtm-machine-report-physical-value 
                                report-type="WEIGHT"
                                :report-items="{{ json_encode($reportMachineCigWeightItems) }}"
                                :report-summary="{{ json_encode($reportSummaryMachineCigWeightItem) }}"
                            ></qm-table-qtm-machine-report-physical-value>

                            <hr>

                            {{-- CIG : SIZEL --}}
                            <div class="tw-py-2">
                                <h3 class="text-center tw-pb-2"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_SizeL (mm) </h3>
                                <h4 class="text-center"> 
                                    <span> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }}  </span>
                                    <span class="tw-ml-4"> ประเภท : บุหรี่ </span>
                                </h4>
                            </div>
                            <qm-table-qtm-machine-report-physical-value 
                                report-type="SIZEL"
                                :report-items="{{ json_encode($reportMachineCigSizeLItems) }}"
                                :report-summary="{{ json_encode($reportSummaryMachineCigSizeLItem) }}"
                            ></qm-table-qtm-machine-report-physical-value>

                            <hr>

                            {{-- CIG : PD OPEN --}}
                            <div class="tw-py-2">
                                <h3 class="text-center tw-pb-2"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_PD Open (mmWg) </h3>
                                <h4 class="text-center"> 
                                    <span> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }}  </span>
                                    <span class="tw-ml-4"> ประเภท : บุหรี่ </span>
                                </h4>
                            </div>
                            <qm-table-qtm-machine-report-physical-value 
                                report-type="PD_OPEN"
                                :report-items="{{ json_encode($reportMachineCigPdOpenItems) }}"
                                :report-summary="{{ json_encode($reportSummaryMachineCigPdOpenItem) }}"
                            ></qm-table-qtm-machine-report-physical-value>

                            <hr>

                            {{-- CIG : TIP VENT --}}
                            <div class="tw-py-2">
                                <h3 class="text-center tw-pb-2"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_Tip Vent (%) </h3>
                                <h4 class="text-center"> 
                                    <span> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }}  </span>
                                    <span class="tw-ml-4"> ประเภท : บุหรี่ </span>
                                </h4>
                            </div>
                            <qm-table-qtm-machine-report-physical-value 
                                report-type="TIP_VENT"
                                :report-items="{{ json_encode($reportMachineCigTipVentItems) }}"
                                :report-summary="{{ json_encode($reportSummaryMachineCigTipVentItem) }}"
                            ></qm-table-qtm-machine-report-physical-value>

                        @endif

                        <hr>

                        @if($searchInputs['task_type_code'] == "300" || $searchInputs['task_type_code'] == "")

                            {{-- FILTER : WEIGHT --}}
                            <div class="tw-py-2">
                                <h3 class="text-center tw-pb-2"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_Weight (g) </h3>
                                <h4 class="text-center"> 
                                    <span> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }}  </span>
                                    <span class="tw-ml-4"> ประเภท : ก้นกรอง </span>
                                </h4>
                            </div>
                            <qm-table-qtm-machine-report-physical-value 
                                report-type="WEIGHT"
                                :report-items="{{ json_encode($reportMachineFilterWeightItems) }}"
                                :report-summary="{{ json_encode($reportSummaryMachineFilterWeightItem) }}"
                            ></qm-table-qtm-machine-report-physical-value>

                            <hr>

                            {{-- FILTER : SIZEL --}}
                            <div class="tw-py-2">
                                <h3 class="text-center tw-pb-2"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_SizeL (mm) </h3>
                                <h4 class="text-center"> 
                                    <span> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }}  </span>
                                    <span class="tw-ml-4"> ประเภท : ก้นกรอง </span>
                                </h4>
                            </div>
                            <qm-table-qtm-machine-report-physical-value 
                                report-type="SIZEL"
                                :report-items="{{ json_encode($reportMachineFilterSizeLItems) }}"
                                :report-summary="{{ json_encode($reportSummaryMachineFilterSizeLItem) }}"
                            ></qm-table-qtm-machine-report-physical-value>

                            <hr>

                            {{-- FILTER : PD OPEN --}}
                            <div class="tw-py-2">
                                <h3 class="text-center tw-pb-2"> สรุปค่าสถิติทางฟิสิกส์ของบุหรี่/ก้นกรอง - QTM_PD Open (mmWg) </h3>
                                <h4 class="text-center"> 
                                    <span> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }}  </span>
                                    <span class="tw-ml-4"> ประเภท : ก้นกรอง </span>
                                </h4>
                            </div>
                            <qm-table-qtm-machine-report-physical-value 
                                report-type="PD_OPEN"
                                :report-items="{{ json_encode($reportMachineFilterPdOpenItems) }}"
                                :report-summary="{{ json_encode($reportSummaryMachineFilterPdOpenItem) }}"
                            ></qm-table-qtm-machine-report-physical-value>

                        @endif

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
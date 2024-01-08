@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2>
        <x-get-program-code url="/qm/packet-air-leaks/report-leak-rate" /> รายงานผลการตรวจวัดอัตรารั่วของฟิล์มห่อซองบุหรี่ ( PP film ) โดยเครื่องมือวัด
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
            รายงานผลการตรวจวัดอัตรารั่วของฟิล์มห่อซองบุหรี่ ( PP film ) โดยเครื่องมือวัด
        </li>
    </ol>

@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h5> รายงานผลการตรวจวัดอัตรารั่วของฟิล์มห่อซองบุหรี่ ( PP film ) โดยเครื่องมือวัด </h5>
        </div>

        <div class="ibox-content qm-content">

            <div class="qm-form justify-content-center clearfix">

                {!! Form::open(['route' => ['qm.packet-air-leaks.report-leak-rate'], 'method' => 'get', 'autocomplete' => 'off', 'class' => 'form-horizontal']) !!}

                @include('qm.packet-air-leaks._report_leak_rate_search_form')

                <hr style="border-color: rgba(0,0,0,.04);">

                <div class="row form-group text-center justify-content-center clearfix tw-my-6">

                    <div class="col-lg-4 col-md-6">
                        <button class="btn btn-lg btn-white tw-w-32" type="submit">
                            <i class="fa fa-search"></i> ค้นหา
                        </button>
                        <a type="button" href="{{ route('qm.packet-air-leaks.report-leak-rate') }}"
                            class="btn btn-lg tw-bg-gray-100 tw-bg-opacity-60 btn-white tw-w-32 tw-ml-4">
                            <i class="fa fa-times"></i> ล้าง
                        </a>
                    </div>

                </div>

                {!! Form::close() !!}

                <hr class="tw-my-10" />

                @if ($searched)

                    @if(count($reportItemByDates) > 0)

                        <div class="text-right tw-mb-4">

                            <div class="tw-inline-block">
                                {!! Form::open(['route' => ['qm.packet-air-leaks.export-excel.report-leak-rate'], 'method' => 'post']) !!}
                                    <input type="hidden" name="sample_date_from" value="{{ old('sample_date_from') ? old('sample_date_from') : (isset($searchInputs['sample_date_from']) ? $searchInputs['sample_date_from'] : '') }}" />
                                    <input type="hidden" name="sample_date_to" value="{{ old('sample_date_to') ? old('sample_date_to') : (isset($searchInputs['sample_date_to']) ? $searchInputs['sample_date_to'] : '') }}" />
                                    <input type="hidden" name="report_item_by_dates" value="{{ json_encode($reportItemByDates) }}" />
                                    <input type="hidden" name="sample_date_from" value="{{ old('sample_date_from') ? old('sample_date_from') : (isset($searchInputs['sample_date_from']) ? $searchInputs['sample_date_from'] : '') }}" />
                                    <input type="hidden" name="sample_date_to" value="{{ old('sample_date_to') ? old('sample_date_to') : (isset($searchInputs['sample_date_to']) ? $searchInputs['sample_date_to'] : '') }}" />
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa fa fa-file-excel-o tw-mr-1"></i> Export Excel
                                    </button>
                                {!! Form::close() !!}

                            </div>

                            <div class="tw-inline-block">
                        
                                {!! Form::open(['route' => ['qm.packet-air-leaks.export-pdf.report-leak-rate'], 'method' => 'post', 'target' => '_blank']) !!}
                                    <input type="hidden" name="report_item_by_dates" value="{{ json_encode($reportItemByDates) }}" />
                                    <input type="hidden" name="sample_date_from" value="{{ old('sample_date_from') ? old('sample_date_from') : (isset($searchInputs['sample_date_from']) ? $searchInputs['sample_date_from'] : '') }}" />
                                    <input type="hidden" name="sample_date_to" value="{{ old('sample_date_to') ? old('sample_date_to') : (isset($searchInputs['sample_date_to']) ? $searchInputs['sample_date_to'] : '') }}" />
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fa fa fa-file-pdf-o tw-mr-1"></i> Export PDF
                                    </button>
                                {!! Form::close() !!}

                            </div>

                        </div>

                    @endif

                    <qm-table-packet-air-leak-report-leak-rate 
                        :report-items="{{  json_encode($reportItems) }}"
                        :report-item-by-dates="{{  json_encode($reportItemByDates) }}"
                        >
                    </qm-table-packet-air-leak-report-leak-rate>

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
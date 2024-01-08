@extends('layouts.app')

@section('title', 'ประมาณการกำลังผลิตประจำปักษ์')

@section('page-title')
    <h2> <x-get-program-code url="/planning/machine-biweekly"/>: ประมาณการกำลังผลิตประจำปักษ์</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>ประมาณการผลิตประจำปักษ์</a>
        </li>
        <li class="breadcrumb-item active">
            <a>ประมาณการกำลังผลิตประจำปักษ์</a>
        </li>
    </ol>
@stop
@section('page-title-action')
    <button class="btn-lg tw-w-25 {{ trans('btn.create.class') }}" data-toggle="modal" data-target="#modal-create" data-backdrop="static" data-keyboard="false">
        <i class="{{ trans('btn.create.icon') }}"></i> {{ trans('btn.create.text') }}
    </button>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content pt-1">
                    <search-machine-biweekly-component
                        :header="{{ json_encode($header) }}"
                        :lines="{{ json_encode($lines) }}"
                        :res-plan-date="{{ json_encode($resPlanDate) }}"

                        :working-hour="{{ json_encode($workingHour) }}"
                        :working-holiday="{{ json_encode($workingHoliday) }}"
                        :product-types="{{ json_encode($productTypes) }}"
                        :default-input="{{ json_encode($defaultInput) }}"
                        :search-input="{{ json_encode($searchInput) }}"
                        :budget-years="{{ json_encode($budgetYears) }}"
                        :search="{{ json_encode($search) }}"
                        :bi-weekly-details="{{ json_encode($biWeeklyDetails) }}"

                        :eamperformance-machines="{{ json_encode($eamperformanceMachines) }}"
                        :efficiency-machines="{{ json_encode($efficiencyMachines) }}"
                        :efficiency-products="{{ json_encode($efficiencyProducts) }}"
                        :machine-maintenances="{{ json_encode($machineMaintenances) }}"
                        :machine-downtimes="{{ json_encode($machineDowntimes) }}"
                        :machine-dt-lines="{{ json_encode($machineDtLines) }}"
                        :machine-groups="{{ json_encode($machineGroups) }}"
                        :machine-desc="{{ json_encode($machineDesc) }}"
                        :holidays="{{ json_encode($holidays) }}"
                        :sale-forecasts-html="{{ json_encode($saleForecastsHtml) }}"
                        :p-sale-forecasts="{{ json_encode($saleForecasts) }}"

                        date-format="{{ trans('date.format-month-pp') }}"
                        :btn-trans="{{ json_encode($btnTrans) }}"
                        :url="{{ json_encode($url) }}"

                        {{-- New Requirement 20112021 --}}
                        :efficiency-full-products="{{ json_encode($efficiencyFullProducts) }}"
                        :version-lists="{{ json_encode($versions) }}"
                        :holidays-html="{{ json_encode($holidaysHtml) }}"
                        :last-update="{{ json_encode($lastUpdateFormat) }}"
                    >
                    </search-machine-biweekly-component>
                    @include('planning.machine-biweekly._create_machine_modal')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('planning.machine-biweekly._script')
    <script type="text/javascript">
        // setTimeout( function() {
        //     var body = $('body');
        //     if (body.hasClass('fixed-sidebar')) {
        //         if (!body.hasClass('body-small')) {
        //             body.addClass('mini-navbar');
        //         }
        //     } else {
        //         if (!body.hasClass('body-small')) {
        //             body.addClass('mini-navbar');
        //         }
        //     }
        // },500)
    </script>
@stop
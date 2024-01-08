@extends('layouts.app')

@section('title', 'ประมาณการผลิตรายวัน')

@section('page-title')
    <h2>
        <x-get-program-code url="/planning/production-daily/-1" />: ประมาณการผลิตรายวัน
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>ประมาณการผลิตประจำปักษ์</a>
        </li>
        <li class="breadcrumb-item active">
            <a>ประมาณการผลิตรายวัน</a>
        </li>
    </ol>
@stop
@section('page-title-action')
    <planning-production-daily-create
        :budget-years="{{ json_encode($modalSearchInput->budget_years) }}"
        :months="{{ json_encode($modalSearchInput->months) }}"
        :bi-weekly="{{ json_encode($modalSearchInput->bi_weekly) }}"
        :default-input="{{ json_encode($defaultInput) }}"
        :url="{{ json_encode($url) }}"
        :btn-trans="{{ json_encode($btnTrans) }}"
    />
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content pt-1">
                    <planning-production-daily-show
                        :modal-control-input="{{ json_encode($modalControlInput) }}"
                        :modal-search-input="{{ json_encode($modalSearchInput) }}"
                        :biweekly-color-code="{{ json_encode($biweeklyColorCode) }}"
                        {{-- :product-biweekly-main="{{ json_encode($productBiweekly) }}" --}}
                        :machine-biweekly="{{ json_encode($machineBiweekly) }}"
                        :product-types="{{ json_encode($productTypes) }}"
                        :p-default-input="{{ json_encode($defaultInput) }}"
                        :product-daily-plan="{{ json_encode($productDailyPlan) }}"
                        p-date-format="{{ trans('date.format-month-pp') }}"
                        :url="{{ json_encode($url) }}"
                        :btn-trans="{{ json_encode($btnTrans) }}"
                        :search="{{ json_encode($search) }}"
                        :bi-weekly-details="{{ json_encode($biWeeklyDetails) }}"
                        :search-flag="{{ json_encode($searchFlag) }}"
                        :machines="{{ json_encode($machines) }}"
                        :versions="{{ json_encode($versions) }}"
                    >
                    </planning-production-daily-show>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
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
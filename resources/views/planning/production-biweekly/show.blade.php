@extends('layouts.app')

@section('title', 'ประมาณการแผนรายปักษ์')

@section('page-title')
    <h2>
        <x-get-program-code url="/planning/production-biweekly/-1" />: ประมาณการผลิตประจำปักษ์
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>ประมาณการผลิตประจำปักษ์</a>
        </li>
        <li class="breadcrumb-item active">
            <a>ประมาณการผลิตประจำปักษ์</a>
        </li>
    </ol>
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content pt-1">
                    <planning-production-biweekly-show
                        {{-- Create --}}
                        :modal-create-input="{{ json_encode($modalCreateInput) }}"
                        {{-- Search --}}
                        :modal-search-input="{{ json_encode($modalSearchInput) }}"
                        :machine-efficiency-prod="{{ json_encode($machineEfficiencyProd) }}"

                        :biweekly-color-code="{{ json_encode($biweeklyColorCode) }}"

                        p-date-format="{{ trans('date.js-format') }}"
                        :prod-biweekly-main="{{ json_encode($prodBiweekly) }}"
                        :product-types="{{ json_encode($productTypes) }}"

                        :pp-bi-weekly="{{ json_encode($ppBiWeekly) }}"
                        :working-hour="{{ json_encode($workingHour) }}"

                        :om-biweekly-list="{{ json_encode($omBiweeklyList) }}"
                        :cal-types="{{ json_encode($calTypes) }}"
                        cal-type-default="{{ $calTypeDefault }}"

                        :p-default-input="{{ json_encode($defaultInput) }}"
                        :url="{{ json_encode($url) }}"
                        :btn-trans="{{ json_encode($btnTrans) }}"
                    >
                    </planning-production-biweekly-show>
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
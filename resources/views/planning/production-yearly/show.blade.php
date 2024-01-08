@extends('layouts.app')

@section('title', 'ประมาณการผลิตบุหรี่และก้นกรองประจำปี')

@section('page-title')
    {{-- <x-get-page-title menu="" url="/planning/production-yearly/-1"/> --}}
    <h2>
        <x-get-program-code url="/planning/production-yearly/-1" />: ประมาณการผลิตบุหรี่และก้นกรองประจำปี
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>ประมาณการผลิตประจำปี</a>
        </li>
        <li class="breadcrumb-item active">
            <a>ประมาณการผลิตบุหรี่และก้นกรองประจำปี</a>
        </li>
    </ol>
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content pt-1">
                    <planning-production-yearly-show
                        {{-- Create --}}
                        :modal-create-input="{{ json_encode($modalCreateInput) }}"
                        {{-- Search --}}
                        :modal-search-input="{{ json_encode($modalSearchInput) }}"
                        :prod-yearly="{{ json_encode($prodYearly) }}"
                        :machine-efficiency-prod="{{ json_encode($machineEfficiencyProd) }}"
                        :yearly-color-code="{{ json_encode($yearlyColorCode) }}"
                        p-date-format="{{ trans('date.js-format') }}"
                        :product-types="{{ json_encode($productTypes) }}"
                        :working-hour="{{ json_encode($workingHour) }}"
                        :p-default-input="{{ json_encode($defaultInput) }}"
                        :btn-trans="{{ json_encode($btnTrans) }}"
                        :url="{{ json_encode($url) }}"

                        {{-- :pp-bi-weekly="{{ json_encode($ppBiWeekly) }}" --}}
                        {{-- cal-type-default="{{ $calTypeDefault }}" --}}
                        {{-- :om-yearly-list="{{ json_encode($omBiweeklyList) }}" --}}
                        {{-- :cal-types="{{ json_encode($calTypes) }}" --}}
                    >
                    </planning-production-yearly-show>
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
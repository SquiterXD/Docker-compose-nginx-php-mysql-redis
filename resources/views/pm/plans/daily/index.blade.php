@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2> <x-get-program-code url="/pm/plans/daily" /> วางแผนผลิตสิ่งพิมพ์รายวัน </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">PM</a>
        </li>
        <li class="breadcrumb-item">
            วางแผนผลิตสิ่งพิมพ์รายวัน
        </li>
    </ol>

@stop

@section('content')

    <pm-plans-daily-index 
        period-year-value="{{ isset($searchInputs['period_year']) ? $searchInputs['period_year'] : '' }}"
        period-name-value="{{ isset($searchInputs['period_name']) ? $searchInputs['period_name'] : '' }}"
        biweekly-value="{{ isset($searchInputs['biweekly']) ? $searchInputs['biweekly'] : '' }}"
        weekly-value="{{ isset($searchInputs['weekly']) ? $searchInputs['weekly'] : '' }}"
        print-type-value="{{ isset($searchInputs['print_type']) ? $searchInputs['print_type'] : '' }}"
        sale-type-value="{{ isset($searchInputs['sale_type']) ? $searchInputs['sale_type'] : '' }}"
        source-version-value="{{ isset($searchInputs['source_version']) ? $searchInputs['source_version'] : '' }}"
        :period-years="{{ json_encode($periodYears) }}"
        :plan-statuses="{{ json_encode($planStatuses) }}"
        :print-types="{{ json_encode($printTypes) }}"
        :sale-types="{{ json_encode($saleTypes) }}"
        :uom-codes="{{ json_encode($uomCodes) }}"
        :machines="{{ json_encode($machines) }}"
        :machine-powers="{{ json_encode($machinePowers) }}"
        :machine-times="{{ json_encode($machineTimes) }}"
        :assets="{{ json_encode($assets) }}"
    />

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
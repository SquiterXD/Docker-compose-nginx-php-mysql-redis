@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2> <x-get-program-code url="/pm/plans/biweekly" /> วางแผนผลิตสิ่งพิมพ์รายปักษ์ </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">PM</a>
        </li>
        <li class="breadcrumb-item">
            วางแผนผลิตสิ่งพิมพ์รายปักษ์
        </li>
    </ol>

@stop

@section('content')

    <pm-plans-biweekly-index 
        period-year-value="{{ isset($searchInputs['period_year']) ? $searchInputs['period_year'] : '' }}"
        period-name-value="{{ isset($searchInputs['period_name']) ? $searchInputs['period_name'] : '' }}"
        biweekly-value="{{ isset($searchInputs['biweekly']) ? $searchInputs['biweekly'] : '' }}"
        print-type-value="{{ isset($searchInputs['print_type']) ? $searchInputs['print_type'] : '' }}"
        sale-type-value="{{ isset($searchInputs['sale_type']) ? $searchInputs['sale_type'] : '' }}"
        source-version-value="{{ isset($searchInputs['source_version']) ? $searchInputs['source_version'] : '' }}"
        :period-years="{{ json_encode($periodYears) }}"
        :plan-statuses="{{ json_encode($planStatuses) }}"
        :print-types="{{ json_encode($printTypes) }}"
        :sale-types="{{ json_encode($saleTypes) }}"
        :uom-codes="{{ json_encode($uomCodes) }}"
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
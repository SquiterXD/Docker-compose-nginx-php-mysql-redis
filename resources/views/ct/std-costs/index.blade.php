@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2> <x-get-program-code url="/ct/std-costs" /> ต้นทุนมาตรฐานค่าแรงและค่าใช้จ่ายการผลิต </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">CT</a>
        </li>
        <li class="breadcrumb-item">
            ต้นทุนมาตรฐานค่าแรงและค่าใช้จ่ายการผลิต
        </li>
    </ol>

@stop

@section('content')

    <ct-std-costs-index
        default-data="{{ json_encode($defaultData) }}"
        period-year-value="{{ isset($searchInputs['period_year']) ? $searchInputs['period_year'] : '' }}"
        prdgrp-year-id-value="{{ isset($searchInputs['prdgrp_year_id']) ? $searchInputs['prdgrp_year_id'] : '' }}"
        allocate-account-version-value="{{ isset($searchInputs['allocate_account_version']) ? $searchInputs['allocate_account_version'] : '' }}"
        allocate-year-id-value="{{ isset($searchInputs['allocate_year_id']) ? $searchInputs['allocate_year_id'] : '' }}"
        {{-- allocate-group-value="{{ isset($searchInputs['allocate_group']) ? $searchInputs['allocate_group'] : '' }}" --}}
        dept-code-value="{{ isset($searchInputs['dept_code']) ? $searchInputs['dept_code'] : '' }}"
        period-name-from-value="{{ isset($searchInputs['period_name_from']) ? $searchInputs['period_name_from'] : '' }}"
        period-name-to-value="{{ isset($searchInputs['period_name_to']) ? $searchInputs['period_name_to'] : '' }}"
        :period-years="{{ json_encode($periodYears) }}" 
        :exist-period-years="{{ json_encode($existPeriodYears) }}" 
        :list-allocate-groups="{{ json_encode($listAllocateGroups) }}" 
        :allocate-types="{{ json_encode($allocateTypes) }}" 
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
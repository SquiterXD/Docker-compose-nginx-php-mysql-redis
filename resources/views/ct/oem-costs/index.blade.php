@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2> <x-get-program-code url="/ct/oem-costs" /> ต้นทุนมาตรฐานค่าแรงและค่าใช้จ่าย-รับจ้างผลิต </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">CT</a>
        </li>
        <li class="breadcrumb-item">
            ต้นทุนมาตรฐานค่าแรงและค่าใช้จ่าย-รับจ้างผลิต
        </li>
    </ol>

@stop

@section('content')

    <ct-oem-costs-index
        default-data="{{ json_encode($defaultData) }}"
        period-year-value="{{ isset($searchInputs['period_year']) ? $searchInputs['period_year'] : '' }}"
        prdgrp-year-id-value="{{ isset($searchInputs['prdgrp_year_id']) ? $searchInputs['prdgrp_year_id'] : '' }}"
        ct14-version-no-value="{{ isset($searchInputs['ct14_version_no']) ? $searchInputs['ct14_version_no'] : '' }}"
        cost-code-value="{{ isset($searchInputs['cost_code']) ? $searchInputs['cost_code'] : '' }}"
        product-group-value="{{ isset($searchInputs['product_group']) ? $searchInputs['product_group'] : '' }}"
        product-item-value="{{ isset($searchInputs['product_inventory_item_id']) ? $searchInputs['product_inventory_item_id'] : '' }}"
        product-quantity-value="{{ isset($searchInputs['product_quantity']) ? $searchInputs['product_quantity'] : '' }}"
        :period-years="{{ json_encode($periodYears) }}" 
        :prdgrp-plans="{{ json_encode($prdgrpPlans) }}" 
        :ct14-version-nos="{{ json_encode($ct14VersionNos) }}" 
        :exist-period-years="{{ json_encode($existPeriodYears) }}" 
        :cost-centers="{{ json_encode($costCenters) }}" 
        :product-groups="{{ json_encode($productGroups) }}" 
        :product-items="{{ json_encode($productItems) }}" 
        :account-codes="{{ json_encode($accountCodes) }}"
        :sub-account-codes="{{ json_encode($subAccountCodes) }}"
        :account-types="{{ json_encode($accountTypes) }}"
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
@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2> <x-get-program-code url="/pm/plans/approvals/yearly" /> อนุมัติประมาณการวัตถุดิบประจำปี </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">PM</a>
        </li>
        <li class="breadcrumb-item">
            อนุมัติประมาณการวัตถุดิบประจำปี
        </li>
    </ol>

@stop

@section('content')

    <pm-plans-approvals-yearly-index 
        default-data="{{ json_encode($defaultData) }}"
        period-year-value="{{ isset($searchInputs['period_year']) ? $searchInputs['period_year'] : '' }}"
        print-type-value="{{ isset($searchInputs['print_type']) ? $searchInputs['print_type'] : '' }}"
        sale-type-value="{{ isset($searchInputs['sale_type']) ? $searchInputs['sale_type'] : '' }}"
        source-version-value="{{ isset($searchInputs['source_version']) ? $searchInputs['source_version'] : '' }}"
        yearly-plan-version-value="{{ isset($searchInputs['yearly_plan_version']) ? $searchInputs['yearly_plan_version'] : '' }}"
        :period-years="{{ json_encode($periodYears) }}" 
        :item-options="{{ json_encode($itemOptions) }}"
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
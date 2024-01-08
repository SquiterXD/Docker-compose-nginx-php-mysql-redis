@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2> <x-get-program-code url="/ct/std-cost-inquiries" /> สอบถามราคาต้นทุนมาตรฐาน INVENTORY </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">CT</a>
        </li>
        <li class="breadcrumb-item">
            สอบถามราคาต้นทุนมาตรฐาน INVENTORY
        </li>
    </ol>

@stop

@section('content')

    <ct-std-cost-inquiries-index
        default-data="{{ json_encode($defaultData) }}"
        period-year-value="{{ isset($searchInputs['period_year']) ? $searchInputs['period_year'] : '' }}"
        version-no-value="{{ isset($searchInputs['version_no']) ? $searchInputs['version_no'] : '' }}"
        cost-code-value="{{ isset($searchInputs['cost_code']) ? $searchInputs['cost_code'] : '' }}"
        inventory-item-id-value="{{ isset($searchInputs['inventory_item_id']) ? $searchInputs['inventory_item_id'] : '' }}"
        status-cost-value="{{ isset($searchInputs['status_cost']) ? $searchInputs['status_cost'] : '' }}"
        :period-years="{{ json_encode($periodYears) }}" 
        :version-nos="{{ json_encode($versionNos) }}" 
        :cost-codes="{{ json_encode($costCodes) }}" 
        :inventory-items="{{ json_encode($inventoryItems) }}" 
        :status-costs="{{ json_encode($statusCosts) }}" 
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
@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2> <x-get-program-code url="/ct/allocate-ratios" /> กำหนดเกณฑ์การปันส่วน </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">CT</a>
        </li>
        <li class="breadcrumb-item">
            กำหนดเกณฑ์การปันส่วน
        </li>
    </ol>

@stop

@section('content')

    <ct-allocate-ratios-index
        default-data="{{ json_encode($defaultData) }}"
        period-year-value="{{ isset($searchInputs['period_year']) ? $searchInputs['period_year'] : '' }}"
        allocate-group-value="{{ isset($searchInputs['allocate_group']) ? $searchInputs['allocate_group'] : '' }}"
        allocate-type-value="{{ isset($searchInputs['allocate_type']) ? $searchInputs['allocate_type'] : '' }}"
        transfer-account-code-value="{{ isset($searchInputs['transfer_account_code']) ? $searchInputs['transfer_account_code'] : '' }}"
        dept-code-value="{{ isset($searchInputs['dept_code']) ? $searchInputs['dept_code'] : '' }}"
        cost-code-value="{{ isset($searchInputs['cost_code']) ? $searchInputs['cost_code'] : '' }}"
        version-value="{{ isset($searchInputs['version']) ? $searchInputs['version'] : '' }}"
        :period-years="{{ json_encode($periodYears) }}" 
        :exist-period-years="{{ json_encode($existPeriodYears) }}" 
        :list-allocate-groups="{{ json_encode($listAllocateGroups) }}" 
        :allocate-types="{{ json_encode($allocateTypes) }}" 
        :account-codes="{{ json_encode($accountCodes) }}" 
        :exist-account-codes="{{ json_encode($existAccountCodes) }}" 
        :approve-statuses="{{ json_encode($approveStatuses) }}"
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
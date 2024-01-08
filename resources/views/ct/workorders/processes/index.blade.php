@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2> <x-get-program-code url="/ct/workorders/processes" /> ประมวลผลข้อมูลคำสั่งผลิต </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">CT</a>
        </li>
        <li class="breadcrumb-item">
            ประมวลผลข้อมูลคำสั่งผลิต
        </li>
    </ol>

@stop

@section('content')

    <ct-workorders-processes-index
        default-data="{{ json_encode($defaultData) }}"
        param-id-value="{{ isset($searchInputs['param_id']) ? $searchInputs['param_id'] : '' }}"
        {{-- process-step-value="{{ isset($searchInputs['process_step']) ? $searchInputs['process_step'] : '' }}" --}}
        period-year-value="{{ isset($searchInputs['period_year']) ? $searchInputs['period_year'] : $defaultPeriodYear }}"
        period-name-value="{{ isset($searchInputs['period_name']) ? $searchInputs['period_name'] : '' }}"
        cost-code-value="{{ isset($searchInputs['cost_code']) ? $searchInputs['cost_code'] : '' }}"
        dept-code-from-value="{{ isset($searchInputs['dept_code_from']) ? $searchInputs['dept_code_from'] : '' }}"
        dept-code-to-value="{{ isset($searchInputs['dept_code_to']) ? $searchInputs['dept_code_to'] : '' }}"
        batch-no-from-value="{{ isset($searchInputs['batch_no_from']) ? $searchInputs['batch_no_from'] : '' }}"
        batch-no-to-value="{{ isset($searchInputs['batch_no_to']) ? $searchInputs['batch_no_to'] : '' }}"
        process-status-value="{{ isset($searchInputs['process_status']) ? $searchInputs['process_status'] : '' }}"
        posting-status-value="{{ isset($searchInputs['posting_status']) ? $searchInputs['posting_status'] : '' }}"
        {{-- :process-steps="{{ json_encode($processSteps) }}" --}}
        :period-years="{{ json_encode($periodYears) }}" 
        :process-statuses="{{ json_encode($processStatuses) }}"
        :posting-statuses="{{ json_encode($postingStatuses) }}"
        :cost-centers="{{ json_encode($costCenters) }}"
        {{-- :batch-numbers="{{ json_encode($batchNumbers) }}" --}}
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
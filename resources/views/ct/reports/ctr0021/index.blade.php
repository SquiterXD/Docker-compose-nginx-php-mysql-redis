@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2>
        <x-get-program-code url="/ct/ctr0021" /> รายงานกระดาษทำการปันส่วนของหน่วยงานให้ศูนย์ต้นทุน
    </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">CT</a>
        </li>
        <li class="breadcrumb-item">
            รายงานกระดาษทำการปันส่วนของหน่วยงานให้ศูนย์ต้นทุน
        </li>
    </ol>

@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h5> รายงานกระดาษทำการปันส่วนของหน่วยงานให้ศูนย์ต้นทุน </h5>
        </div>

        <div class="ibox-content">

            <div class="justify-content-center clearfix">

                <div class="clearfix tw-my-6">

                    {!! Form::open(['route' => ['ct.ctr0021.export'], 'method' => 'post']) !!}

                        {{-- FORM INPUT --}}

                        <ct-reports-ctr0021-form 
                            :period-years="{{ json_encode($periodYears) }}"
                            :version-nos="{{ json_encode($stdCostVersions) }}"
                            :plan-version-nos="{{ json_encode($stdCostPlanVersions) }}"
                            :period-name-froms="{{ json_encode($periodNameFroms) }}"
                            :period-name-tos="{{ json_encode($periodNameTos) }}"
                            :account-types="{{ json_encode($accountTypes) }}"
                            :allocate-group-codes="{{ json_encode($allocateGroupCodes) }}"
                            period-year-value="{{ old('period_year') ? old('period_year') : (isset($searchInputs['period_year']) ? $searchInputs['period_year'] : '') }}"
                            version-no-value="{{ old('version_no') ? old('version_no') : (isset($searchInputs['version_no']) ? $searchInputs['version_no'] : '') }}"
                            plan-version-no-value="{{ old('plan_version_no') ? old('plan_version_no') : (isset($searchInputs['plan_version_no']) ? $searchInputs['plan_version_no'] : '') }}"
                            period-name-from-value="{{ old('period_name_from') ? old('period_name_from') : (isset($searchInputs['period_name_from']) ? $searchInputs['period_name_from'] : '') }}"
                            period-name-to-value="{{ old('period_name_to') ? old('period_name_to') : (isset($searchInputs['period_name_to']) ? $searchInputs['period_name_to'] : '') }}"
                            account-type-value="{{ old('account_type') ? old('account_type') : (isset($searchInputs['account_type']) ? $searchInputs['account_type'] : '') }}"
                            allocate-group-code-value="{{ old('allocate_group_code') ? old('allocate_group_code') : (isset($searchInputs['allocate_group_code']) ? $searchInputs['allocate_group_code'] : '') }}"
                        >
                        </ct-reports-ctr0021-form>

                    {!! Form::close() !!}

                </div>

            </div>

        </div>

    </div>

@endsection
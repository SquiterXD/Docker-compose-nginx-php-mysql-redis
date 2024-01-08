@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2>
        <x-get-program-code url="/ct/ctr0022" /> รายงานกระดาษทำการปันส่วนของศูนย์ต้นทุนให้กลุ่มผลิตภัณฑ์
    </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">CT</a>
        </li>
        <li class="breadcrumb-item">
            รายงานกระดาษทำการปันส่วนของศูนย์ต้นทุนให้กลุ่มผลิตภัณฑ์
        </li>
    </ol>

@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h5> รายงานกระดาษทำการปันส่วนของศูนย์ต้นทุนให้กลุ่มผลิตภัณฑ์ </h5>
        </div>

        <div class="ibox-content">

            <div class="justify-content-center clearfix">

                <div class="clearfix tw-my-6">

                    {!! Form::open(['route' => ['ct.ctr0022.export'], 'method' => 'post']) !!}

                        {{-- FORM INPUT --}}

                        <ct-reports-ctr0022-form 
                            :period-years="{{ json_encode($periodYears) }}"
                            :version-nos="{{ json_encode($paperVersions) }}"
                            :ct14-version-nos="{{ json_encode($paperCt14Versions) }}"
                            :plan-version-nos="{{ json_encode($paperPlanVersions) }}"
                            :cost-codes="{{ json_encode($paperCostCodes) }}"
                            :account-types="{{ json_encode($accountTypes) }}"
                            period-year-value="{{ old('period_year') ? old('period_year') : (isset($searchInputs['period_year']) ? $searchInputs['period_year'] : '') }}"
                            version-no-value="{{ old('version_no') ? old('version_no') : (isset($searchInputs['version_no']) ? $searchInputs['version_no'] : '') }}"
                            ct14-version-no-value="{{ old('ct14_version_no') ? old('ct14_version_no') : (isset($searchInputs['ct14_version_no']) ? $searchInputs['ct14_version_no'] : '') }}"
                            plan-version-no-value="{{ old('plan_version_no') ? old('plan_version_no') : (isset($searchInputs['plan_version_no']) ? $searchInputs['plan_version_no'] : '') }}"
                            cost-code-from-value="{{ old('cost_code_from') ? old('cost_code_from') : (isset($searchInputs['cost_code_from']) ? $searchInputs['cost_code_from'] : '') }}"
                            cost-code-to-value="{{ old('cost_code_to') ? old('cost_code_to') : (isset($searchInputs['cost_code_to']) ? $searchInputs['cost_code_to'] : '') }}"
                            account-type-value="{{ old('account_type') ? old('account_type') : (isset($searchInputs['account_type']) ? $searchInputs['account_type'] : '') }}"
                        >
                        </ct-reports-ctr0022-form>

                    {!! Form::close() !!}

                </div>

            </div>

        </div>

    </div>

@endsection
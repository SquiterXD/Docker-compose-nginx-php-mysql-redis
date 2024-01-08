@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2>
        <x-get-program-code url="/ct/ctr0026" /> รายงานอัตรามาตรฐาน
    </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">CT</a>
        </li>
        <li class="breadcrumb-item">
            รายงานอัตรามาตรฐาน
        </li>
    </ol>

@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h5> รายงานอัตรามาตรฐาน </h5>
        </div>

        <div class="ibox-content">

            <div class="justify-content-center clearfix">

                <div class="clearfix tw-my-6">

                    {!! Form::open(['route' => ['ct.ctr0026.export'], 'method' => 'post']) !!}

                        {{-- FORM INPUT --}}

                        <ct-reports-ctr0026-form 
                            :period-years="{{ json_encode($periodYears) }}"
                            :version-nos="{{ json_encode($paperVersions) }}"
                            :plan-version-nos="{{ json_encode($paperPlanVersions) }}"
                            :cost-codes="{{ json_encode($paperCostCodes) }}"
                            period-year-value="{{ old('period_year') ? old('period_year') : (isset($searchInputs['period_year']) ? $searchInputs['period_year'] : '') }}"
                            version-no-value="{{ old('ct14_version_no') ? old('ct14_version_no') : (isset($searchInputs['ct14_version_no']) ? $searchInputs['ct14_version_no'] : '') }}"
                            plan-version-no-value="{{ old('plan_version_no') ? old('plan_version_no') : (isset($searchInputs['plan_version_no']) ? $searchInputs['plan_version_no'] : '') }}"
                            cost-code-from-value="{{ old('cost_code_from') ? old('cost_code_from') : (isset($searchInputs['cost_code_from']) ? $searchInputs['cost_code_from'] : '') }}"
                            cost-code-to-value="{{ old('cost_code_to') ? old('cost_code_to') : (isset($searchInputs['cost_code_to']) ? $searchInputs['cost_code_to'] : '') }}"
                        >
                        </ct-reports-ctr0026-form>

                    {!! Form::close() !!}

                </div>

            </div>

        </div>

    </div>

@endsection
@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2>
        <x-get-program-code url="/ct/ctr0023" /> รายงานกระดาษทำการต้นทุนวัตถุดิบมาตรฐาน
    </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">CT</a>
        </li>
        <li class="breadcrumb-item">
            รายงานกระดาษทำการต้นทุนวัตถุดิบมาตรฐาน
        </li>
    </ol>

@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h5> รายงานกระดาษทำการต้นทุนวัตถุดิบมาตรฐาน </h5>
        </div>

        <div class="ibox-content">

            <div class="justify-content-center clearfix">

                <div class="clearfix tw-my-6">

                    {!! Form::open(['route' => ['ct.ctr0023.export'], 'method' => 'post']) !!}

                        {{-- FORM INPUT --}}

                        <ct-reports-ctr0023-form 
                            :period-years="{{ json_encode($periodYears) }}"
                            :version-nos="{{ json_encode($paperVersions) }}"
                            :plan-version-nos="{{ json_encode($paperPlanVersions) }}"
                            :cost-codes="{{ json_encode($paperCostCodes) }}"
                            :product-items="{{ json_encode($paperProductItems) }}"
                            period-year-value="{{ old('period_year') ? old('period_year') : (isset($searchInputs['period_year']) ? $searchInputs['period_year'] : '') }}"
                            version-no-value="{{ old('version_no') ? old('version_no') : (isset($searchInputs['version_no']) ? $searchInputs['version_no'] : '') }}"
                            plan-version-no-value="{{ old('plan_version_no') ? old('plan_version_no') : (isset($searchInputs['plan_version_no']) ? $searchInputs['plan_version_no'] : '') }}"
                            cost-code-value="{{ old('cost_code') ? old('cost_code') : (isset($searchInputs['cost_code']) ? $searchInputs['cost_code'] : '') }}"
                            product-item-number-from-value="{{ old('product_item_number_from') ? old('product_item_number_from') : (isset($searchInputs['product_item_number_from']) ? $searchInputs['product_item_number_from'] : '') }}"
                            product-item-number-to-value="{{ old('product_item_number_to') ? old('product_item_number_to') : (isset($searchInputs['product_item_number_to']) ? $searchInputs['product_item_number_to'] : '') }}"
                        >
                        </ct-reports-ctr0023-form>

                    {!! Form::close() !!}

                </div>

            </div>

        </div>

    </div>

@endsection
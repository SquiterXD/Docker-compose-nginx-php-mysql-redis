@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2>
        <x-get-program-code url="/ct/ctr0029" /> กระดาษทำการคำนวณต้นทุนมาตราฐาน-งานระหว่างผลิต (ปลายงวด)
    </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">CT</a>
        </li>
        <li class="breadcrumb-item">
            กระดาษทำการคำนวณต้นทุนมาตราฐาน-งานระหว่างผลิต (ปลายงวด)
        </li>
    </ol>

@stop

@section('content')

    <div class="ibox">

        <div class="ibox-title">
            <h5> กระดาษทำการคำนวณต้นทุนมาตราฐาน-งานระหว่างผลิต (ปลายงวด) </h5> </h5>
        </div>

        <div class="ibox-content">

            <div class="justify-content-center clearfix">

                <div class="clearfix tw-my-6">

                    {!! Form::open(['route' => ['ct.ctr0029.export'], 'method' => 'post']) !!}

                        {{-- FORM INPUT --}}

                        <ct-reports-ctr0029-form 
                            :period-years="{{ json_encode($periodYears) }}"
                            :cost-codes="{{ json_encode($costCodes) }}"
                            :batch-nos="{{ json_encode($batchNos) }}"
                            :inv-items="{{ json_encode($invItems) }}"
                            period-year-value="{{ old('period_year') ? old('period_year') : (isset($searchInputs['period_year']) ? $searchInputs['period_year'] : '') }}"
                            cost-code-value="{{ old('cost_code') ? old('cost_code') : (isset($searchInputs['cost_code']) ? $searchInputs['cost_code'] : '') }}"
                            date-from-value="{{ old('date_from') ? old('date_from') : (isset($searchInputs['date_from']) ? $searchInputs['date_from'] : '') }}"
                            date-to-value="{{ old('date_to') ? old('date_to') : (isset($searchInputs['date_to']) ? $searchInputs['date_to'] : '') }}"
                            batch-no-from-value="{{ old('batch_no_from') ? old('batch_no_from') : (isset($searchInputs['batch_no_from']) ? $searchInputs['batch_no_from'] : '') }}"
                            batch-no-to-value="{{ old('batch_no_to') ? old('batch_no_to') : (isset($searchInputs['batch_no_to']) ? $searchInputs['batch_no_to'] : '') }}"
                            item-no-from-value="{{ old('item_no_from') ? old('item_no_from') : (isset($searchInputs['item_no_from']) ? $searchInputs['item_no_from'] : '') }}"
                            item-no-to-value="{{ old('item_no_to') ? old('item_no_to') : (isset($searchInputs['item_no_to']) ? $searchInputs['item_no_to'] : '') }}"
                            report-type-value="{{ old('report_type') ? old('report_type') : (isset($searchInputs['report_type']) ? $searchInputs['report_type'] : '') }}"
                        >
                        </ct-reports-ctr0029-form>

                    {!! Form::close() !!}

                </div>

            </div>

        </div>

    </div>

@endsection
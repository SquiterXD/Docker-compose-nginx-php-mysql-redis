@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2> <x-get-program-code url="/ct/std-cost-papers" /> กระดาษทำการต้นทุนมาตรฐาน : สรุปต้นทุน </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">CT</a>
        </li>
        <li class="breadcrumb-item">
            กระดาษทำการต้นทุนมาตรฐาน : สรุปต้นทุน
        </li>
    </ol>

@stop

@section('content')

    <ct-std-cost-papers-summarizes
        :default-data="{{ json_encode($defaultData) }}"
        :uom-codes="{{ json_encode($uomCodes) }}" 
        :year-control="{{ json_encode($yearControl) }}" 
        :period-year="{{ json_encode($periodYear) }}" 
        :cost-code="{{ json_encode($costCode) }}" 
        :plan-version-no="{{ json_encode($planVersionNo) }}" 
        :version-no="{{ json_encode($versionNo) }}" 
        :ct14-version-no="{{ json_encode($ct14VersionNo) }}" 
        :period-year-data="{{ json_encode($periodYearData) }}" 
        :period-from="{{ json_encode($periodFrom) }}" 
        :period-to="{{ json_encode($periodTo) }}" 
        :period-name-tos="{{ json_encode($periodNameTos) }}" 
        :allocate-types="{{ json_encode($allocateTypes) }}" 
        :allocate-year="{{ json_encode($allocateYear) }}"
        :latest-stdcost-year="{{ json_encode($latestStdcostYear) }}" 
        :stdcost-year="{{ json_encode($stdcostYear) }}" 
        :stdcost-prd-groups="{{ json_encode($stdcostPrdGroups) }}" 
        :stdcost-prd-group-totals="{{ json_encode($stdcostPrdGroupTotals) }}" 
        :stdcost-prd-group-totals-no-approve="{{ json_encode($stdcostPrdGroupTotalsNoApprove) }}"
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
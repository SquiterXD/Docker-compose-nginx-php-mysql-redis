@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2> <x-get-program-code url="/ct/std-cost-papers" /> กระดาษทำการต้นทุนมาตรฐาน : วัตถุดิบ </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">CT</a>
        </li>
        <li class="breadcrumb-item">
            กระดาษทำการต้นทุนมาตรฐาน : วัตถุดิบ
        </li>
    </ol>

@stop

@section('content')

    <ct-std-cost-papers-materials
        :default-data="{{ json_encode($defaultData) }}"
        :year-control="{{ json_encode($yearControl) }}"
        :period-year-data="{{ json_encode($periodYearData) }}"
        :period-from="{{ json_encode($periodFrom) }}"
        :period-to="{{ json_encode($periodTo) }}"
        :allocate-types="{{ json_encode($allocateTypes) }}"
        :stdcost-head="{{ json_encode($stdcostHead) }}"
        :stdcost-prds="{{ json_encode($stdcostPrds) }}"
        :stdcost-prds-not="{{ json_encode($stdcostPrdNot) }}"
        :stdcost-materials="{{ json_encode($stdcostMaterials) }}"
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

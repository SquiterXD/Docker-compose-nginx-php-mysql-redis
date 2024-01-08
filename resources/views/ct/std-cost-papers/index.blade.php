@extends('layouts.app')

@section('title', '')

@section('page-title')

    <h2> <x-get-program-code url="/ct/std-cost-papers" /> กระดาษทำการต้นทุนมาตรฐาน </h2>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">CT</a>
        </li>
        <li class="breadcrumb-item">
            กระดาษทำการต้นทุนมาตรฐาน
        </li>
    </ol>

@stop

@section('content')

    <ct-std-cost-papers-index
        :default-data="{{ json_encode($defaultData) }}"
        :ready-stdcost-years="{{ json_encode($readyStdcostYears) }}" 
        :year-controls="{{ json_encode($yearControls) }}" 
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
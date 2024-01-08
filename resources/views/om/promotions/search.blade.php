@extends('layouts.app')

@section('custom_css')
<link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
<style>
    div.dataTables_wrapper div.dataTables_length select{
        width: 75px!important;
    }
    .td-relative{
        position: relative;
    }
    .autocomplete {
        background: #fff;
        border: 1px solid #eeeeee;
        border-top: 0;
        position: initial;
        text-align: left;
        overflow: scroll;
        position: absolute;
        max-height: 220px;
        overflow-x: hidden; /* Hide horizontal scrollbar */
        right: 0;
        left: 0;
        z-index: 999;
    }
    .autocomplete::-webkit-scrollbar {
        display: none;
    }
    .autocomplete-list {
        padding: 10px;
        border-bottom: 1px solid #ededed;
        cursor: pointer;
    }
    .autocomplete-list:hover {
        background: #e7eaec;
    }
    table.custom-tb tbody {
        display: block;
        max-height: 800px;
        overflow-y: scroll;
    }

    table.custom-tb thead, table.custom-tb tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
</style>
<style>
    .btn-success {
        color: #fff !important;
        background-color: #1c84c6 !important;
        border-color: #1c84c6 !important;
    }
    .mx-datepicker .mx-input-wrapper input{
        height: auto;
    }
</style>
@stop
@section('title', 'OMS0003 กำหนด Promotion ส่งเสริมการขาย สำหรับขายในประเทศ')

@section('page-title')
    <h2><x-get-program-code url="/om/promotions" /> กำหนด Promotion ส่งเสริมการขาย สำหรับขายในประเทศ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าหลัก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/om/promotions" /> กำหนด Promotion ส่งเสริมการขาย สำหรับขายในประเทศ</strong>
        </li>
    </ol>
@stop

@section('content')

    <div class="ibox" id="app">
        <div class="ibox-title">
            <h3>กำหนด Promotion ส่งเสริมการขาย</h3>
        </div>
        <div class="ibox-content">

            <om-promotion-product></om-promotion-product>
        </div><!--ibox-content-->
    </div><!--ibox-->

@endsection

@section('scripts')

    <script>
        $(document).ready(function(){
            $('.date').datepicker();

            $('.i-checks-shop span').click(function() {
            $("#shopModal").modal('show');
            });
        })

        $('.i-checks-shop span').click(function() {
           $("#shopModal").modal('show');
        });
    </script>
@stop

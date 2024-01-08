@extends('layouts.app')
@section('title', $title)
@section('custom_css')
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
@stop
<style>
    select.form-control:not([size]):not([multiple]) {
        width: 50% !important;
    }
    #page-wrapper {
        padding: 0 15px;
        position: relative !important;
        flex-shrink: 1;
        width: calc(100% - 220px) !important;
    }
</style>
@section('page-title')
    <h2>
        <x-get-program-code url="{{ $urlText }}"/>: {{ $title }}
    </h2>
    <ol class="breadcrumb">
        {{-- <li class="breadcrumb-item active">
            <a>ใบเตรียมการขาย</a>
        </li> --}}
        <li class="breadcrumb-item active">
            <a>{{ $title }}</a>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5> {{ $title }} </h5>
                </div>
                <div class="ibox-content">
                    <om-prepare-order
                        type="{{ $type }}"
                        :payment-types="{{ json_encode($paymentTypes) }}"
                        :status="{{ json_encode($status) }}"
                        :url="{{ json_encode($url) }}"
                        date-format="{{ trans('date.oracle-format') }}"
                        :btn-trans="{{ json_encode($btnTrans) }}"
                        :search="{{ json_encode($search) }}"
                        :delivery-date="{{ json_encode($deliveryDate) }}"
                    >
                    </om-prepare-order>
                    <div class="hr-line-dashed"></div>
                    @if ($type == 'domestic')
                        @include('om.prepare-sale-order.domestic.line')
                    @else
                        @include('om.prepare-sale-order.export.line')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        // setTimeout( function() {
        //     var body = $('body');
        //     if (body.hasClass('fixed-sidebar')) {
        //         if (!body.hasClass('body-small')) {
        //             body.addClass('mini-navbar');
        //         }
        //     } else {
        //         if (!body.hasClass('body-small')) {
        //             body.addClass('mini-navbar');
        //         }
        //     }
        // },500)

        $(document).ready(function() {
            var dataTableDomestic = $('.domestic_table');
            var dataTableExport = $('.export_table');
            var loadingHtml = '<div class="sk-spinner sk-spinner-wave"> <div class="sk-rect1"></div> <div class="sk-rect2"></div> <div class="sk-rect3"></div> <div class="sk-rect4"></div> <div class="sk-rect5"></div> </div>';
            dataTableDomestic.DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                bFilter: false,
                aaSorting: [[1, "desc"]],
                bPaginate:true,
                bInfo: false,
                columnDefs: [
                ],
                language: {
                    loadingRecords: loadingHtml,
                },
                buttons: [
                ],
            });

            dataTableExport.DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                bFilter: false,
                aaSorting: [[1, "desc"]],
                bPaginate:true,
                bInfo: false,
                columnDefs: [
                ],
                language: {
                    loadingRecords: loadingHtml,
                },
                buttons: [
                ],
            });
        });
    </script>
@stop
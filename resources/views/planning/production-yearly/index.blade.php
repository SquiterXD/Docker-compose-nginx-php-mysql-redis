@extends('layouts.app')

@section('title', 'ประมาณการผลิตบุหรี่และก้นกรองประจำปี')

@section('page-title')
    <x-get-page-title menu="" url="/planning/production-yearly/-1"/>

    {{-- <h2><x-get-program-code url="/planning/production-biweekly"/> ประมาณการผลิตประจำปักษ์</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>ประมาณการผลิตประจำปี</a>
        </li>
        <li class="breadcrumb-item active">
            <a>ประมาณการผลิตประจำปักษ์</a>
        </li>
    </ol> --}}
@stop
@section('page-title-action')
    <button class="btn btn-primary btn-sm p-1" data-toggle="modal" data-target="#modal-create" data-backdrop="static" data-keyboard="false">
        <i class="fa fa-plus"></i> สร้าง
    </button>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> ประมาณการแผนรายปักษ์ </h5>
                </div>
                <div class="ibox-content">
                    {{-- <search-production-plan-component :budget-years="{{ json_encode($budgetYears) }}"
                        :bi-weekly="{{ json_encode($biWeekly) }}"
                        :search="{{ json_encode($search) }}"
                        :product-types="{{ json_encode($productTypes) }}"
                        inline-template>
                        @include('planning.production-biweekly._search')
                    </search-production-plan-component> --}}
                    <search-production-plan-component
                        :btn-trans="{{ json_encode(trans('btn')) }}"
                        :url="{{ json_encode($url) }}"

                        :budget-years="{{ json_encode($budgetYears) }}"
                        :bi-weekly="{{ json_encode($biWeekly) }}"
                        :search="{{ json_encode($search) }}"
                        :product-types="{{ json_encode($productTypes) }}"
                        >
                    </search-production-plan-component>
                    @include('planning.production-biweekly._table')


                    <create-production-plan-component
                        :budget-years="{{ json_encode($budgetYears) }}"
                        :bi-weekly="{{ json_encode($biWeekly) }}"
                        :search="{{ json_encode($search) }}"
                        :product-types="{{ json_encode($productTypes) }}"
                        :url="{{ json_encode($url) }}" />
                </div>
            </div>
        </div>
    </div>
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

        // $(document).ready(function () {
        //     var dataTable = $('.program_type_tb');
        //     var loadingHtml = '<div class="sk-spinner sk-spinner-wave"> <div class="sk-rect1"></div> <div class="sk-rect2"></div> <div class="sk-rect3"></div> <div class="sk-rect4"></div> <div class="sk-rect5"></div> </div>';
        //     dataTable.DataTable({
        //         pageLength: 25,
        //         responsive: true,
        //         dom: '<"html5buttons"B>lTfgitp',
        //         bFilter: false,
        //         aaSorting: [],
        //         bPaginate:true,
        //         bInfo: false,
        //         columnDefs: [
        //             { className: "text-center", "targets": [ 0, 4 ] , type: "string", orderable : false, },
        //             // { className: "text-center text-danger ", "targets": [ 8 ] , type: "string", orderable : false, },
        //         ],
        //         language: {
        //             loadingRecords: loadingHtml,
        //         },
        //         buttons: [
        //         ],
        //     });
        // });
    </script>
@stop
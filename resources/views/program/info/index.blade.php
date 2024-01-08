@extends('layouts.app')

@section('title', 'Program Info')

@section('page-title')
    <h2>Program Info</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a href="{{ route('program.info.index') }}">Program Type</a>
        </li>
    </ol>
@stop
@section('page-title-action')
    <a href="{{ route('program.info.create') }}" class="btn btn-success">
        <i class="fa fa-plus"></i> สร้างโปรแกรม
    </a>
    <a class="btn btn-white btn-md" data-toggle="collapse" href="#search_form" role="button" aria-expanded="false">
        <i class="fa fa-search"></i> ค้นหา
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <search-component :status-lists="{{ json_encode($statusLists) }}"
                    :types="{{ json_encode($programTypes ?? null) }}"
                    :module-lists="{{ json_encode($moduleLists ?? null) }}"
                    :search="{{ json_encode($search) }}"
                    inline-template>
                    @include('program.info._search', ['actionUrl' => route('program.info.index')])
                </search-component>
                <div class="ibox-title">
                    <h5> Program Info </h5>
                </div>
                <div class="ibox-content">
                    @include('program.info._table')
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
        }, 1000);

        $(document).ready(function () {
            var dataTable = $('.program_info_tb');
            var loadingHtml = '<div class="sk-spinner sk-spinner-wave"> <div class="sk-rect1"></div> <div class="sk-rect2"></div> <div class="sk-rect3"></div> <div class="sk-rect4"></div> <div class="sk-rect5"></div> </div>';
            dataTable.DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                bFilter: false,
                aaSorting: [],
                bPaginate:true,
                bInfo: false,
                columnDefs: [
                    { className: "text-center", "targets": [ 0 ] , type: "string", orderable : false },
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
@extends('layouts.app')

@section('title', 'Program Type')

@section('page-title')
    <h2>Program Type</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a href="{{ route('program.type.index') }}">Program Type</a>
        </li>
    </ol>
@stop
@section('page-title-action')
    <a href="{{ route('program.type.create') }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> สร้างชนิดโปรแกรม
    </a>
    <a class="btn btn-white btn-md" data-toggle="collapse" href="#search_form" role="button" aria-expanded="false">
        <i class="fa fa-search"></i> Search
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <search-component :status-lists="{{ json_encode($statusLists) }}"
                    :module-lists="{{ json_encode(null) }}"
                    :search="{{ json_encode($search) }}"
                    inline-template>
                    @include('program.type._search', ['actionUrl' => route('program.type.index')])
                </search-component>
                <div class="ibox-title">
                    <h5> Program Type </h5>
                </div>
                <div class="ibox-content">
                    @include('program.type._table')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var dataTable = $('.program_type_tb');
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
                    { className: "text-center", "targets": [ 0, 4 ] , type: "string", orderable : false, },
                    // { className: "text-center text-danger ", "targets": [ 8 ] , type: "string", orderable : false, },
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